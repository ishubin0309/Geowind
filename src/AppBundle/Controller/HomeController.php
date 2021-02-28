<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->render('default/index.html.twig', array(
            
        ));
    }
    /**
     * @Route("/departement-cordinates", name="departement_cordinates")
     */
    public function departementCordinatesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $departements = $em->getRepository('AppBundle:Departement')->findAll();
        foreach($departements as $departement) {
            if($departement->getLatitude() && $departement->getLongitude()) continue;
            $url = 'https://nominatim.openstreetmap.org/search?q=' .$departement->getNom(). '&extratags=0&namedetails=0&polygon_geojson=0&format=json';
            $content = $this->gCurl($url);
            if($content) {
                $data = json_decode($content, 1);
                if(is_array($data)) {
                    foreach($data as $coordinate) {
                        if(preg_match('%France%', $coordinate['display_name'])) {
                            $departement->setLatitude($coordinate['lat']);
                            $departement->setLongitude($coordinate['lon']);
                            $em->persist($departement);
                            break;
                        }
                    }
                }
            }
        }
        $em->flush();
        exit('Done');
    }
    private function gCurl($url)
    {
        $ua = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);exit($result);
        $info = curl_getinfo($ch);
        return ($info['http_code']!=200) ? false : $result;
    }
    
}
