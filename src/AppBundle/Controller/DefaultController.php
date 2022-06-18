<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projet;
use AppBundle\Entity\Liste;
use AppBundle\Entity\MessageProprietaire;
use AppBundle\Helper\GridHelper;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\ExportOption;
use AppBundle\Model\Foncier;
use AppBundle\Model\Etat;
use AppBundle\Model\Progression;
use AppBundle\Model\Servitude;
use AppBundle\Service\AnnuaireMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/app")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllPaginator(false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllCount(false);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjets($this->getUser(), false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsCount($this->getUser(), false);
        }
        $totalPages = ceil($projetsTotal / $limit);

        $gridHelper = new GridHelper();
        $columnsType = isset($_GET['type']) && $_GET['type'] >= 1 ? trim($_GET['type']) : 1;

        $typesProjet = Projet::getTypeProjetList(1);

        $typeProjet = isset($_GET['typeProjet']) ? $_GET['typeProjet'] : '';
        $departement = isset($_GET['departement']) ? $_GET['departement'] : '';
        $origine = isset($_GET['origine']) ? $_GET['origine'] : '';
        $chefProjet = isset($_GET['chefProjet']) ? $_GET['chefProjet'] : '';
        $chargeFoncier = isset($_GET['chargeFoncier']) ? $_GET['chargeFoncier'] : '';
        $partenaire = isset($_GET['partenaire']) ? $_GET['partenaire'] : '0';

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'columnsType' => $columnsType,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
            'export_option' => new ExportOption(),
            'typeProjet' => $typeProjet,
            'departement' => $departement,
            'origine' => $origine,
            'chefProjet' => $chefProjet,
            'chargeFoncier' => $chargeFoncier,
            'partenaire' => $partenaire,
        ]);
    }
    /**
     * @Route("/fix-projets", name="fixprojets")
     */
    public function fixAction(Request $request)
    {

        /* $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository('AppBundle:Projet')->findAll();
        foreach($projets as $projet) {
            echo $projet->getId() . ': ' . $projet->calculeCompletude() . '%<br>';
            $em->persist($projet);
        }
        $em->flush(); */
        return new Response('done');
    }
    /**
     * @Route("/liste/{liste}", name="view_liste", requirements={"liste"="\d+"})
     */
    public function listeAction(Request $request, $liste)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllByListePaginator(false, $liste, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllByListeCount(false, $liste);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjetsByListe($this->getUser(), false, $liste, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsByListeCount($this->getUser(), $liste, false);
        }
        $totalPages = ceil($projetsTotal / $limit);
        $liste = $em->getRepository('AppBundle:Liste')->findOneBy(['id' => $liste]);
        $gridHelper = new GridHelper();
        $columnsType = isset($_GET['type']) && $_GET['type'] >= 1 ? trim($_GET['type']) : 1;

        $typesProjet = Projet::getTypeProjetList(1);

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'columnsType' => $columnsType,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
            'liste' => $liste,
            'export_option' => new ExportOption(),
        ]);
    }

    /**
     * @Route("/recherche", name="search_index")
     */
    public function searchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllPaginator(false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllCount(false);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjets($this->getUser(), false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsCount($this->getUser(), false);
        }
        $totalPages = ceil($projetsTotal / $limit);

        $gridHelper = new GridHelper();

        $regions = $em->getRepository('AppBundle:Region')->findAll();
        $departements = $em->getRepository('AppBundle:Departement')->findAll();

        $typesProjet = Projet::getTypeProjetList(1);
        $typesSite = Projet::getTypeSiteList();
        $phases = Etat::getPhaseList();
        $progressions = Etat::getEtatList();
        // $servitudes = Servitude::getServitudeList();
        // $fonciers = Foncier::getFoncierList();
        // $avisMairies = AvisMairie::getAvisMairieList();

        return $this->render('default/search.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'grid_helper' => $gridHelper,
            'regions' => $regions,
            'departements' => $departements,
            'typesProjet' => $typesProjet,
            'typesSite' => $typesSite,
            'phases' => $phases,
            'progressions' => $progressions,
            // 'servitudes' => $servitudes,
            // 'fonciers' => $fonciers,
            // 'avis_mairies' => $avisMairies,
        ]);
    }

    /**
     * @Route("/graphique", name="graphique")
     */
    public function graphiqueAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 10000;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllForStatsPaginator(false, $offset, $limit);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserForStatsProjets($this->getUser(), false, $offset, $limit);
        }

        $gridHelper = new GridHelper();

        $typesProjet = Projet::getTypeProjetList(1);

        return $this->render('default/graphique.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
        ]);
    }

    /**
     * @Route("/finance", name="finance_index")
     */
    public function financeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAll();
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAllUserProjets($this->getUser());
        }

        $gridHelper = new GridHelper();

        return $this->render('default/finance.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
        ]);
    }
    
    /**
     * @Route("/proprietaires", name="proprietaires")
     */
    public function proprietairesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAll();
            $messages = $em->getRepository('AppBundle:MessageProprietaire')
                        ->findAll();
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAllUserProjets($this->getUser());
            $messages = $em->getRepository('AppBundle:MessageProprietaire')
                        ->findBy(['createdBy' => $this->getUser()]);
        }

        $gridHelper = new GridHelper();

        return $this->render('default/proprietaires.html.twig', [
            'projets' => $projets,
            'messages' => $messages,
            'grid_helper' => $gridHelper,
        ]);
    }
    
    /**
     * @Route("/proprietaire/envoyer", name="proprietaire_send")
     * @Method({"POST"})
     * @Security("has_role('ROLE_EDIT')")
     */
    public function proprietaireSendAction(Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $annuaireMailer = new AnnuaireMailer($this->getParameter('mailer_password'));
        foreach($data['proprietaire'] as $key => $id) {
            if($id > 0) {
                $id = $id * 1;
                $type = 'proprietaire';
            } else {
                $id = $id * -1;
                $type = 'exploitant';
            }
            $proprietaire = $em->getRepository('AppBundle:Proprietaire')->findOneBy(['id' => $id]);
            $message_to = $data['message_to'][$key];
            $message_to_array = explode(',', $message_to);
            foreach($message_to_array as $to) {
                if(trim($to)) {
                    $messageProprietaire = new MessageProprietaire();
                    $messageProprietaire->setProprietaire($proprietaire);
                    if($type != 'proprietaire') $messageProprietaire->setExploitant(true);
                    $messageProprietaire->setTo(trim($to));
                    $messageProprietaire->setObject($data['message_object']);
                    $messageProprietaire->setBody($data['message_body']);
                    $errors = [];
                    if ($annuaireMailer->handleMessageProprietaire($messageProprietaire, $errors)) {
                        $em->persist($messageProprietaire);
                        $em->flush();
                        $this->addFlash('success', 'Mail envoyé à '.trim($to).'.');
                    } else {
                        $this->addFlash('error', 'Erreur: Mail non envoyé à '.trim($to).'.');
                    }
                }
            }
        }
        // echo '<pre>';print_r($data);die;

        return $this->redirectToRoute('proprietaires');
    }

    /**
     * @Route("/proprietaire/message/{id}/supprimer", name="proprietaire_message_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function proprietaireMessageDeleteAction(Request $request, MessageProprietaire $messageProprietaire)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $sujet = $messageProprietaire->getObject();
        $em->remove($messageProprietaire);
        $em->flush();
        $this->addFlash('success', 'Message « '.$sujet.' » a été supprimé.');

        return $response;
    }
}
