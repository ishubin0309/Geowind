<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projet;
use AppBundle\Entity\Liste;
use AppBundle\Entity\Terrain;
use AppBundle\Entity\Batiment;
use AppBundle\Entity\Etat;
use AppBundle\Entity\Tache;
use AppBundle\Entity\Parcelle;
use AppBundle\Model\Environnement;
use AppBundle\Form\ProjetEditType;
use AppBundle\Form\ProjetType;
use AppBundle\Form\ListeType;
use AppBundle\Helper\GridHelper;
use AppBundle\Model\ExportOption;
use AppBundle\Service\ProjetExport;
use DateTime;
use Imagick;
use mPDF;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/app/projets")
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProjetController extends Controller
{
    /**
     * @Route("/", name="projet_index", options = { "expose" = true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gridHelper = new GridHelper();

        $focus = $request->query->get('focus', null);
        $show = $request->query->get('show', null);

        if (!empty($show)) {
            $showIds = explode(',', $show);
        } else {
            $showIds = [];
        }

        if ($this->isGranted('ROLE_VIEW_ALL')) {

            if (!empty($showIds)) {
                $projets = $em->getRepository('AppBundle:Projet')
                        ->findById($showIds);
            } else {
                $projets = $em->getRepository('AppBundle:Projet')
                        ->findAll();
            }

        } else {

            if (!empty($showIds)) {
                $projets = $em->getRepository('AppBundle:Projet')
                        ->findUserProjetsById($this->getUser(), $showIds);
            } else {
                $projets = $em->getRepository('AppBundle:Projet')
                        ->findUserProjets($this->getUser());
            }
        }

        $focusIndex = 0;
        if ($focus !== null && is_numeric($focus)) {
            foreach ($projets as $index => $projet) {

                if ($projet->getId() === (int) $focus) {
                    $focusIndex = $index;
                }
            }
        }

        $exportOption = new ExportOption();
        
        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
            'focus_index' => $focusIndex,
            'show_ids' => $showIds,
            'show' => $show,
            'export_option' => $exportOption,
        ]);
    }
    
    /**
     * @Route("/archives", name="projet_archive", options = { "expose" = true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function archiveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $gridHelper = new GridHelper();
        $focus = $request->query->get('focus', null);

        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                    ->findAll(true);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                    ->findUserProjets($this->getUser(), true);
        }

        $focusIndex = 0;
        if ($focus !== null && is_numeric($focus)) {
            foreach ($projets as $index => $projet) {

                if ($projet->getId() === (int) $focus) {
                    $focusIndex = $index;
                }
            }
        }

        return $this->render('projet/archives.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
            'focus_index' => $focusIndex,
            'show' => null,
            'export_option' => new ExportOption(),
        ]);
    }

    /**
     * @Route("/liste/all", name="liste_all")
     * @Security("has_role('ROLE_VIEW')")
     */
    public function allListeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listes = $em->getRepository('AppBundle:Liste')->findAll();
        $html = '';
        foreach($listes as $liste) $html .= '<li><a href="'.$this->generateUrl('view_liste', array('liste' => $liste->getId())).'">'. str_replace('.csv', '', $liste->getListeOriginalName()).'</a></li>';
        return new Response($html);
    }

    /**
     * @Route("/liste/nouveau", name="liste_new")
     * @Security("has_role('ROLE_VIEW_ALL')")
     */
    public function newListeAction(Request $request)
    {
        $liste = new Liste();
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $search = $em->getRepository('AppBundle:Liste')->findOneBy(['listeOriginalName' => $liste->getListeOriginalName()]);
            if(!$search) {
                $em->persist($liste);
                $em->flush();

                $this->addFlash('success', 'La liste « ' . $liste->getListeOriginalName() . ' » a été créée.');
            } else {
                $liste = $search;
                $this->addFlash('warning', 'La liste « ' . $liste->getListeOriginalName() . ' » est déjà créée.');
            }
            $dir = $this->getParameter('document_upload_dir');
            $file_path = $dir . '/' . $liste->getListe();
            $row = 0;
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                $inseeColumn = false;
                $departementColumn = false;
                $latColumn = false;
                $lngColumn = false;
                $altitudeColumn = false;
                $environnementColumn = false;
                $topographieColumn = false;
                $typeProjetColumn = false;
                $typeSiteColumn = false;
                $potentielColumn = false;
                $parcelleColumn = false;
                $listEnvironnements = Environnement::getEnvironnementList();
                $listTypeProjets = Projet::getTypeProjetList();
                $listTypeSites = Projet::getTypeSiteList();
                set_time_limit(600);
                session_write_close();
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$row++) {
                        for ($c=0; $c < count($data); $c++) {
                            if($data[$c]=='INSEE_COM') $inseeColumn = $c;
                            elseif($data[$c]=='Department') $departementColumn = $c;
                            elseif($data[$c]=='Latitude') $latColumn = $c;
                            elseif($data[$c]=='Longitude') $lngColumn = $c;
                            elseif($data[$c]=='Altitude') $altitudeColumn = $c;
                            elseif($data[$c]=='Environnement' || $data[$c]=='Type de milieu') $environnementColumn = $c;
                            elseif($data[$c]=='Topographie') $topographieColumn = $c;
                            elseif($data[$c]=='Type de projet') $typeProjetColumn = $c;
                            elseif($data[$c]=='Type de site' || $data[$c]=='Type de bien') $typeSiteColumn = $c;
                            elseif($data[$c]=='Potentiel (MW)') $potentielColumn = $c;
                            elseif($data[$c]=='Parcelle') $parcelleColumn = $c;
                        }
                        if(false === $departementColumn || false === $latColumn || false === $lngColumn || false === $environnementColumn || false === $typeProjetColumn || false === $typeSiteColumn) {
                            $this->addFlash('danger', 'Le fichier manque des colonnes obligatoires.');
                            break;
                        }
                        continue;
                    }
                    // if($row > 50) break;
                    $denomination = $liste->getListeOriginalName() . '_' . substr(md5(serialize($data)),16);
                    $search = $em->getRepository('AppBundle:Projet')->findBy(['denomination' => $denomination]);
                    if(!$search) {
                        $projet = new Projet();
                        $projet->setListe($liste);
                        $projet->setOrigine($this->getUser());
                        $projet->setChefProjet($this->getUser());
                        $telephone = $this->getUser()->getTelephone();
                        $projet->setOrigineTelephone($telephone);
                        $projet->setChefProjetTelephone($telephone);
                        $projet->setDenomination($denomination);
                        $projet->setLatitude($data[$latColumn]);
                        $projet->setLongitude($data[$lngColumn]);
                        $env = array_search($data[$environnementColumn], $listEnvironnements);
                        if($env) $projet->setEnvironnement($env);
                        else $projet->setEnvironnement('foret');
                        $tProjet = array_search($data[$typeSiteColumn], $listTypeProjets);
                        if(!$tProjet) $tProjet = 'parc__eolien';
                        $projet->setTypeProjet($tProjet);
                        $tSite = array_search($data[$typeSiteColumn], $listTypeSites);
                        if(!$tSite) $tSite = 'terrain';
                        $projet->setTypeSite($tSite);
                        if($tProjet == 'parc__eolien' || $tProjet == 'eolienne_isolee') {
                            $projet->setTechnologie('eolienne');
                            $projet->setPuissanceUnitaire(126);
                            $projet->setDenomination('Esol_id');
                        } else {
                            if($tProjet=='toiture_solaire') $projet->setDenomination('Ptoit_id');
                            elseif($tProjet=='ferme_solaire') $projet->setDenomination('Psol_id');
                            elseif($tProjet=='ombriere_solaire') $projet->setDenomination('Pomb_id');
                            elseif($tProjet=='tracker_solaire') $projet->setDenomination('Ptra_id');
                            $projet->setTechnologie('photovoltaique');
                            $projet->setPuissanceUnitaire(300);
                        }
                        if($potentielColumn !== false) $projet->setPotentiel($data[$potentielColumn]);
                        if($tSite == 'terrain' && $altitudeColumn !== false) {
                            $terrain = new Terrain();
                            if($altitudeColumn !== false) $terrain->setAltitude($data[$altitudeColumn]);
                            if($topographieColumn !== false) $terrain->setTopographie($data[$topographieColumn]);
                            $projet->setTerrain($terrain);
                        } elseif($tSite == 'batiment_existant' || $tSite == 'nouveau_batiment') {
                            if($tSite == 'nouveau_batiment') $projet->setBatimentNouveau('type1');
                            $batiment = new Batiment();
                            $projet->setBatiment($batiment);
                        }
                        $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['nom' => $data[$departementColumn]]);
                        if($departement) {
                            $projet->setDepartement($departement);
                            if($inseeColumn !== false) {
                                $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $data[$inseeColumn]]);
                                if($commune) $projet->addCommune($commune);
                            }
                            if($parcelleColumn !== false && $data[$parcelleColumn]) {
                                $parcelle = new Parcelle();
                                $parcelle->setNom($data[$parcelleColumn]);
                                $parcelle->setDepartement($departement);
                                if($inseeColumn !== false) {
                                    if($commune) $parcelle->setCommune($commune->getNom() . ' (' . $commune->getInsee() . ')');
                                    else $parcelle->setCommune($data[$inseeColumn]);
                                }
                                $projet->addParcelle($parcelle);
                            }
                            $etat = new Etat();
                            $etat->setPhase('exploratoire');
                            $etat->setEtat('nouveau');
                            $etat->setDynamique('2');
                            $projet->addEtat($etat);
                            $tache = new Tache();
                            $tache->setObjet('servitudes');
                            $tache->setEtat('a_letude');
                            $tache->setDynamique('2');
                            $projet->addTache($tache);
                            $tache = new Tache();
                            $tache->setObjet('foncier');
                            $tache->setEtat('a_letude');
                            $tache->setDynamique('2');
                            $projet->addTache($tache);

                            $em->persist($projet);
                            $em->flush();
                        }
                    } else $this->addFlash('warning', 'Projet avec latitude et longitude ('.$data[$latColumn] . ',' . $data[$lngColumn].') déjà existe.');
                }
                fclose($handle);
            }
            return $this->redirectToRoute('view_liste', [
                'liste' => $liste->getId(),
            ]);
        }

        return $this->render('projet/newListe.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouveau", name="projet_new", options = { "expose" = true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function newAction(Request $request)
    {
        $gridHelper = new GridHelper();

        $projet = new Projet();
        $projet->setOrigine($this->getUser());
        $projet->setChefProjet($this->getUser());
        // $projet->setPartenaire($this->getUser());
        $telephone = $this->getUser()->getTelephone();
        $projet->setOrigineTelephone($telephone);
        $projet->setChefProjetTelephone($telephone);
        // $projet->setPartenaireTelephone($telephone);

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $liste = $em->getRepository('AppBundle:Liste')->findBy(['listeOriginalName' => 'Sans liste']);
            if(!$liste) {
                $liste = new Liste();
                $em->persist($liste);
            }
            $projet->setListe($liste);

            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'La fiche « ' . $projet->getDenomination()
                    . ' » a été créée.');

            return $this->redirectToRoute('projet_index', [
                'focus' => $projet->getId(),
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $telephones = $em->getRepository('AppBundle:User')->getFindAllTelephones();

        return $this->render('projet/new.html.twig', [
            'form' => $form->createView(),
            'grid_helper' => $gridHelper,
            'telephones' => json_encode($telephones)
        ]);
    }

    /**
     * @Route("/{id}/editer", name="projet_edit", options = { "expose" = true })
     * @Security("is_granted('edit', projet)")
     */
    public function editAction(Request $request, Projet $projet)
    {
        $gridHelper = new GridHelper();

        $form = $this->createForm(ProjetEditType::class, $projet);
        $form->handleRequest($request);

        $show = $request->query->get('show', null);

        if ($form->isSubmitted() && $form->isValid()) {

            $projet->setUpdatedAt(new DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'La fiche « ' . $projet->getDenomination()
                    . ' » a été modifiée.');
            
            if ($projet->isArchived()) {
                return $this->redirectToRoute('projet_archive', [
                    'focus' => $projet->getId(),
                ]);
            }

            return $this->redirectToRoute('projet_index', [
                'focus' => $projet->getId(),
                'show' => $show,
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $telephones = $em->getRepository('AppBundle:User')->getFindAllTelephones();

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
            'show' => $show,
            'grid_helper' => $gridHelper,
            'telephones' => json_encode($telephones)
        ]);
    }

    /**
     * @Route("/communes/search", name="commune_search", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $results = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Commune')->searchTerm($term);
        }

        $response->setData($results);
        return $response;
    }

    /**
     * @Route("/communes/search/jquery", name="commune_search_jquery", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesJqueryAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $results = [];
        $results2 = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Commune')->searchTerm($term);
            foreach($results as $result) {
                $results2[] = ['formatted' => trim(preg_replace('%\(.+?\)%', '', $result['text'])), 'value' => $result['text']];
            }
        }

        $response->setData($results2);
        return $response;
    }

    /**
     * @Route("/{id}/data", name="projet_data", options = { "expose" = true })
     * @Security("is_granted('view', projet)")
     */
    public function dataProjetAction(Request $request, Projet $projet)
    {
        $show = $request->query->get('show', null);

        return $this->render('projet/projet-data.html.twig', [
            'projet' => $projet,
            'show' => $show,
        ]);
    }

    // /**
    //  * @Route("/{id}/carte", name="projet_download", options = { "expose" = true })
    //  * @Security("is_granted('view', projet)")
    //  */
    // public function downloadCarteAction(Projet $projet)
    // {
    //     $dir = $this->getParameter('cartes_upload_dir');
    //     $path = $dir . '/' . $projet->getCarte();
    //     $response = new BinaryFileResponse($path);

    //     $filename = str_replace(['/', '\\'], ['', ''], $projet->getCarteOriginalName());
    //     $fallback = 'carte';

    //     $d = $response->headers->makeDisposition(
    //         ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    //         $filename,
    //         $fallback
    //     );

    //     $response->headers->set('Content-Disposition', $d);
    //     return $response;
    // }
    
    /**
     * @Route("/bulk-export-csv", name="projet_bulk_csv", options = { "expose" = true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function bulkExportCSVAction(Request $request)
    {
        $options = $request->request->get('selectedFields', []);
        $idsValues = $request->request->get('ids', '');
        $ids = explode(',', $idsValues);
        
        $em = $this->getDoctrine()->getManager();
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findById($ids);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findUserProjetsById($this->getUser(), $ids);
        }
        
        $exportOption = new ExportOption();
        $exportOption->setSelectedOptions($options);
        $projetExport = new ProjetExport();
        $csv = $projetExport->getBulkCSVString($exportOption, $projets);
        
        $filename = 'export.csv';
        
        return new Response($csv, 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Description' => 'File Transfer',
        ]);
    }
    
    /**
     * @Route("/{id}/export-csv", name="projet_csv", options = { "expose" = true })
     * @Security("is_granted('view', projet)")
     */
    public function exportCSVAction(Request $request, Projet $projet)
    {
        $options = $request->request->get('selectedFields', []);
        
        $exportOption = new ExportOption();
        $exportOption->setSelectedOptions($options);
        $projetExport = new ProjetExport();
        $csv = $projetExport->getCSVString($exportOption, $projet);
        
        $filename = 'export.csv';
        
        return new Response($csv, 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Description' => 'File Transfer',
        ]);
    }
    
    /**
     * @Route("/{id}/export-pdf", name="projet_pdf", options = { "expose" = true })
     * @Security("is_granted('view', projet)")
     */
    public function exportPDFction(Request $request, Projet $projet)
    {
        $show = null;
        
//            $image->setImageFormat('png');
//            echo $image;
//            
//            die();
    
        $dir = $this->getParameter('cartes_upload_dir');
        $path = $dir . '/' . $projet->getCarte();
        
        $dirDest = $this->getParameter('cartes_fiche_dir');
        $pathDest = $dirDest . '/' . $projet->getCarte() . '.jpg';
        
        if (!file_exists($pathDest)) {
            $image = new Imagick($path);
            $image->setImageFormat('jpeg');
            $image->setCompressionQuality(70);
            $image->scaleImage(2480, 0);
            $image->writeImage($pathDest);
        }
        
        $date = new DateTime('now');
        $mpdf = new mPDF('utf-8', 'A4', '', '', 10, 10, 10, 10);

        $html = $this->renderView('projet/fiche.html.twig', [
            'show' => null,
            'projet' => $projet,
            'date' => $date,
            'image_path' => $pathDest,
        ]);

        $name = str_replace(['\\', '/'], ['', ''], $projet->getDenomination());
        
        $mpdf->WriteHTML($html);
        $mpdf->Output($name . '.pdf', 'I');
    }

    /**
     * @Route("/delete/liste", name="liste_delete", options = { "expose" = true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_EDIT')")
     */
    public function deleteListeAction(Request $request)
    {
        $id = $request->request->get('id', []);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        if ($this->isGranted('ROLE_EDIT_ALL')) {
            $em = $this->getDoctrine()->getManager();
            $liste = $em->getRepository('AppBundle:Liste')->findOneBy(['id' => $id]);
            if($liste) {
                set_time_limit(300);
                $em->remove($liste);
                $em->flush();

                $this->addFlash('success', 'La liste « ' . $liste->getListeOriginalName() . ' » a été supprimée.');
                $response->setData(['success' => 1]);
            }
        }

        return $response;
    }

    /**
     * @Route("/delete/batch", name="projet_batch_delete", options = { "expose" = true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_EDIT')")
     */
    public function deleteProjetsAction(Request $request)
    {
        $ids = $request->request->get('ids', []);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        if ($this->isGranted('ROLE_EDIT_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findById($ids);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findUserProjetsById($this->getUser(), $ids);
        }

        $total = count($ids);
        $deleted = count($projets);

        foreach ($projets as $projet) {
            $em->remove($projet);
        }

        $em->flush();

        if ($deleted > 1) {
            $this->addFlash('success', $deleted . ' entrées supprimées sur ' . $total . '.');
        } else {
            $this->addFlash('success', $deleted . ' entrée supprimée sur ' . $total . '.');
        }

        $response = new JsonResponse();
        $response->setData(['success' => 1]);
        return $response;
    }
}
