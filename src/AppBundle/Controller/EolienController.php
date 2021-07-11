<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ParcEolien;
use AppBundle\Entity\Import;
use AppBundle\Form\ParcEolienType;
use AppBundle\Form\ImportType;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file_path = $import->getImportFile();
            $row = 0;
            if (($handle = fopen($file_path, "r")) !== FALSE) {
                ini_set("memory_limit", "4000M");
                set_time_limit(3000);
                $idColumn = false;
                $denominationColumn = false;
                $regionColumn = false;
                $departementColumn = false;
                $communeColumn = false;
                $inseeColumn = false;
                $latColumn = false;
                $lngColumn = false;
                $mise_en_serviceColumn = false;
                $type_machineColumn = false;
                $puissance_nominale_unitaireColumn = false;
                $productible_estimeColumn = false;
                $developpeurColumn = false;
                $operateurColumn = false;
                $nom_contactColumn = false;
                $telephone_contactColumn = false;
                $email_contactColumn = false;
                $descriptionColumn = false;
                $etatColumn = false;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(!$row++) {
                        for ($c=0; $c < count($data); $c++) {
                            $name = trim(strtolower($data[$c]));
                            if($name=='id') $idColumn = $c;
                            elseif($name=='denomination') $denominationColumn = $c;
                            elseif($name=='region') $regionColumn = $c;
                            elseif($name=='departement') $departementColumn = $c;
                            elseif($name=='commune') $communeColumn = $c;
                            elseif($name=='insee') $inseeColumn = $c;
                            elseif($name=='latitude') $latColumn = $c;
                            elseif($name=='longitude') $lngColumn = $c;
                            elseif($name=='mise_en_service') $mise_en_serviceColumn = $c;
                            elseif($name=='type_machine') $type_machineColumn = $c;
                            elseif($name=='hauteur_mat') $hauteur_matColumn = $c;
                            elseif($name=='hauteur_totale') $hauteur_totaleColumn = $c;
                            elseif($name=='puissance_nominale_unitaire') $puissance_nominale_unitaireColumn = $c;
                            elseif($name=='puissance_nominale_totale') $puissance_nominale_totaleColumn = $c;
                            elseif($name=='productible_estime') $productible_estimeColumn = $c;
                            elseif($name=='developpeur') $developpeurColumn = $c;
                            elseif($name=='operateur') $operateurColumn = $c;
                            elseif($name=='nom_contact') $nom_contactColumn = $c;
                            elseif($name=='telephone_contact') $telephone_contactColumn = $c;
                            elseif($name=='email_contact') $email_contactColumn = $c;
                            elseif($name=='description') $descriptionColumn = $c;
                            elseif($name=='etat') $descriptionColumn = $c;
                        }
                        if(false === $idColumn || false === $latColumn || false === $lngColumn) {
                            $this->addFlash('danger', 'Le fichier manque des colonnes obligatoires.');
                            break;
                        }
                        $parcs = $em->getRepository('AppBundle:ParcEolien')->emptyTable();
                        session_write_close();
                        continue;
                    }
                    $data = array_map("utf8_encode", $data);
                    // if($row > 8000) break;
                    // if($row <= 8000) continue;
                    $parcEolien = new ParcEolien();
                    // $parcEolien->setId($data[$idColumn]);
                    $parcEolien->setId($row);
                    if($denominationColumn !== false) $parcEolien->setDenomination($data[$denominationColumn]);
                    if($regionColumn !== false) $parcEolien->setRegion($data[$regionColumn]);
                    if($departementColumn !== false) $parcEolien->setDepartement($data[$departementColumn]);
                    if($communeColumn !== false) $parcEolien->setCommune($data[$communeColumn]);
                    if($inseeColumn !== false) $parcEolien->setInsee($data[$inseeColumn]);
                    if($latColumn !== false) $parcEolien->setLatitude($data[$latColumn]);
                    if($lngColumn !== false) $parcEolien->setLongitude($data[$lngColumn]);
                    if($mise_en_serviceColumn !== false) $parcEolien->setMiseEnService($data[$mise_en_serviceColumn]);
                    if($type_machineColumn !== false) $parcEolien->setTypeMachine($data[$type_machineColumn]);
                    if($hauteur_matColumn !== false) $parcEolien->setHauteurMat((float) $data[$hauteur_matColumn]);
                    if($hauteur_totaleColumn !== false) $parcEolien->setHauteurTotale((float) $data[$hauteur_totaleColumn]);
                    if($puissance_nominale_unitaireColumn !== false) $parcEolien->setPuissanceNominaleUnitaire((float) $data[$puissance_nominale_unitaireColumn]);
                    if($puissance_nominale_totaleColumn !== false) $parcEolien->setPuissanceNominaleTotale((float) $data[$puissance_nominale_totaleColumn]);
                    if($productible_estimeColumn !== false) $parcEolien->setProductibleEstime((float) $data[$productible_estimeColumn]);
                    if($developpeurColumn !== false) $parcEolien->setDeveloppeur($data[$developpeurColumn]);
                    if($operateurColumn !== false) $parcEolien->setOperateur($data[$operateurColumn]);
                    if($nom_contactColumn !== false) $parcEolien->setNomContact($data[$nom_contactColumn]);
                    if($telephone_contactColumn !== false) $parcEolien->setTelephoneContact($data[$telephone_contactColumn]);
                    if($email_contactColumn !== false) $parcEolien->setEmailContact($data[$email_contactColumn]);
                    if($descriptionColumn !== false) $parcEolien->setDescription($data[$descriptionColumn]);
                    if($etatColumn !== false) $parcEolien->setEtat($data[$etatColumn]);
                    $em->persist($parcEolien);
                    if($row % 200 == 0) $em->flush();
                }
                fclose($handle);
                $em->flush();
            }
            return $this->redirectToRoute('cartographie');
        }
        $focus = $request->query->get('focus', null);
        
        $em = $this->getDoctrine()->getManager();
        $parcs = $em->getRepository('AppBundle:ParcEolien')
                        ->findAllAsArray();
        
        return $this->render('eolien/index.html.twig', array(
            'parcs' => $parcs,
            'focus_id' => $focus,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/environnement", name="cartographie_zone_naturelles_protegees")
     */
    public function zoneNaturellesProtegeesAction(Request $request)
    {
        ini_set("memory_limit", "4000M");
        set_time_limit(3000);
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $file_path = $import->getImportFile();
            file_put_contents('Essai.geojson', file_get_contents($file_path));
            return $this->redirectToRoute('cartographie_zone_naturelles_protegees');
        }
        $focus = $request->query->get('focus', null);
        
        $em = $this->getDoctrine()->getManager();
        $parcs = $em->getRepository('AppBundle:ParcEolien')
                        ->findAllAsArray();
        
        return $this->render('eolien/environnement.html.twig', array(
            'parcs' => $parcs,
            'focus_id' => $focus,
            'form' => $form->createView(),
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
     * @Route("/nombre-totale", name="parc_count_all")
     */
    public function countAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $count = $em->getRepository('AppBundle:ParcEolien')->findAllCount();
        $response = new Response($count);
        return $response;
    }

    /**
     * @Route("/export-csv", name="parc_export")
     */
    public function exportAction(Request $request)
    {

        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');

            $em = $this->getDoctrine()->getManager();
            $parcs = $em->getRepository('AppBundle:ParcEolien')->findAll();
            fputcsv($handle, ['ID','denomination','region','departement','commune','insee','longitude','latitude','mise_en_service','type_machine','hauteur_mat','hauteur_totale','type_machine','puissance_nominale_unitaire','puissance_nominale_totale','productible_estime','developpeur','operateur','nom_contact','telephone_contact','email_contact','description','etat'],',');
            foreach($parcs as $parc) {
                fputcsv($handle, $parc->getRowForExport(), ',');
            }

            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="eoliens.csv"');

        return $response;
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
