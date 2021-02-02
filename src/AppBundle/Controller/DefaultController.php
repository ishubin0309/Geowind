<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projet;
use AppBundle\Entity\Liste;
use AppBundle\Helper\GridHelper;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\ExportOption;
use AppBundle\Model\Foncier;
use AppBundle\Model\Etat;
use AppBundle\Model\Progression;
use AppBundle\Model\Servitude;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'grid_helper' => $gridHelper,
            'export_option' => new ExportOption(),
        ]);
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

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'grid_helper' => $gridHelper,
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

        $users = $em->getRepository('AppBundle:User')->findBy([], ['username' => 'ASC']);
        $regions = $em->getRepository('AppBundle:Region')->findAll();
        $departements = $em->getRepository('AppBundle:Departement')->findAll();

        $typesProjet = Projet::getTypeProjetList(1);
        $typesSite = Projet::getTypeSiteList();
        $phases = Etat::getPhaseList();
        $progressions = Progression::getProgressionList();
        // $servitudes = Servitude::getServitudeList();
        // $fonciers = Foncier::getFoncierList();
        // $avisMairies = AvisMairie::getAvisMairieList();

        return $this->render('default/search.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'grid_helper' => $gridHelper,
            'users' => $users,
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
                        ->findUserProjets($this->getUser());
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
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findUserProjets($this->getUser());
        }

        $gridHelper = new GridHelper();

        return $this->render('default/proprietaires.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
        ]);
    }
}
