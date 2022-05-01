<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Gestionnaire;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

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

        $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')
                        ->findAll();

        return $this->render('gestionnaire/gestionnaire.html.twig', [
            'gestionnaires' => $gestionnaires,
        ]);
    }
}
