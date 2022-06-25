<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Gestionnaire;

use AppBundle\Entity\MessageGestionnaire;
use AppBundle\Entity\MessageGestionnaireModel;
use AppBundle\Entity\User;
use AppBundle\Entity\LettreGestionnaire;
use AppBundle\Entity\Commune;
use AppBundle\Form\MessageGestionnaireModelType;
use AppBundle\Form\MessageGestionnaireType;
use AppBundle\Form\LettreGestionnaireType;
use AppBundle\Service\AnnuaireMailer;
use DateTime;

use AppBundle\Entity\Import;
use AppBundle\Form\ImportType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @Route("/app/gestionnaire")
 */
class GestionnaireController extends Controller
{
    /**
     * @Route("/", name="gestionnaire_index")
     */
    public function gestionnaireAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file_path = $import->getImportFile();
            $this->importFile($file_path);
        }

        $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')
                        ->findAll();

        $messages = $em->getRepository('AppBundle:MessageGestionnaire')
                        ->findAll();

        $lettres = $em->getRepository('AppBundle:LettreGestionnaire')
                        ->findAll();

        $models = $em->getRepository('AppBundle:MessageGestionnaireModel')
                        ->findBy([], ['name' => 'ASC']);

        return $this->render('gestionnaire/index.html.twig', [
            'gestionnaires' => $gestionnaires,
            'form' => $form->createView(),
            'messages' => $messages,
            'lettres' => $lettres,
            'models' => $models,
        ]);
    }

    /**
     * @Route("/csv/update", name="gestionnaire_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function gestionnaireUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file_path = __DIR__ . '/../Gestionnaires.csv';
        $row = 0;
        if(file_exists($file_path)) {
            $this->importFile($file_path);
            return new Response('Done');
        } else new Response('Fichier introuvable');
    }

    private function importFile($file_path)
    {
        $em = $this->getDoctrine()->getManager();

        if (($handle = fopen($file_path, "r")) !== FALSE) {
            ini_set("memory_limit", "4000M");
            set_time_limit(3000);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            $start_time = microtime(true);
            $write_close = false;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if(!$write_close) {
                    $end_time = microtime(true); 
                    $execution_time = ($end_time - $start_time); 
                    if($execution_time > 30) {
                        session_write_close();
                        $write_close = true;
                    }
                }
                if(!$row++) {
                    $gestionnaireColumn = 0;
                    $competenceColumn = 1;
                    $contactColumn = 2;
                    $fonctionColumn = 3;
                    $adresseColumn = 4;
                    $villeColumn = 5;
                    $emailColumn = 6;
                    $telephoneColumn = 7;
                    $departementColumn = 8;
                    $em->getRepository('AppBundle:Gestionnaire')->emptyTable();
                    continue;
                }
                // if($row > 10) continue;
                $data = array_map("utf8_encode", $data);
                $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['code' => $data[$departementColumn]]);
                if(empty($departement)) {
                    continue;
                }
                
                $gestionnaire = new Gestionnaire;

                if (false !== strpos($data[$emailColumn], '@')) {
                    $gestionnaire = $em->getRepository('AppBundle:Gestionnaire')->findOneBy(['email' => $data[$emailColumn]]);
                    if(empty($gestionnaire)) {
                        $gestionnaire = new Gestionnaire;
                    }
                }
                $gestionnaire->setGestionnaire($data[$gestionnaireColumn]);
                $gestionnaire->setCompetence($data[$competenceColumn]);
                $gestionnaire->setContact($data[$contactColumn]);
                $gestionnaire->setFonction($data[$fonctionColumn]);
                $gestionnaire->setAdresse($data[$adresseColumn]);
                $gestionnaire->setVille($data[$villeColumn]);
                $gestionnaire->setEmail($data[$emailColumn]);
                $gestionnaire->setTelephone($data[$telephoneColumn]);
                $gestionnaire->setDepartement($departement);
                $em->persist($gestionnaire);
                if($row % 50 == 0) {
                    $em->flush();
                    echo $row . ',';
                }
            }
            fclose($handle);
            $em->flush();
        }
    }

    /**
     * @Route("/nombre-totale", name="gestionnaire_count_all")
     */
    public function countAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $count = $em->getRepository('AppBundle:Gestionnaire')->findAllCount();
        $response = new Response($count);
        return $response;
    }

    /**
     * @Route("/export-csv", name="gestionnaire_export")
     */
    public function exportAction(Request $request)
    {

        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');

            $em = $this->getDoctrine()->getManager();
            $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')->findAll();
            fputcsv($handle, ['Gestionnaire','Compétence','Contact','Fonction','Adresse','Ville','Email','Téléphone','Département_num','Département_min','Département_maj'],',');
            foreach($gestionnaires as $gestionnaire) {
                fputcsv($handle, $gestionnaire->getRowForExport(), ',');
            }

            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="Gestionnaires.csv"');

        return $response;
    }

    /**
     * @Route("/search", name="gestionnaire_search", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $results = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Gestionnaire')->searchTerm($term);
        }

        $response->setData($results);
        return $response;
    }

    /**
     * @Route("/message/{id}/contact", name="gestionnaire_message", options={"expose": true})
     * @ParamConverter("gestionnaire", options={"mapping": {"id": "id"}})
     * @Method({"GET", "POST"})
     */
    public function messageAction(Request $request, Gestionnaire $gestionnaire, UserInterface $user)
    {
        /* @var $user User */
        
        $message = new MessageGestionnaire();
        $from = $this->getParameter('mailer_from');
        $message->setFrom($from);
        // $message->setReplyTo($user->getEmail());
        $message->setGestionnaire($gestionnaire);
        
        $form = $this->createForm(MessageGestionnaireType::class, $message, [
            'action' => $this->generateUrl('gestionnaire_message', ['id' => $gestionnaire->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $annuaireMailer = new AnnuaireMailer($this->getParameter('mailer_password'));
            
            $errors = [];
            $dir = $this->getParameter('document_upload_dir');
            $em->persist($message);
            if ($annuaireMailer->handleMessageGestionnaire($message, $errors, $dir)) {
                $em->flush();
                $this->addFlash('success', 'Mail envoyé.');
                return $this->redirectToRoute('gestionnaire_index');
                // return $this->redirectToRoute('gestionnaire_message', ['id' => $gestionnaire->getId()]);
            
            } else {
                $this->addFlash('error', 'Erreur');
            }
        }
        
        $models = $em->getRepository('AppBundle:MessageGestionnaireModel')
                        ->findBy([], ['name' => 'ASC']);
        
        if($request->isXmlHttpRequest()) $page = 'gestionnaire_ajax';
        else $page = 'gestionnaire';
        return $this->render('gestionnaire/'.$page.'.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'gestionnaire' => $gestionnaire,
        ]);
    }

    /**
     * @Route("/lettre/{id}/contact", name="gestionnaire_lettre", options={"expose": true})
     * @ParamConverter("gestionnaire", options={"mapping": {"id": "id"}})
     * @Method({"GET", "POST"})
     */
    public function mairieLettreAction(Request $request, Gestionnaire $gestionnaire, UserInterface $user)
    {
        /* @var $user User */
        
        $lettre = new LettreGestionnaire();
        $from = $this->getParameter('mailer_from');
        $lettre->setGestionnaire($gestionnaire);
        
        $form = $this->createForm(LettreGestionnaireType::class, $lettre, [
            'action' => $this->generateUrl('gestionnaire_lettre', ['id' => $gestionnaire->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($lettre);
            $em->flush();
            return $this->redirectToRoute('gestionnaire_index');
            // return $this->redirectToRoute('gestionnaire_lettre', ['id' => $gestionnaire->getId()]);
        }
        
        $models = $em->getRepository('AppBundle:MessageGestionnaireModel')
                        ->findBy([], ['name' => 'ASC']);

        if($request->isXmlHttpRequest()) $page = 'gestionnaire_ajax';
        else $page = 'gestionnaire';
        return $this->render('gestionnaire/'.$page.'.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'gestionnaire' => $gestionnaire,
        ]);
    }

    /**
     * @Route("/modele/nouveau", name="model_gestionnaire_new")
     * @Method({"GET", "POST"})
     */
    public function newModelAction(Request $request)
    {
        $model = new MessageGestionnaireModel();
        
        $form = $this->createForm(MessageGestionnaireModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();
            
            $this->addFlash('success', 'Modèle créé.');
            return $this->redirectToRoute('gestionnaire_index');
        }

        return $this->render('annuaire/model_new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
            'item' => 'gestionnaire',
        ]);
    }

    /**
     * @Route("/modele/{id}/modifier", name="model_gestionnaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editModelAction(Request $request, MessageGestionnaireModel $model)
    {
        $form = $this->createForm(MessageGestionnaireModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $this->addFlash('success', 'Modèle modifié.');
            return $this->redirectToRoute('gestionnaire_index');
        }

        return $this->render('annuaire/model_edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
            'item' => 'gestionnaire',
        ]);
    }

    /**
     * @Route("/modele/{id}/supprimer", name="model_gestionnaire_delete", options={ "expose": true })
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MessageGestionnaireModel $model)
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
     * @Route("/message/{id}/modifier", name="message_gestionnaire_edit", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_EDIT')")
     */
    public function editMessageAction(Request $request, MessageGestionnaire $message)
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
     * @Route("/lettre/{id}/modifier", name="lettre_gestionnaire_edit", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editLettreAction(Request $request, LettreGestionnaire $lettre)
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
                $lettre->setDateReminder($dateReminder);
                $em->persist($lettre);
                $em->flush();

                $this->addFlash('success', 'La date de rappel de la lettre « ' . $lettre->getObject() . ' » a été modifié.');
                $response->setData(['success' => 1]);
            }
        } elseif(in_array($result, ['?', '-', '+', 'R'])) {
            $em = $this->getDoctrine()->getManager();

            $lettre->setResult($result);
            $em->persist($lettre);
            $em->flush();

            $this->addFlash('success', 'Le résultat de la lettre « ' . $lettre->getObject() . ' » a été modifié.');
            $response->setData(['success' => 1]);
        }
        return $response;
    }

    /**
     * @Route("/message/{id}/supprimer", name="message_gestionnaire_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function messageDeleteAction(Request $request, MessageGestionnaire $message)
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
     * @Route("/lettre/{id}/supprimer", name="lettre_gestionnaire_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_EDIT')")
     */
    public function lettreDeleteAction(Request $request, LettreGestionnaire $lettre)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $sujet = $lettre->getObject();
        $em->remove($lettre);
        $em->flush();
        $this->addFlash('success', 'Lettre « '.$sujet.' » a été supprimée.');

        return $response;
    }
}
