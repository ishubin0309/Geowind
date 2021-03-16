<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BatimentNouveau;
use AppBundle\Entity\News;
use AppBundle\Entity\Docs;
use AppBundle\Form\BatimentNouveauType;
use AppBundle\Form\NewsType;
use AppBundle\Form\DocsType;
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

        $news = $em->getRepository('AppBundle:News')
                    ->findAll();

        $docs = $em->getRepository('AppBundle:Docs')
                    ->findAll();

        return $this->render('batiment/index.html.twig', [
            'batiments' => $batiments,
            'news' => $news,
            'docs' => $docs,
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

    /**
     * @Route("/news/nouveau", name="news_new")
     * @Method({"GET", "POST"})
     */
    public function newNewsAction(Request $request)
    {
        $news = new News();
        return $this->news($request, $news, 1);
    }

    /**
     * @Route("/{id}/news/modifier", name="news_edit")
     * @Method({"GET", "POST"})
     */
    public function editNewsAction(Request $request, News $news)
    {
        return $this->news($request, $news, 0);
    }
    private function news($request, $news, $isNew=1)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            if($isNew) $this->addFlash('success', 'News crée avec succès.');
            else $this->addFlash('success', 'News modifié avec succès.');

            if($isNew) return $this->redirectToRoute('news_new');
            else return $this->redirectToRoute('batiment_index');
        }

        return $this->render('batiment/news.html.twig', [
            'news' => $news,
            'isNew' => $isNew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/docs/nouveau", name="docs_new")
     * @Method({"GET", "POST"})
     */
    public function newDocsAction(Request $request)
    {
        $docs = new Docs();
        return $this->docs($request, $docs, 1);
    }

    /**
     * @Route("/{id}/docs/modifier", name="docs_edit")
     * @Method({"GET", "POST"})
     */
    public function editDocsAction(Request $request, Docs $docs)
    {
        return $this->docs($request, $docs, 0);
    }
    private function docs($request, $docs, $isNew=1)
    {
        $form = $this->createForm(DocsType::class, $docs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($docs);
            $em->flush();
            if($isNew) $this->addFlash('success', 'Docs crée avec succès.');
            else $this->addFlash('success', 'Docs modifié avec succès.');
            if($isNew) return $this->redirectToRoute('docs_new');
            else return $this->redirectToRoute('batiment_index');
        }

        return $this->render('batiment/docs.html.twig', [
            'docs' => $docs,
            'isNew' => $isNew,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/news/{id}/supprimer", name="news_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newsDeleteAction(Request $request, News $news)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $titre = $news->getTitre();
        $em->remove($news);
        $em->flush();
        $this->addFlash('success', 'News « '.$titre.' » a été supprimé.');

        return $response;
    }

    /**
     * @Route("/docs/{id}/supprimer", name="docs_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function docsDeleteAction(Request $request, Docs $docs)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $titre = $docs->getTitre();
        $em->remove($docs);
        $em->flush();
        $this->addFlash('success', 'Doc « '.$titre.' » a été supprimé.');

        return $response;
    }

}
