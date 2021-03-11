<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Message;
use AppBundle\Form\UserType;
use AppBundle\Form\UserEditType;
use AppBundle\Service\AnnuaireMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/app/utilisateurs")
 * @Security("has_role('ROLE_ADMIN')")
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')
                    ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/secteurs", name="user_secteur")
     */
    public function secteurAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')
                    ->findAll();

        return $this->render('user/secteur.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/nouveau", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userManager = $this->get('AppBundle\Manager\UserManager');
        $user = $userManager->createUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($user->isSendCredentials()) {
                $this->nouveauMessage($user->getUsername(), $user->getEmail(), $user->getPlainPassword());
            }
            $userManager->saveUser($user);
            $this->addFlash('success', 'Utilisateur ' . $user->getUsername() . ' créé avec succès.');

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    private function nouveauMessage($user, $email, $password)
    {//$email = 'haffoudhimedtaieb@gmail.com';
        $message = new Message();
        $from = $this->getParameter('mailer_from');
        $message->setObject('Vos identifiants climactif');
        $body = 'Veuillez bien trouver ci-joint vos identifiants de connexion au site climactif.com' . "\n" . 'User: '.$user . "\n" . 'Mot de passe: '.$password;
        $message->setBody($body);
        $message->setFrom($from);
        $message->setReplyTo($from);
        $message->setTo($email);
        $annuaireMailer = new AnnuaireMailer($this->getParameter('mailer_api_key'));
        $errors = [];
        if ($annuaireMailer->handleMessage($message, $errors)) {
            $this->addFlash('success', 'Mail envoyé.');
        } else $this->addFlash('danger', 'Mail non envoyé.');
    }

    /**
     * @Route("/{id}/modifier", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $userManager = $this->get('AppBundle\Manager\UserManager');

        $form = $this->createForm(UserEditType::class, $user, array(
            'data_class' => 'AppBundle\Entity\User',
            'user' => $user->getId(),
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($user->isSendCredentials()) {
                $this->nouveauMessage($user->getUsername(), $user->getEmail(), $user->getPlainPassword());
            }
            $userManager->saveUser($user);
            $this->addFlash('success', 'Utilisateur ' . $user->getUsername() . ' modifié avec succès.');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/user", name="user_delete", options={ "expose": true })
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id', 0);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneBy(['id' => $id]);
        if($user) {
            $userManager = $this->get('AppBundle\Manager\UserManager');
            $username = $user->getUsername();
            $userManager->removeUser($user);
            $this->addFlash('success', 'Utilisateur ' . $username . ' supprimé avec succès.');
            $response->setData(['success' => 1]);
        }

        return $response;
    }
}
