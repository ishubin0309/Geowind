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

        $deleteForm = $this->createDeleteForm($batiment);

        return $this->render('batiment/edit.html.twig', [
            'batiment' => $batiment,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="batiment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BatimentNouveau $batiment)
    {
        throw $this->createAccessDeniedException();
        
        $form = $this->createDeleteForm($batiment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $batiment->getNom();
            $em = $this->getDoctrine()->getManager();
            $em->remove($batiment);
            $em->flush();
            $batimentManager->removeBatiment($batiment);
            $this->addFlash('success', 'Batiment « ' . $nom . ' » supprimé avec succès.');
        }

        return $this->redirectToRoute('batiment_index');
    }

    /**
     * @param Batiment $batiment
     * @return Form The form
     */
    private function createDeleteForm(BatimentNouveau $batiment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('batiment_delete', ['id' => $batiment->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
