<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projet;
use AppBundle\Entity\Liste;
use AppBundle\Entity\Rappel;
use AppBundle\Entity\Terrain;
use AppBundle\Entity\Batiment;
use AppBundle\Entity\Etat;
use AppBundle\Entity\Enjeux;
use AppBundle\Entity\Tache;
use AppBundle\Entity\Parcelle;
use AppBundle\Entity\Commune;
use AppBundle\Entity\Messagerie;
use AppBundle\Entity\Mairie;
use AppBundle\Model\Environnement;
use AppBundle\Model\Etat as EtatModel;
use AppBundle\Form\ProjetEditType;
use AppBundle\Form\ProjetType;
use AppBundle\Form\ListeType;
use AppBundle\Form\RappelType;
use AppBundle\Helper\GridHelper;
use AppBundle\Model\ExportOption;
use AppBundle\Service\ProjetExport;
use DateTime;
use Imagick;
use Mpdf\Mpdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
                        ->findAllUserProjets($this->getUser());
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
                    ->findAllUserProjets($this->getUser(), true);
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
     * @Route("/commune-president/update", name="commune_president_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function communePresidentUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file_path = __DIR__ . '/../03_EPCI.csv';
        $row = 0;
        if(file_exists($file_path)) {
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                ini_set("memory_limit", "4000M");
                set_time_limit(3000);
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $start_time = microtime(true);
                $write_close = false;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$write_close) {
                        $end_time = microtime(true); 
                        $execution_time = ($end_time - $start_time); 
                        if($execution_time > 30) {
                            session_write_close();
                            $write_close = true;
                        }
                    }
                    if(!$row++) {
                        $epciColumn = 0;
                        $nomPresidentColumn = 2;
                        $epciTelephoneColumn = 5;
                        $epciEmailColumn = 6;
                        continue;
                    }
                    // if($row > 10) continue;
                    $data = array_map("utf8_encode", $data);
                    // if($data[$epciColumn] != '240100883') continue;
                    // echo $row . ': Insee ' . $data[$epciColumn] . '<br>';
                    $communes = $em->getRepository('AppBundle:Commune')->findBy(['intercommunaliteEpci' => $data[$epciColumn]]);
                    if(empty($communes)) {
                        continue;
                    }//echo $commune->getInsee().', ' . $data[$epciTelephoneColumn] . ', ' . $data[$epciEmailColumn] . '<br>';
                    foreach($communes as $commune) {
                        $commune->setNomPresident($data[$nomPresidentColumn]);
                        $commune->setTelephonePresident($data[$epciTelephoneColumn]);
                        $commune->setEmailPresident($data[$epciEmailColumn]);
                        $em->persist($commune);
                    }
                    if($row % 50 == 0) {
                        $em->flush();
                        echo $row . ',';
                    }
                }
                fclose($handle);
                $em->flush();
            }
            return new Response('Done');
        } else new Response('Fichier introuvable');
    }

    /**
     * @Route("/mairie/update", name="mairie_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function mairieUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file_path = __DIR__ . '/../02_Mairies.csv';
        $row = 0;
        $row2 = 0;
        $min_row = 0;
        if(file_exists(__DIR__ . '/../mairie_counter.txt')) $min_row = file_get_contents(__DIR__ . '/../mairie_counter.txt');
        if(file_exists($file_path)) {
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                ini_set("memory_limit", "4000M");
                set_time_limit(3000);
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $start_time = microtime(true);
                $write_close = false;
                $last_insee = false;
                $last_mairie = false;
                $elus = [];
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$write_close) {
                        $end_time = microtime(true); 
                        $execution_time = ($end_time - $start_time); 
                        if($execution_time > 30) {
                            session_write_close();
                            $write_close = true;
                        }
                    }
                    $row2++;
                    if(!$row++) {
                        $inseeColumn = 0;
                        $communeColumn = 1;
                        $eluColumn = 2;
                        $eluFonctionColumn = 3;
                        $eluEmailColumn = 4;
                        $eluTelephoneColumn = 5;
                        $mairieTelephoneColumn = 6;
                        $mairieEmailColumn = 7;
                        $departementColumn = 8;
                        $adresseColumn = 10;
                        continue;
                    }
                    if($row < $min_row) continue;
                    $data = array_map("utf8_encode", $data);
                    if($last_mairie !== false && $data[$inseeColumn] != $last_insee) {
                        // echo $row . ': Insee ' . $last_mairie->getInsee() . ' Persist, ';
                        // $em->persist($last_mairie);
                        $last_mairie = false;
                        $elus = [];
                        if($row2 > 500) {
                            $em->flush();
                            $row2 = 0;
                            file_put_contents(__DIR__ . '/../mairie_counter.txt', $row);
                        }
                        // if($row > ($min_row + 10000)) break;
                    }
                    $last_insee = $data[$inseeColumn];
                    // echo $row . ': Insee ' . $data[$inseeColumn] . '<br>';
                    if($last_mairie === false) {
                        $last_mairie = $em->getRepository('AppBundle:Mairie')->findOneBy(['insee' => $data[$inseeColumn]]);
                        if(!$last_mairie) {
                            $last_mairie = new Mairie();
                            $last_mairie->setInsee($data[$inseeColumn]);
                            $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['code' => $data[$departementColumn]]);
                            if(!$departement) continue;
                            $last_mairie->setRegion($departement->getRegion()->getNom());
                        }
                    }
                    $last_mairie->setTelephone($data[$mairieTelephoneColumn]);
                    $last_mairie->setEmail1($data[$mairieEmailColumn]);
                    $last_mairie->setEmail2(null);
                    $last_mairie->setEmail3(null);
                    $last_mairie->setEmail4(null);
                    $last_mairie->setEmail5(null);
                    $last_mairie->setFax(null);
                    $last_mairie->setSiteinternet(null);
                    if($data[$communeColumn]) $last_mairie->setCommune($data[$communeColumn]);
                    if($data[$eluFonctionColumn] == 'Maire') {
                        $fullName = explode(' ', $data[$eluColumn]);
                        $last_mairie->setNomMaire($fullName[0]);
                        $last_mairie->setPrenomMaire(trim(str_replace($fullName[0], '', $data[$eluColumn])));
                    } else {
                        $elus[] = ['function' => $data[$eluFonctionColumn], 'nom' => $data[$eluColumn], 'email' => $data[$eluEmailColumn], 'telephone' => $data[$eluTelephoneColumn]];
                        $last_mairie->setElus($elus);
                    }
                }
                fclose($handle);
                $em->flush();
            }
            return new Response('Done');
        } else return new Response('Fichier introuvable');
    }

    /**
     * @Route("/commune/update", name="commune_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function communeUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file_path = __DIR__ . '/../01_Admin.csv';
        $row = 0;
        $row2 = 0;
        if(file_exists($file_path)) {
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                ini_set("memory_limit", "4000M");
                set_time_limit(3000);
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                $start_time = microtime(true);
                $write_close = false;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$write_close) {
                        $end_time = microtime(true); 
                        $execution_time = ($end_time - $start_time); 
                        if($execution_time > 30) {
                            session_write_close();
                            $write_close = true;
                        }
                    }
                    if(!$row++) {
                        $inseeColumn = 3;
                        $nomColumn = 4;
                        $nomMinisculeColumn = 5;
                        $departementColumn = 6;
                        $intercommunaliteColumn = 7;
                        $intercommunaliteNbColumn = 8;
                        $communePopColumn = 9;
                        $communeCpColumn = 10;
                        $intercommunaliteEpciColumn = 11;
                        $vitesseVentColumn = 12;
                        $productiblePvColumn = 14;
                        $intercommunalitePopColumn = 13;
                        $urbanismeTypeColumn = 15;
                        $urbanismeEtatColumn = 16;
                        $altitudeColumn = 17;
                        $reliefColumn = 18;
                        continue;
                    }//echo '<pre>';print_r($data);die;
                    // if($row > 25000) break;
                    // if($row < 34270) continue;
                    $data = array_map("utf8_encode", $data);
                    // echo $row . ': Insee ' . $data[$inseeColumn] . '<br>';
                    $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $data[$inseeColumn]]);
                    if(!$commune) {
                        echo 'Insee ' . $data[$inseeColumn] . ' New<br>';
                        $commune = new Commune();
                        $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['code' => $data[$departementColumn]]);
                        if(!$departement) continue;
                        $commune->setDepartement($departement);
                        $commune->setNom($data[$nomColumn]);
                        $commune->setInsee($data[$inseeColumn]);
                        $commune->setCode(substr($data[$inseeColumn], -3));
                    } else if($commune->getNom() == $data[$nomColumn]) continue;
                    $row2++;
                    $commune->setNom($data[$nomColumn]);
                    $commune->setNomMiniscule($data[$nomMinisculeColumn]);
                    /* $commune->setIntercommunalite($data[$intercommunaliteColumn]);
                    $commune->setIntercommunaliteNb($data[$intercommunaliteNbColumn]);
                    $commune->setIntercommunalitePop($data[$intercommunalitePopColumn]);
                    $commune->setIntercommunaliteEpci($data[$intercommunaliteEpciColumn]);
                    $commune->setCommunePop($data[$communePopColumn]);
                    $commune->setCommuneCp($data[$communeCpColumn]);
                    $commune->setVitesseVent($data[$vitesseVentColumn]);
                    $commune->setProductiblePv($data[$productiblePvColumn]);
                    $commune->setUrbanismeType($data[$urbanismeTypeColumn]);
                    $commune->setUrbanismeEtat($data[$urbanismeEtatColumn]);
                    $commune->setAltitude($data[$altitudeColumn]);
                    $commune->setRelief($data[$reliefColumn]); */
                    $em->persist($commune);
                    if($row2 > 300) {echo $row.',';
                        $em->flush();
                        $row2 = 0;
                    }
                }
                fclose($handle);
                $em->flush();
            }
            return new Response('Done');
        } else new Response('Fichier introuvable');
    }

    /**
     * @Route("/liste/nouveau", name="liste_new")
     * @Security("has_role('ROLE_VIEW_ALL')")
     */
    public function newListeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rappel = $em->getRepository('AppBundle:Rappel')->findOneBy(['id' => 1]);
        if(!$rappel) $rappel = new Rappel();
        $formRappel = $this->createForm(RappelType::class, $rappel);
        $formRappel->handleRequest($request);

        if ($formRappel->isSubmitted() && $formRappel->isValid()) {
            $em->persist($rappel);
            $em->flush();
            $this->addFlash('success', 'Rappel a été modifié.');
            return $this->redirectToRoute('liste_new');
        }

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
                $communeColumn = false;
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
                $commentaireColumn = false;
                $pvSurfaceColumn = false;
                $eolienLineaireSurfaceColumn = false;
                $enjeuxColumns = [];
                $transliterationTable = array('á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
                $listEnvironnements = Environnement::getEnvironnementList();
                $listDynamiques = EtatModel::getDynamiqueList();
                $listTypeProjets = Projet::getTypeProjetList();
                $listTypeSites = Projet::getTypeSiteList();
                set_time_limit(1000);
                $start_time = microtime(true);
                $write_close = false;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$write_close) {
                        $end_time = microtime(true); 
                        $execution_time = ($end_time - $start_time); 
                        if($execution_time > 30) {
                            session_write_close();
                            $write_close = true;
                        }
                    }
                    if(!$row++) {
                        for ($c=0; $c < count($data); $c++) {
                            $name = trim(strtolower($data[$c]));
                            if($name=='insee_com' || $name=='insee' || $name=='commune_insee' || $name=='commune insee') $inseeColumn = $c;
                            if($name=='commune') $communeColumn = $c;
                            elseif($name=='departement') $departementColumn = $c;
                            elseif($name=='latitude') $latColumn = $c;
                            elseif($name=='longitude') $lngColumn = $c;
                            elseif($name=='altitude') $altitudeColumn = $c;
                            elseif($name=='environnement' || $name=='type de milieu') $environnementColumn = $c;
                            elseif($name=='topographie') $topographieColumn = $c;
                            elseif($name=='type de projet') $typeProjetColumn = $c;
                            elseif($name=='type de site' || $name=='type de bien') $typeSiteColumn = $c;
                            elseif($name=='potentiel (mw)') $potentielColumn = $c;
                            elseif($name=='parcelle') $parcelleColumn = $c;
                            elseif($name=='commentaire') $commentaireColumn = $c;
                            elseif($name=='pv_surface' || $name=='pv surface') $pvSurfaceColumn = $c;
                            elseif($name=='eolien_lineaire' || $name=='eolien lineaire') $eolienLineaireSurfaceColumn = $c;
                            elseif(preg_match('%enjeux\-(.+)%i',  $data[$c], $m)) $enjeuxColumns[$m[1]] = $c;
                        }
                        if(false === $departementColumn || false === $latColumn || false === $lngColumn || false === $environnementColumn || false === $typeProjetColumn || false === $typeSiteColumn) {
                            $this->addFlash('danger', 'Le fichier manque des colonnes obligatoires.');
                            break;
                        }
                        continue;
                    }
                    $data = array_map("utf8_encode", $data);
                    // if($row > 50) break;
                    $denomination = $liste->getListeOriginalName() . '_' . substr(md5(serialize($data)),16);
                    // $search = $em->getRepository('AppBundle:Projet')->findBy(['denomination' => $denomination, 'liste' => $liste]);
                    // if(!$search) {
                        $projet = $em->getRepository('AppBundle:Projet')->findBy(['origine' => $this->getUser(), 'latitude' => $data[$latColumn], 'longitude' => $data[$lngColumn]]);
                        if(!$projet) $projet = new Projet();
                        $projet->setListe($liste);
                        $projet->setOrigine($this->getUser());
                        // $projet->setChefProjet($this->getUser());
                        $telephone = $this->getUser()->getTelephone();
                        $projet->setOrigineTelephone($telephone);
                        // $projet->setChefProjetTelephone($telephone);
                        $projet->setDenomination($denomination);
                        if ($data[$latColumn]) $projet->setLatitude($data[$latColumn]);
                        else $projet->setLatitude(0);
                        if ($data[$lngColumn]) $projet->setLongitude($data[$lngColumn]);
                        else $projet->setLongitude(0);
                        $env = array_search($data[$environnementColumn], $listEnvironnements);
                        if($env) $projet->setEnvironnement($env);
                        else $projet->setEnvironnement('foret');
                        $tProjet = array_search($data[$typeProjetColumn], $listTypeProjets);
                        if(!$tProjet) $tProjet = 'parc__eolien';
                        $projet->setTypeProjet($tProjet);
                        $tSite = array_search($data[$typeSiteColumn], $listTypeSites);
                        if(!$tSite) $tSite = 'terrain';
                        $projet->setTypeSite($tSite);
                        if($tProjet == 'parc__eolien' || $tProjet == 'eolienne_isolee') {
                            $projet->setTechnologie('eolienne');
                            $projet->setPuissanceUnitaire(126);
                            if($tProjet == 'parc__eolien') $projet->setDenomination('Esol_id');
                            else $projet->setDenomination('EOi_id');
                        } else {
                            if($tProjet=='toiture_solaire') $projet->setDenomination('Ptoit_id');
                            elseif($tProjet=='ferme_solaire') $projet->setDenomination('Psol_id');
                            elseif($tProjet=='ombriere_solaire') $projet->setDenomination('Pomb_id');
                            elseif($tProjet=='tracker_solaire') $projet->setDenomination('Ptrack_id');
                            elseif($tProjet=='mesure_enviro') $projet->setDenomination('Menv_id');
                            $projet->setTechnologie('photovoltaique');
                            $projet->setPuissanceUnitaire(300);
                        }
                        if($potentielColumn !== false && trim($data[$potentielColumn])) $projet->setPotentiel(trim($data[$potentielColumn]));
                        if($commentaireColumn !== false) $projet->setCommentaires($data[$commentaireColumn]);
                        if($pvSurfaceColumn !== false && trim($data[$pvSurfaceColumn])) $projet->setSurfaceUtile($data[$pvSurfaceColumn]);
                        if($eolienLineaireSurfaceColumn !== false && trim($data[$eolienLineaireSurfaceColumn])) $projet->setLineaire($data[$eolienLineaireSurfaceColumn]);
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
                        $departementVal = strtoupper(str_replace(array_keys($transliterationTable), array_values($transliterationTable), $data[$departementColumn]));
                        $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['nom' => $departementVal]);
                        if($departement) {
                            $projet->setDepartement($departement);
                            if($inseeColumn !== false) {
                                $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $data[$inseeColumn]]);
                                if($commune) $projet->addCommune($commune);
                                else {
                                    $commune = new Commune();
                                    $commune->setDepartement($departement);
                                    $commune->setNom(strtoupper($data[$communeColumn]));
                                    $commune->setInsee($data[$inseeColumn]);
                                    $commune->setCode(substr($data[$inseeColumn],-3));
                                    $projet->addCommune($commune);
                                }
                            }
                            if($parcelleColumn !== false && $data[$parcelleColumn]) {
                                $parcelle_array = explode(',', $data[$parcelleColumn]);
                                foreach($parcelle_array as $value) {
                                    $parcelle = new Parcelle();
                                    $parcelle->setNom(trim($value));
                                    $parcelle->setDepartement($departement);
                                    if($commune) $parcelle->setCommune($commune);
                                    $projet->addParcelle($parcelle);
                                }
                            }
                            $etat = new Etat();
                            $etat->setPhase('exploratoire');
                            $etat->setEtat('nouveau');
                            $etat->setDynamique('0');
                            $projet->addEtat($etat);
                            $tache = new Tache();
                            $tache->setObjet('servitudes');
                            $tache->setEtat('a_letude');
                            $tache->setDynamique('0');
                            $projet->addTache($tache);
                            $tache = new Tache();
                            $tache->setObjet('foncier');
                            $tache->setEtat('a_identifier');
                            $tache->setDynamique('0');
                            $projet->addTache($tache);
                            if(!empty($enjeuxColumns)) {
                                foreach($enjeuxColumns as $facteur => $column) {
                                    $enjeux = new Enjeux();
                                    $facteurType = $enjeux->getFacteurType($facteur);
                                    $enjeux->setFacteur($facteurType);
                                    $enj = array_search($data[$column], $listDynamiques);
                                    if($enj) $enjeux->setEnjeux($enj);
                                    else $enjeux->setEnjeux('0');
                                    $projet->addEnjeux($enjeux);
                                }
                            }
                            $em->persist($projet);
                            if($row % 50 == 0) $em->flush();
                        } else $this->addFlash('warning', 'Département « ' . $departementVal . ' » n\'existe pas.');
                    // } else $this->addFlash('warning', 'Projet avec latitude et longitude « ' . $data[$latColumn] . ',' . $data[$lngColumn] . ' » déjà existe.');
                }
                fclose($handle);
                $em->flush();
            }
            return $this->redirectToRoute('view_liste', [
                'liste' => $liste->getId(),
            ]);
        }

        return $this->render('projet/newListe.html.twig', [
            'form' => $form->createView(),
            'formRappel' => $formRappel->createView(),
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
        $telephone = $this->getUser()->getTelephone();
        $projet->setOrigineTelephone($telephone);
        // if ($this->isGranted('ROLE_ADMIN')) {
            $projet->setChefProjet($this->getUser());
            $projet->setChefProjetTelephone($telephone);
        // }

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $liste = $em->getRepository('AppBundle:Liste')->findOneBy(['listeOriginalName' => 'Sans liste']);
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
        $batimentNouveaux = $em->getRepository('AppBundle:BatimentNouveau')->findAll();
        $batiments = json_encode($batimentNouveaux);
        $modelesPanneaux = $em->getRepository('AppBundle:ModelePanneau')->findAll();
        $modelesEoliennes = $em->getRepository('AppBundle:ModeleEolienne')->findAll();
        $technologies = ['photovoltaique' => ['name'=> 'photovoltaique', 'data' => []], 'eolienne' => ['name'=> 'eolienne', 'data' => []]];
        foreach($modelesPanneaux as $modele) {
            $technologies['photovoltaique']['data'][$modele->getNom() . ' ('.$modele->getPuissance().'Wc)'] = $modele->jsonSerialize();
        }
        foreach($modelesEoliennes as $modele) {
            $technologies['eolienne']['data'][$modele->getNom() . ' ('.$modele->getHauteurMat().'m)'] = $modele->jsonSerialize();
        }

        return $this->render('projet/new.html.twig', [
            'form' => $form->createView(),
            'grid_helper' => $gridHelper,
            'telephones' => json_encode($telephones),
            'batiments' => json_encode($batiments),
            'technologies' => json_encode($technologies)
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
        $batimentNouveaux = $em->getRepository('AppBundle:BatimentNouveau')->findAll();
        $batiments = json_encode($batimentNouveaux);
        $modelesPanneaux = $em->getRepository('AppBundle:ModelePanneau')->findAll();
        $modelesEoliennes = $em->getRepository('AppBundle:ModeleEolienne')->findAll();
        $technologies = ['photovoltaique' => ['name'=> 'photovoltaique', 'data' => []], 'eolienne' => ['name'=> 'eolienne', 'data' => []]];
        foreach($modelesPanneaux as $modele) {
            $technologies['photovoltaique']['data'][$modele->getNom() . ' ('.$modele->getPuissance().'Wc)'] = $modele->jsonSerialize();
        }
        foreach($modelesEoliennes as $modele) {
            $technologies['eolienne']['data'][$modele->getNom() . ' ('.$modele->getHauteurMat().'m)'] = $modele->jsonSerialize();
        }

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
            'show' => $show,
            'grid_helper' => $gridHelper,
            'telephones' => json_encode($telephones),
            'batiments' => json_encode($batiments),
            'technologies' => json_encode($technologies)
        ]);
    }
    function replaceText($element, $variable, $value) {
        $text_class = 'PhpOffice\PhpWord\Element\Text';
        $table_class = 'PhpOffice\PhpWord\Element\Table';
        foreach ($element as $e) {
            if (get_class($e) !== $text_class && method_exists($e, 'getElements')) {
                replaceText($e->getElements(), $variable, $value);
            } elseif (get_class($e) === $text_class && ($match_count = substr_count($e->getText(), $variable))) {
                for ($i = 1; $i <= $match_count; $i++) {
                    $e->setText(str_replace($variable, $value, $e->getText()));
                }
            } elseif (get_class($e) === $table_class && ($row_count = count($e->getRows()))) {
                foreach ($e->getRows() as $row) {
                    foreach ($row->getCells() as $cell) {
                        replaceText($cell->getElements(), $variable, $value);
                    }
                }
            }
        }
    }

    /**
     * @Route("/publier", name="projet_publish")
     * @Security("has_role('ROLE_VIEW')")
     */
    public function publishAction(Request $request)
    {
        if(isset($_POST['projet_technologie'])) {
        	if($_POST['projet_technologie'] == 'eolienne') {
                $fileName = 'PdBS Eolien.docx';
                $fullPath = $this->getUser()->getId() . '_' . $fileName;
            } else {
                $fileName = 'PdBS Solaire.docx';
                $fullPath = $this->getUser()->getId() . '_' . $fileName;
                $parcelleRow = '';
            }
            @unlink($fullPath);
            copy(__DIR__ . '/../' . $fileName, $fullPath);
	
			$parcelleRow = '<w:tr w:rsidR="000412FA" w:rsidRPr="00045C8A" w14:paraId="2DC1474E" w14:textId="77777777" w:rsidTr="005E1E4F"><w:trPr><w:trHeight w:val="292"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="1841" w:type="dxa"/></w:tcPr><w:p w14:paraId="6BED3C66" w14:textId="3BF5952A" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_com}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1843" w:type="dxa"/><w:gridSpan w:val="2"/></w:tcPr><w:p w14:paraId="0732FA70" w14:textId="74B4E54E" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_section}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1841" w:type="dxa"/></w:tcPr><w:p w14:paraId="49BE4506" w14:textId="386C67B9" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_n}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1843" w:type="dxa"/></w:tcPr><w:p w14:paraId="236AC2B6" w14:textId="720D6377" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_lieudit}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1878" w:type="dxa"/></w:tcPr><w:p w14:paraId="7D928BCD" w14:textId="5BEBD362" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="000412FA"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_surface}</w:t></w:r></w:p></w:tc></w:tr>';
			$personnesPhysiquesRow = '<w:p w14:paraId="1A9F6B84" w14:textId="5720D31D" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00B718FB" w:rsidP="00B718FB"><w:pPr><w:spacing w:before="1" w:line="219" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00B718FB"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_civilite}</w:t></w:r><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_identite}</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>Né(e)</w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>le</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_ne_le}</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t>à</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_ne_a}</w:t></w:r></w:p><w:p w14:paraId="43491EE4" w14:textId="77777777" w:rsidR="0097492F" w:rsidRDefault="00045C8A" w:rsidP="0097492F"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:spacing w:val="-7"/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-7"/><w:sz w:val="18"/></w:rPr><w:t>De nationalité</w:t></w:r></w:p><w:p w14:paraId="70EC600C" w14:textId="2A1D5B6D" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="0097492F"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-38"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Demeurant à</w:t></w:r><w:r w:rsidR="0097492F"><w:rPr><w:spacing w:val="-10"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="0097492F" w:rsidRPr="0097492F"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_adresse}</w:t></w:r></w:p><w:p w14:paraId="372D95EF" w14:textId="1329B2F8" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:line="219" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Qui</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>déclare</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:proofErr w:type="gramStart"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>être</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>:</w:t></w:r><w:proofErr w:type="gramEnd"/><w:r w:rsidR="0097492F"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="0097492F" w:rsidRPr="0097492F"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_marital}</w:t></w:r></w:p><w:p w14:paraId="753C5FF0" w14:textId="315553C8" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218" w:right="195"/><w:rPr><w:b/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Agissant</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-3"/><w:sz w:val="18"/></w:rPr><w:t>en</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>qualité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-4"/><w:sz w:val="18"/></w:rPr><w:t>de</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00900F35" w:rsidRPr="00900F35"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_droit}</w:t></w:r></w:p><w:p w14:paraId="3F868699" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:ind w:left="218"/><w:rPr><w:b/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Qualité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>particulière</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>de</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>l’intéressé(e)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>(rayer</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>la</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>mention</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>inutile</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>et</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-10"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>parapher</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>en</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>marge)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>:</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>PROMETTANT</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>OU</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>EXPLOITANT</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>OU</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>INTERVENANT</w:t></w:r></w:p><w:p w14:paraId="28397692" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="11"/><w:rPr><w:b/><w:sz w:val="15"/><w:szCs w:val="20"/></w:rPr></w:pPr></w:p>';
			$personnesPhysiques2Row = '<w:p w14:paraId="07A0F37E" w14:textId="21B8B8BB" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:line="243" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Je</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-3"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>soussigné</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="15"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_civilite}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_identite}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="44594A93" w14:textId="5BF4193A" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Né(e)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="2"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>le</w:t></w:r><w:r w:rsidR="00512607" w:rsidRPr="00512607"><w:t xml:space="preserve"> </w:t></w:r><w:bookmarkStart w:id="0" w:name="_Hlk76307180"/><w:r w:rsidR="00512607" w:rsidRPr="00512607"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_ne_le}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="25"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>à</w:t><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_ne_a}</w:t></w:r><w:bookmarkEnd w:id="0"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="308ED261" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>De</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="10"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>nationalité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="66"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="72299912" w14:textId="337649DC" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Demeurant</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="12"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>à</w:t></w:r><w:proofErr w:type="gramStart"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="33"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:proofErr w:type="gramEnd"/><w:r w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00A7281E" w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00A7281E" w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_adresse}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r></w:p>';
			$titleRow = '<w:p w14:paraId="51374436" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00252069"><w:pPr><w:ind w:firstLine="218"/></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:sz w:val="18"/><w:szCs w:val="20"/></w:rPr><w:t>{title}</w:t></w:r></w:p>';
			$replaceThis = [];
            $replaceBy = [];
            foreach($_POST as $key => $value) {
                if(preg_match('%\{.+?\}%', $key) && $value) {
                    if($key != '{publish_parcelles}') {
                        $replaceThis[] = $key;
                        $replaceBy[] = $value;
                    } else {
                        $parcelleRowCopy = $parcelleRow;
                        $parcelleRow = '';
                        $parcelles = json_decode($value, 1);
                        foreach($parcelles as $parcelle) {
                            $parcelleName = trim($parcelle[0]);
                            $parcelleSection = '';
                            $parcelleNumber = '';
                            if(preg_match('%^[a-zA-Z]+%', $parcelleName, $m)) {
                                $parcelleSection = $m[0];
                            }
                            if(preg_match('%\d+%', $parcelleName, $m)) {
                                $parcelleNumber = $m[0];
                            }
                            $parcelleRow .= str_replace(['{parcelle_section}', '{parcelle_n}', '{parcelle_com}', '{parcelle_lieudit}', '{parcelle_surface}'], [$parcelleSection, $parcelleNumber, $parcelle[1], $parcelle[2], $parcelle[3]], $parcelleRowCopy);
                        }
                    }
                }
            }
			$personnesPhysiquesRowCopy = $personnesPhysiquesRow;
			$personnesPhysiquesRow = str_replace('{title}', 'Propriétaires:', $titleRow);
			for ($i=0; $i <= 4; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{proprietaire' . $j . '_identite}']) && $_POST['{proprietaire' . $j . '_identite}'] && isset($_POST['{proprietaire' . $j . '_qualite}']) && $_POST['{proprietaire' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiquesRow .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRow .= str_replace('{title}', 'Exploitants:', $titleRow);
			for ($i=0; $i <= 3; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{exploitant' . $j . '_identite}']) && $_POST['{exploitant' . $j . '_identite}'] && isset($_POST['{exploitant' . $j . '_qualite}']) && $_POST['{exploitant' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiquesRow .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRowCopy = $personnesPhysiques2Row;
			$personnesPhysiques2Row = '';
			for ($i=0; $i <= 4; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{proprietaire' . $j . '_identite}']) && $_POST['{proprietaire' . $j . '_identite}'] && isset($_POST['{proprietaire' . $j . '_qualite}']) && $_POST['{proprietaire' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiques2Row .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRowCopy = $personnesPhysiques2Row;
			$personnesPhysiques3Row = '';
			for ($i=0; $i <= 3; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{exploitant' . $j . '_identite}']) && $_POST['{exploitant' . $j . '_identite}'] && isset($_POST['{exploitant' . $j . '_qualite}']) && $_POST['{exploitant' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiques3Row .= $personnesPhysiquesRowCopy2;
				}
			}if (isset($_GET['test'])) exit($parcelleRow);

            $zip_val = new \ZipArchive;

            if($zip_val->open($fullPath) == true) {

                $key_file_name = 'word/document.xml';
                $message = $zip_val->getFromName($key_file_name);

                $timestamp = date('d-M-Y H:i:s');

                $message = str_replace('{parcelle_row}', $parcelleRow, $message);

                $message = str_replace('{personnes_physiques}', $personnesPhysiquesRow, $message);

                $message = str_replace('{personnes_physiques_2}', $personnesPhysiques2Row, $message);

                $message = str_replace('{personnes_physiques_3}', $personnesPhysiques3Row, $message);

                $message = str_ireplace($replaceThis, $replaceBy, $message);

                //Replace the content with the new content created above.
                $zip_val->addFromString($key_file_name, $message);
                $zip_val->close();
                header("Content-type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                header("Content-Disposition:attachment;filename=$fileName");
                readfile($fullPath);
                @unlink($fullPath);
                die;
            }
        }
        exit('Done');
    }

    private function getCadastreForCommune($communeId)
    {
        $result = '{}';
        $em = $this->getDoctrine()->getManager();
        $commune = $em->getRepository('AppBundle:Commune')->find($communeId);
        if($commune) {
            $insee = $commune->getInsee();
            if(!file_exists('cadastres/cadastre-' . $insee . '-parcelles.json')) {
                $departement = substr($insee, 0, 2);
                $result = @file_get_contents('https://france-cadastre.fr/map/' . $departement . '/' . $insee . '/cadastre-' . $insee . '-parcelles.json');
                if(!$result) {
                    $result = '{}';
                } else {
                    file_put_contents('cadastres/cadastre-' . $insee . '-parcelles.json', $result);
                }
            } else {
                $result = file_get_contents('cadastres/cadastre-' . $insee . '-parcelles.json');
            }
        }
        return $result;
    }

    /**
     * @Route("/france-cadastre", name="france_cadastre", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function franceCadastreAction(Request $request)
    {
        $result = '{}';
        $communes = $request->query->get('communes', 0);
        $parcelles = $request->query->get('parcelles', 0);
        if(!empty($communes)) {
            if(is_string($communes)) {
                $result = $this->getCadastreForCommune($communes);
            } elseif(is_array($communes)) {
                $results = array();
                foreach($communes as $commune) {
                    if(!$commune) continue;
                    $result = $this->getCadastreForCommune($commune);
                    if($result && $result != '{}') {
                        $results[] = $result;
                    }
                }
                $features = '';
                foreach($results as $result) {
                    if(preg_match('%"features"\s*:\s*\[(.+)%s', $result, $m)) {
                        $features .= substr($m[1], 0, -2) . ',';exit($features);
                    } else exit('*'.$result.'*');
                }
                $result = '{}';
                if($features) {
                    $result = '{"type":"FeatureCollection","features":[ '. substr($features, 0, -1) .' ]}';
                }
            }
        }
        if(empty($parcelles)) {
            return new Response($result);
        } else {
            $response = [];
            $data = json_decode($result, 1);
            foreach($data['features'] as $feature) {
                $nomParcelle = $feature['properties']['section'] . $feature['properties']['numero'];
                if(in_array($nomParcelle, $parcelles)) {
                    $row = array('id' => $feature['properties']['id'], 'section' => $feature['properties']['section'], 'numero' => $feature['properties']['numero'], 'commune' => $feature['properties']['commune'], 'contenance' => $feature['properties']['contenance'], 'selected' => 1);
                    $response[] = $row;
                }
            }
            return new JsonResponse($response);
        }
    }

    /**
     * @Route("/contacts/search", name="contacts_search")
     * @Security("has_role('ROLE_VIEW')")
     */
    public function contactsAction(Request $request)
    {
        $response = new JsonResponse();

        $id = $request->request->get('id', null);

        $results = ['partenaires'=>[],'chef_projets'=>[],'charge_fonciers'=>[]];

        if (!empty($id)) {
            $em = $this->getDoctrine()->getManager();
            $results['partenaires'] = $em->getRepository('AppBundle:User')->getFindPartenaires($id);
            $results['chef_projets'] = $em->getRepository('AppBundle:User')->getFindChefProjets($id);
            $results['charge_fonciers'] = $em->getRepository('AppBundle:User')->getFindChargeFonciers($id);
        }

        $response->setData($results);
        return $response;
    }

    /**
     * @Route("/communes/search", name="commune_search", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $departement = $request->query->get('departement', null);

        $results = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Commune')->searchTerm($term, $departement);
        }

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/{id}/epci-by-commune", name="epci_search_by_commune", options={ "expose": true })
     * @ParamConverter("commune", options={"mapping": {"id": "id"}})
     * @Method({"POST"})
     * @Security("has_role('ROLE_VIEW')")
     */
    public function epciSearchByCommuneAction(Request $request, Commune $commune)
    {
        $response = new JsonResponse();

        $epciPop = $commune->getIntercommunalitePop() ? $commune->getIntercommunalitePop() : '-';
        $communePop = $commune->getCommunePop() ? $commune->getCommunePop() : '-';
        $result = ['epci' => $commune->getIntercommunalite(), 'epci_pop' => $epciPop, 'commune' => $commune->getNomMiniscule(), 'commune_pop' => $communePop, 'nom_president' => $commune->getNomPresident(), 'telephone_president' => $commune->getTelephonePresident(), 'email_president' => $commune->getEmailPresident(), 'vitesse_vent' => $commune->getVitesseVent(), 'productible_pv' => $commune->getProductiblePv(), 'urbanisme_type' => $commune->getUrbanismeType(), 'urbanisme_etat' => $commune->getUrbanismeEtat(), 'altitude' => $commune->getAltitude(), 'relief' => $commune->getRelief()];

        $response->setData($result);

        return $response;
    }
    
    /**
     * @Route("/parc-eoliens-by-departement", name="parc_eoliens_search_by_departement", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_VIEW')")
     */
    public function parcEoliensSearchByDepartementAction(Request $request)
    {
        $response = new JsonResponse();

        $result = ['parc_eoliens_departement' => [], 'parc_eoliens_commune' => []];
        $departement = $request->query->get('departement', null);
        if($departement) {
            $em = $this->getDoctrine()->getManager();
            $parcEoliens = $em->getRepository('AppBundle:ParcEolien')->findBy(['departement' => $departement]);
            foreach($parcEoliens as $parc) {
                $denomination = $parc->getDenomination() ? $parc->getDenomination() : $parc->getId();
                $result['parc_eoliens_departement'][] = ['id' => $parc->getId(),'denomination' => $denomination, 'latitude' => $parc->getLatitude(), 'longitude' => $parc->getLongitude()];
            }
            $communeId = $request->query->get('commune_id', null);
            if($communeId) {
                $commune = $em->getRepository('AppBundle:Commune')->find($communeId);
                if($commune) {
                    $parcEoliens = $em->getRepository('AppBundle:ParcEolien')->findBy(['insee' => $commune->getInsee()]);
                    foreach($parcEoliens as $parc) {
                        $denomination = $parc->getDenomination() ? $parc->getDenomination() : $parc->getId();
                        $result['parc_eoliens_commune'][] = ['id' => $parc->getId(),'denomination' => $denomination, 'latitude' => $parc->getLatitude(), 'longitude' => $parc->getLongitude()];
                    }
                }
            }
        }
        $response->setData($result);

        return $response;
    }
    
    /**
     * @Route("/{id}/messagerie/new", name="messagerie_new", options={ "expose": true })
     * @Security("is_granted('view', projet)")
     */
    public function newMessageAction(Request $request, Projet $projet)
    {
        $csrf = $request->request->get('token', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }
        $response = new JsonResponse();

        $body = $request->query->get('body', '');

        $message = new Messagerie();
        $message->setBody($body);

        $projet->addMessage($message);

        $em = $this->getDoctrine()->getManager();
        $em->persist($projet);
        $em->flush();
        $results = ['status' => 1];

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/{id}/messagerie/list", name="messagerie_list", options={ "expose": true })
     * @Security("is_granted('view', projet)")
     */
    public function listMessageAction(Request $request, Projet $projet)
    {
        $csrf = $request->request->get('token', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }
        $response = new JsonResponse();
        
        $em = $this->getDoctrine()->getManager();
        $messages = $projet->getMessages();
        $results = [];
        foreach($messages as $message) {
            if($message->getCreatedBy() && $message->getCreatedBy() != $this->getUser()) {
                $message->addViewer($this->getUser());
                $em->persist($message);
            }
            $fromName = $message->getCreatedBy() ? $message->getCreatedBy()->getNom() . ' ' . $message->getCreatedBy()->getPrenom() : '';
            $fromId = $message->getCreatedBy() ? $message->getCreatedBy()->getId() : '';
            // $created_at = 
            $results[] = [$message->getId(), $fromId, $fromName, $message->getBody(), $message->getCreatedAt()->format('H:i A'), $message->getCreatedAt()->format('Y-m-d')];
        }
        $em->flush();

        $response->setData($results);
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
        $path = $dir . '/' . $projet->getPhotoImplantation();
        
        $dirDest = $this->getParameter('cartes_fiche_dir');
        $pathDest = $dirDest . '/' . $projet->getPhotoImplantation() . '.jpg';
        
        /* if (!file_exists($pathDest)) {
            $image = new Imagick($path);
            $image->setImageFormat('jpeg');
            $image->setCompressionQuality(70);
            $image->scaleImage(2480, 0);
            $image->writeImage($pathDest);
        } */
        if($projet->getPhotoImplantation()) $imagePath = $path;
        else $imagePath = '';
        
        $date = new DateTime('now');
        $conf = ['mode' => 'utf-8','format' => 'A4','default_font_size' => 0,'default_font' => '','margin_left' => 10,'margin_right' => 10,'margin_top' => 10,'margin_bottom' => 10,'margin_header' => 10,'margin_footer' => 10,'orientation' => 'P'];
        $mpdf = new mPDF($conf);

        @unlink($dirDest . '/'.$projet->getDenomination().'.png');
        $this->createMapImage($projet->getLatitude(), $projet->getLongitude(), $projet->getDenomination());
        if(file_exists($dirDest . '/'.$projet->getDenomination().'.png'))
            $cartePath = $dirDest . '/'.$projet->getDenomination().'.png';
        else '';
        $phases = EtatModel::getPhaseList();
        $html = $this->renderView('projet/fiche.html.twig', [
            'show' => null,
            'projet' => $projet,
            'phases' => $phases,
            'date' => $date,
            'image_path' => $imagePath,
            'carte_path' => $cartePath,
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
     * @Route("/archive/batch", name="projet_batch_archive", options = { "expose" = true })
     * @Method("POST")
     * @Security("has_role('ROLE_EDIT')")
     */
    public function archiveProjetsAction(Request $request)
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
        $archived = count($projets);

        foreach ($projets as $projet) {
            $projet->setArchived(true);
            $em->persist($projet);
        }

        $em->flush();

        if ($archived > 1) {
            $this->addFlash('success', $archived . ' entrées archivées sur ' . $total . '.');
        } else {
            $this->addFlash('success', $archived . ' entrée archivée sur ' . $total . '.');
        }

        $response = new JsonResponse();
        $response->setData(['success' => 1]);
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

    private function createMapImage($lat1, $lng1, $projetNom)
    {
        $dirDest = $this->getParameter('cartes_fiche_dir');
        $zoom = 6;
        //from https://wiki.openstreetmap.org/wiki/Slippy_map_tilenames#X_and_Y
        //convert lat/lng to x/y tile coords
        $x1 = floor((($lng1 + 180) / 360) * pow(2, $zoom));
        $y1 = floor((1 - log(tan(deg2rad($lat1)) + 1 / cos(deg2rad($lat1))) / pi()) / 2 * pow(2, $zoom));

        $startX = $x1-1;
        $startY = $y1-1;

        if($startX<0)
        {
            $startX = 0;
        }
        if($startY<0)
        {
            $startY = 0;
        }

        $endX = $x1+1;
        $endY = $y1+1;

        if($endX>(pow(2,$zoom))-1)
        {
            $endX = (pow(2,$zoom))-1;
        }
        if($endY>(pow(2,$zoom))-1)
        {
            $endY = (pow(2,$zoom))-1;
        }

        if(($endX-$startX+1)*($endY-$startY+1)>=50)
        {
            //https://operations.osmfoundation.org/policies/tiles/#bulk-downloading
            //terms of use state: In particular, downloading an area of over 250 tiles at zoom level 13 or higher for offline or later usage is forbidden
            //we're going to be a lot more strict here
            throw new Exception('Zoom level is too high, please reduce');
        }

        if(!is_dir($dirDest."/tiles"))
        {
            mkdir($dirDest."/tiles",0755);
        }

        for($x=$startX;$x<=$endX;$x++) {
            for($y=$startY;$y<=$endY;$y++) {
                $file = $dirDest . "/tiles/${zoom}_${x}_${y}.png";
                if(!is_file($file) || filemtime($file) < time() - (86400 * 30)) {
                    $server = array();
                    $server[] = 'a.tile.openstreetmap.org';
                    $server[] = 'b.tile.openstreetmap.org';
                    $server[] = 'c.tile.openstreetmap.org';

                    $url = 'https://'.$server[array_rand($server)];
                    $url .= "/".$zoom."/".$x."/".$y.".png";

                    $ch = curl_init($url);
                    $fp = fopen($file, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0';
                    $header = ['Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8','Accept-Language: en-US,en;q=0.5','User-Agent:'.$userAgent];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    fflush($fp);    // need to insert this line for proper output when tile is first requested
                    fclose($fp);
                }
            }
        }

        //now stitch all tiles into 1 image
        $tileWidth = 0;
        $tileHeight = 0;

        $map = new Imagick();
        $cols = array();
        for($x=$startX;$x<=$endX;$x++)
        {
            try{
                $col = new Imagick();
                for($y = $startY; $y <= $endY; $y ++)
                {
                $col->readImage($dirDest . "/tiles/${zoom}_${x}_${y}.png");
                if($tileWidth===0)
                {
                    $tileWidth = $col->getImageWidth();
                    $tileHeight = $col->getImageHeight();
                }
                }
                $col->resetIterator();
                $cols[] = $col->appendImages(true);
            } catch(\Exception $e) {}
        }
        foreach($cols as $col)
        {
            $map->addImage($col);
        }
        $map->resetIterator();
        $map = $map->appendImages(false);

        //calculate the pixel point of the lat lng
        $x1 = $tileWidth*(((($lng1 + 180) / 360) * pow(2, $zoom))-$startX);
        $y1 = $tileHeight*(((1 - log(tan(deg2rad($lat1)) + 1 / cos(deg2rad($lat1))) / pi()) / 2 * pow(2, $zoom))-$startY);

        if(file_exists($dirDest . '/../vendor/leaflet/images/marker-icon.png'))
        {
            $icon = new Imagick($dirDest . '/../vendor/leaflet/images/marker-icon.png');
            $icon->scaleImage(50,50,true);
            $markerX = $x1-($icon->getImageWidth()/2);
            $markerY = $y1-$icon->getImageHeight();
            $map->compositeImage($icon->clone(),$icon::COMPOSITE_DEFAULT,$markerX,$markerY);
        }

        $map->setImageFormat('png');
        $map->writeImage($dirDest . '/'.$projetNom.'.png');
    }
}
