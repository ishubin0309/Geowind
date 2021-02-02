<?php

namespace AppBundle\Controller;

use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class AuthenticationController extends Controller
{
    /**
     * @Route("/app/login", name="login")
     */
    public function loginAction()
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('homepage');
        }

        $helper = $this->get('security.authentication_utils');
        $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        $exception = $helper->getLastAuthenticationError();

        return $this->render('authentication/login.html.twig', array(
            'csrf_token' => $csrfToken,
            'last_username' => $helper->getLastUsername(),
            'exception' => $exception,
        ));
    }

    /**
     * @Route("/app/login/check", name="login_check")
     */
    public function loginCheckAction()
    {
        throw new RuntimeException();
    }

    /**
     * @Route("/app/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new RuntimeException();
    }
}
