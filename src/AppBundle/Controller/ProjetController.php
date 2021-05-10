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
                        file_put_contents(__DIR__ . '/../mairie_counter.txt', $row);
                        if($row % 500 == 0) $em->flush();
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
                    if($data[$eluFonctionColumn] == 'Mairie') {
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
                        $intercommunalitePopColumn = 9;
                        $intercommunaliteCpColumn = 10;
                        $intercommunaliteEpciColumn = 11;
                        continue;
                    }
                    // if($row < 30000) continue;
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
                    } else if($commune->getNomMiniscule()) continue;
                    $commune->setNomMiniscule($data[$nomMinisculeColumn]);
                    $commune->setIntercommunalite($data[$intercommunaliteColumn]);
                    $commune->setIntercommunaliteNb($data[$intercommunaliteNbColumn]);
                    $commune->setIntercommunalitePop($data[$intercommunalitePopColumn]);
                    $commune->setIntercommunaliteCp($data[$intercommunaliteCpColumn]);
                    $commune->setIntercommunaliteEpci($data[$intercommunaliteEpciColumn]);
                    $em->persist($commune);
                    if($row % 100 == 0) $em->flush();
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
                            if($name=='insee_com' || $name=='insee') $inseeColumn = $c;
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
     * @Route("/{id}/search-by-commune", name="epci_search_by_commune", options={ "expose": true })
     * @ParamConverter("commune", options={"mapping": {"id": "id"}})
     * @Method({"POST"})
     * @Security("has_role('ROLE_VIEW')")
     */
    public function epciSearchByCommuneAction(Request $request, Commune $commune)
    {
        $response = new JsonResponse();

        $result = ['epci' => $commune->getIntercommunalite(), 'nom_president' => $commune->getNomPresident(), 'telephone_president' => $commune->getTelephonePresident()];
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
            if(!$message->getCreatedBy() || $message->getCreatedBy() != $this->getUser()) {
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

        for($x=$startX;$x<=$endX;$x++)
        {
            for($y=$startY;$y<=$endY;$y++)
            {
            $file = $dirDest . "/tiles/${zoom}_${x}_${y}.png";
            if(!is_file($file) || filemtime($file) < time() - (86400 * 30))
            {
                $server = array();
                $server[] = 'a.tile.openstreetmap.org';
                $server[] = 'b.tile.openstreetmap.org';
                $server[] = 'c.tile.openstreetmap.org';

                $url = 'http://'.$server[array_rand($server)];
                $url .= "/".$zoom."/".$x."/".$y.".png";

                $ch = curl_init($url);
                $fp = fopen($file, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:85.0) Gecko/20100101 Firefox/85.0';
                curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
                curl_exec($ch);
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
