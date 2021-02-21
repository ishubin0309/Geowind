<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bureau;
use AppBundle\Form\BureauType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/app/bureaux-etudes")
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class BureauController extends Controller
{
    /**
     * @Route("/", name="bureau_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bureaux = $em->getRepository('AppBundle:Bureau')
                    ->findAll();

        return $this->render('bureau/index.html.twig', [
            'bureaux' => $bureaux,
        ]);
    }

    /**
     * @Route("/nouveau", name="bureau_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bureau = new Bureau();

        $form = $this->createForm(BureauType::class, $bureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($bureau);
            $em->flush();

            $this->addFlash('success', 'Bureau d\'études créé avec succès.');

            return $this->redirectToRoute('bureau_index');
        }

        return $this->render('bureau/new.html.twig', [
            'bureau' => $bureau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="bureau_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bureau $bureau)
    {
        $form = $this->createForm(BureauType::class, $bureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Bureau d\'études ' . $bureau->getNom() . ' modifié avec succès');
            return $this->redirectToRoute('bureau_index');
        }

        return $this->render('bureau/edit.html.twig', [
            'bureau' => $bureau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/bureau/{id}/supprimer", name="bureau_delete", options={ "expose": true })
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bureau $bureau)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $nom = $bureau->getNom();
        $em->remove($bureau);
        $em->flush();
        $this->addFlash('success', 'Bureau « '.$nom.' » a été supprimé.');

        return $response;
    }
}
