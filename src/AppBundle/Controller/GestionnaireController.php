<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Gestionnaire;
use AppBundle\Entity\Import;
use AppBundle\Form\ImportType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @Route("/app/gestionnaire")
 */
class GestionnaireController extends Controller
{
    /**
     * @Route("/", name="gestionnaire_index")
     */
    public function gestionnaireAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        
        $import = new Import();
        $form = $this->createForm(ImportType::class, $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file_path = $import->getImportFile();
            $this->importFile($file_path);
        }

        $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')
                        ->findAll();

        return $this->render('gestionnaire/gestionnaire.html.twig', [
            'gestionnaires' => $gestionnaires,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/csv/update", name="gestionnaire_update")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function gestionnaireUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $file_path = __DIR__ . '/../Gestionnaires.csv';
        $row = 0;
        if(file_exists($file_path)) {
            $this->importFile($file_path);
            return new Response('Done');
        } else new Response('Fichier introuvable');
    }

    private function importFile($file_path)
    {
        $em = $this->getDoctrine()->getManager();

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
                    $gestionnaireColumn = 0;
                    $competenceColumn = 1;
                    $contactColumn = 2;
                    $fonctionColumn = 3;
                    $adresseColumn = 4;
                    $villeColumn = 5;
                    $emailColumn = 6;
                    $telephoneColumn = 7;
                    $departementColumn = 8;
                    $parcs = $em->getRepository('AppBundle:Gestionnaire')->emptyTable();
                    continue;
                }
                // if($row > 10) continue;
                $data = array_map("utf8_encode", $data);
                $departement = $em->getRepository('AppBundle:Departement')->findOneBy(['code' => $data[$departementColumn]]);
                if(empty($departement)) {
                    continue;
                }
                $gestionnaire = new Gestionnaire;
                $gestionnaire->setGestionnaire($data[$gestionnaireColumn]);
                $gestionnaire->setCompetence($data[$competenceColumn]);
                $gestionnaire->setContact($data[$contactColumn]);
                $gestionnaire->setFonction($data[$fonctionColumn]);
                $gestionnaire->setAdresse($data[$adresseColumn]);
                $gestionnaire->setVille($data[$villeColumn]);
                $gestionnaire->setEmail($data[$emailColumn]);
                $gestionnaire->setTelephone($data[$telephoneColumn]);
                $gestionnaire->setDepartement($departement);
                $em->persist($gestionnaire);
                if($row % 50 == 0) {
                    $em->flush();
                    echo $row . ',';
                }
            }
            fclose($handle);
            $em->flush();
        }
    }

    /**
     * @Route("/nombre-totale", name="gestionnaire_count_all")
     */
    public function countAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $count = $em->getRepository('AppBundle:Gestionnaire')->findAllCount();
        $response = new Response($count);
        return $response;
    }

    /**
     * @Route("/export-csv", name="gestionnaire_export")
     */
    public function exportAction(Request $request)
    {

        $response = new StreamedResponse();
        $response->setCallback(function() {
            $handle = fopen('php://output', 'w+');

            $em = $this->getDoctrine()->getManager();
            $gestionnaires = $em->getRepository('AppBundle:Gestionnaire')->findAll();
            fputcsv($handle, ['Gestionnaire','Compétence','Contact','Fonction','Adresse','Ville','Email','Téléphone','Département_num','Département_min','Département_maj'],',');
            foreach($gestionnaires as $gestionnaire) {
                fputcsv($handle, $gestionnaire->getRowForExport(), ',');
            }

            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="eoliens.csv"');

        return $response;
    }
}
