<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BatimentNouveau;
use AppBundle\Form\BatimentNouveauType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/app/batiments")
 * @Security("has_role('ROLE_ADMIN')")
 *
 * @author Haffoudhi
 */
class BatimentController extends Controller
{
    /**
     * @Route("/", name="batiment_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $batiments = $em->getRepository('AppBundle:BatimentNouveau')
                    ->findAll();

        return $this->render('batiment/index.html.twig', [
            'batiments' => $batiments,
        ]);
    }

    /**
     * @Route("/nouveau", name="batiment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $batiment = new BatimentNouveau();

        $form = $this->createForm(BatimentNouveauType::class, $batiment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($batiment);
            $em->flush();

            $this->addFlash('success', 'Batiment « ' . $batiment->getNom() . ' » créé avec succès.');

            return $this->redirectToRoute('batiment_index');
        }

        return $this->render('batiment/new.html.twig', [
            'batiment' => $batiment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="batiment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BatimentNouveau $batiment)
    {

        $form = $this->createForm(BatimentNouveauType::class, $batiment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($batiment);
            $em->flush();

            $this->addFlash('success', 'Batiment « ' . $batiment->getNom() . ' » modifié avec succès.');
            return $this->redirectToRoute('batiment_index');
        }

        return $this->render('batiment/edit.html.twig', [
            'batiment' => $batiment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/batiment", name="batiment_delete", options = { "expose" = true })
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
        $batiment = $em->getRepository('AppBundle:BatimentNouveau')->findOneBy(['id' => $id]);
        if($batiment) {
            $nom = $batiment->getNom();
            $em->remove($batiment);
            $em->flush();

            $this->addFlash('success', 'Batiment « ' . $nom . ' » supprimé avec succès.');
            $response->setData(['success' => 1]);
        }

        return $response;
    }

}
