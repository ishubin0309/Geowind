<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mairie;
use AppBundle\Entity\Message;
use AppBundle\Entity\MessageModel;
use AppBundle\Entity\User;
use AppBundle\Entity\Appel;
use AppBundle\Entity\Commune;
use AppBundle\Form\MessageModelType;
use AppBundle\Form\MessageType;
use AppBundle\Form\AppelType;
use AppBundle\Service\AnnuaireMailer;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/app/annuaire")
 */
class AnnuaireController extends Controller
{
    /**
     * @Route("/", name="annuaire_index")
     */
    public function annuaireAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('AppBundle:Message')
                        ->findAll();

        $appels = $em->getRepository('AppBundle:Appel')
                        ->findAll();
        
        $models = $em->getRepository('AppBundle:MessageModel')
                        ->findBy([], ['name' => 'ASC']);

        $regions = $em->getRepository('AppBundle:Region')
                        ->findAll();

        return $this->render('annuaire/annuaire.html.twig', [
            'messages' => $messages,
            'appels' => $appels,
            'models' => $models,
            'regions' => $regions,
        ]);
    }
    
    /**
     * @Route("/{id}/mairie/edit", name="mairie_edit", options={ "expose": true })
     * @ParamConverter("Mairie", options={"mapping": {"id": "id"}})
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editMairieAction(Request $request, Mairie $mairie)
    {
        $response = new JsonResponse();

        $data = $request->request->all();

        $status = 0;
        $em = $this->getDoctrine()->getManager();
        if(isset($data['order']) && isset($data['elu']) && isset($data['email']) && isset($data['telephone'])) {
            $elus = $mairie->getElus();
            if(isset($data['order'])) {
                $function = isset($elus[$data['order']]['funtion']) ? $elus[$data['order']]['funtion'] : $elus[$data['order']]['function'];
                $elus[$data['order']] = ['function' => $function, 'nom' => trim($data['elu']), 'email' => trim($data['email']), 'telephone' => trim($data['telephone'])];
                $mairie->setElus($elus);
                $em->persist($mairie);
                $status = 1;
            }
        } elseif(isset($data['telephone'])) {
            $mairie->setTelephone(trim($data['telephone']));
            $em->persist($mairie);
            $status = 1;
        } elseif(isset($data['email1'])) {
            $mairie->setEmail1(trim($data['email1']));
            $em->persist($mairie);
            $status = 1;
        }
        $em->flush();

        $results = ['status' => $status];

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/mairie/search", name="mairie_search", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $results = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Mairie')->searchTerm($term);
        }

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/{id}/search-by-commune", name="mairie_search_by_commune", options={ "expose": true })
     * @ParamConverter("commune", options={"mapping": {"id": "id"}})
     * @Method({"POST"})
     * @Security("has_role('ROLE_VIEW')")
     */
    public function mairieSearchByCommuneAction(Request $request, Commune $commune)
    {
        $response = new JsonResponse();

        $results = ['mairie' => []];
        $em = $this->getDoctrine()->getManager();
        $mairie = $em->getRepository('AppBundle:Mairie')->findOneBy(['insee' => $commune->getInsee()]);
        if($mairie) {
            $results['mairie']['id'] = $mairie->getId();
            $results['mairie']['text'] = $mairie->getMairie() . ' (' . $mairie->getInsee() . ')';
            $results['mairie']['telephone'] = $mairie->getTelephone();
            $results['mairie']['maire'] = $mairie->getNomMaire() . ' ' . $mairie->getPrenomMaire();
            $elus = $mairie->getElus();
            foreach($elus as $elu) {
                $function = isset($elu['funtion']) ? $elu['funtion'] : $elu['function'];
                if($function == 'Maire') {
                    $results['mairie']['maire'] = $elu['nom'];
                }
            }
        }

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/mairie/{insee}/contact", name="annuaire_mairie", options={"expose": true})
     * @ParamConverter("mairie", options={"mapping": {"insee": "insee"}})
     * @Method({"GET", "POST"})
     */
    public function mairieAction(Request $request, Mairie $mairie, UserInterface $user)
    {
        /* @var $user User */
        
        $message = new Message();
        $from = $this->getParameter('mailer_from');
        $message->setFrom($from);
        // $message->setReplyTo($user->getEmail());
        $message->setMairie($mairie);
        
        $form = $this->createForm(MessageType::class, $message, [
            'action' => $this->generateUrl('annuaire_mairie', ['insee' => $mairie->getInsee()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $annuaireMailer = new AnnuaireMailer($this->getParameter('mailer_password'));
            
            $errors = [];
            $dir = $this->getParameter('document_upload_dir');
            $em->persist($message);
            exit('*' . $message->getDocument());
            if ($annuaireMailer->handleMessage($message, $errors, $dir)) {
                $em->flush();
                $this->addFlash('success', 'Mail envoyé.');
                return $this->redirectToRoute('annuaire_index');
                return $this->redirectToRoute('annuaire_mairie', ['insee' => $mairie->getInsee()]);
            
            } else {
                $this->addFlash('error', 'Erreur');
            }
        }
        
        $models = $em->getRepository('AppBundle:MessageModel')
                        ->findBy([], ['name' => 'ASC']);
        $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $mairie->getInsee()]);
        if($request->isXmlHttpRequest()) $page = 'mairie_ajax';
        else $page = 'mairie';
        return $this->render('annuaire/'.$page.'.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'mairie' => $mairie,
            'commune' => $commune,
        ]);
    }
    
    /**
     * @Route("/mairie/appel/{insee}/contact", name="annuaire_mairie_appel", options={"expose": true})
     * @ParamConverter("mairie", options={"mapping": {"insee": "insee"}})
     * @Method({"GET", "POST"})
     */
    public function mairieAppelAction(Request $request, Mairie $mairie, UserInterface $user)
    {
        /* @var $user User */
        
        $appel = new Appel();
        $from = $this->getParameter('mailer_from');
        $appel->setMairie($mairie);
        
        $form = $this->createForm(AppelType::class, $appel, [
            'action' => $this->generateUrl('annuaire_mairie_appel', ['insee' => $mairie->getInsee()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($appel);
            $em->flush();
            return $this->redirectToRoute('annuaire_index');
            return $this->redirectToRoute('annuaire_mairie_appel', ['insee' => $mairie->getInsee()]);
        }
        
        $models = $em->getRepository('AppBundle:MessageModel')
                        ->findBy([], ['name' => 'ASC']);
        $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $mairie->getInsee()]);

        if($request->isXmlHttpRequest()) $page = 'mairie_ajax';
        else $page = 'mairie';
        return $this->render('annuaire/'.$page.'.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'mairie' => $mairie,
            'commune' => $commune,
        ]);
    }
    
    /**
     * @Route("/modele/nouveau", name="model_new")
     * @Method({"GET", "POST"})
     */
    public function newModelAction(Request $request)
    {
        $model = new MessageModel();
        
        $form = $this->createForm(MessageModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();
            
            $this->addFlash('success', 'Modèle créé.');
            return $this->redirectToRoute('annuaire_index');
        }

        return $this->render('annuaire/model_new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/modele/{id}/modifier", name="model_edit")
     * @Method({"GET", "POST"})
     */
    public function editModelAction(Request $request, MessageModel $model)
    {
        $form = $this->createForm(MessageModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $this->addFlash('success', 'Modèle modifié.');
            return $this->redirectToRoute('annuaire_index');
        }

        return $this->render('annuaire/model_edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modele/{id}/supprimer", name="model_delete", options={ "expose": true })
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MessageModel $model)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($model);
        $em->flush();
        $this->addFlash('success', 'Modèle a été supprimé.');

        return $response;
    }
    
    /**
     * @Route("/message/{id}/modifier", name="message_edit", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_EDIT')")
     */
    public function editMessageAction(Request $request, Message $message)
    {
        $result = $request->request->get('result', '?');
        $dateReminder = $request->request->get('dateReminder', null);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        if($dateReminder) {
            if($dateReminder >= date('d/m/Y')) {
                $em = $this->getDoctrine()->getManager();

                $dateReminder = new DateTime(str_replace('/', '-', $dateReminder));
                $message->setDateReminder($dateReminder);
                $em->persist($message);
                $em->flush();

                $this->addFlash('success', 'La date de rappel du message « ' . $message->getObject() . ' » a été modifié.');
                $response->setData(['success' => 1]);
            }
        } elseif(in_array($result, ['?', '-', '+', 'R'])) {
            $em = $this->getDoctrine()->getManager();

            $message->setResult($result);
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Le résultat du message « ' . $message->getObject() . ' » a été modifié.');
            $response->setData(['success' => 1]);
        }
        return $response;
    }
    
    /**
     * @Route("/appel/{id}/modifier", name="appel_edit", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAppelAction(Request $request, Appel $appel)
    {
        $result = $request->request->get('result', '?');
        $dateReminder = $request->request->get('dateReminder', null);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        if($dateReminder) {
            if($dateReminder >= date('d/m/Y')) {
                $em = $this->getDoctrine()->getManager();

                $dateReminder = new DateTime(str_replace('/', '-', $dateReminder));
                $appel->setDateReminder($dateReminder);
                $em->persist($appel);
                $em->flush();

                $this->addFlash('success', 'La date de rappel d\'appel « ' . $appel->getObject() . ' » a été modifié.');
                $response->setData(['success' => 1]);
            }
        } elseif(in_array($result, ['?', '-', '+', 'R'])) {
            $em = $this->getDoctrine()->getManager();

            $appel->setResult($result);
            $em->persist($appel);
            $em->flush();

            $this->addFlash('success', 'Le résultat d\'appel « ' . $appel->getObject() . ' » a été modifié.');
            $response->setData(['success' => 1]);
        }
        return $response;
    }

    /**
     * @Route("/message/{id}/supprimer", name="message_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function messageDeleteAction(Request $request, Message $message)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $sujet = $message->getObject();
        $em->remove($message);
        $em->flush();
        $this->addFlash('success', 'Message « '.$sujet.' » a été supprimé.');

        return $response;
    }

    /**
     * @Route("/appel/{id}/supprimer", name="appel_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_EDIT')")
     */
    public function appelDeleteAction(Request $request, Appel $appel)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $sujet = $appel->getObject();
        $em->remove($appel);
        $em->flush();
        $this->addFlash('success', 'Appel « '.$sujet.' » a été supprimé.');

        return $response;
    }
}
