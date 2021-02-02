<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ParcEolien;
use AppBundle\Form\ParcEolienType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/app/parcs-eoliens")
 */
class EolienController extends Controller
{
    /**
     * @Route("/", name="cartographie")
     */
    public function homeAction(Request $request)
    {
        $focus = $request->query->get('focus', null);
        
        $em = $this->getDoctrine()->getManager();
        $parcs = $em->getRepository('AppBundle:ParcEolien')
                        ->findAll();
        
        return $this->render('eolien/index.html.twig', array(
            'parcs' => $parcs,
            'focus_id' => $focus,
        ));
    }
    
    /**
     * @Route("/{id}/editer", name="parc_edit", options = { "expose" = true })
     */
    public function editAction(Request $request, ParcEolien $parcEolien)
    {
        $form = $this->createForm(ParcEolienType::class, $parcEolien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $parcEolien->setUpdatedAt(new DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($parcEolien);
            $em->flush();

            $this->addFlash('success', 'Parc éolien #' + $parcEolien->getId() 
                + ' modifié avec succès.');

            return $this->redirectToRoute('cartographie', [
                'focus' => $parcEolien->getId(),
            ]);
        }

        return $this->render('eolien/edit.html.twig', [
            'form' => $form->createView(),
            'parc' => $parcEolien,
        ]);
    }
    
    /**
     * @Route("/{id}/data", name="parc_data", options = { "expose" = true })
     */
    public function dataParcAction(Request $request, ParcEolien $parcEolien)
    {
        return $this->render('eolien/data.html.twig', [
            'parc' => $parcEolien,
        ]);
    }
    
    /**
     * @Route("/{id}/document", name="parc_download", options = { "expose" = true })
     */
    public function downloadCarteAction(ParcEolien $parc)
    {
        $dir = $this->getParameter('document_upload_dir');
        $path = $dir . '/' . $parc->getDocument();
        $response = new BinaryFileResponse($path);

        $filename = str_replace(['/', '\\'], ['', ''], $parc->getDocumentOriginalName());
        $fallback = 'carte';

        $d = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename,
            $fallback
        );

        $response->headers->set('Content-Disposition', $d);
        return $response;
    }
}
