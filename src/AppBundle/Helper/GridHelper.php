<?php

namespace AppBundle\Helper;

use AppBundle\Entity\Projet;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\Environnement;
use AppBundle\Model\Foncier;
use AppBundle\Model\Progression;
use AppBundle\Model\Servitude;
use AppBundle\Model\Mission;
use AppBundle\Model\Niveau;
use AppBundle\Model\Batiment;
use AppBundle\Model\Technologie;
use AppBundle\Model\Etat;
use AppBundle\Model\Tache;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class GridHelper
{
    public function getJsonTypeProjets()
    {
        $data = [];
        $types = Projet::getTypeProjetList();

        foreach ($types as $code => $type) {
            $data[$code] = [
                'name' => $type,
                'data' => $types[$code],
            ];
        }

        return json_encode($data);
    }

    public function getJsonTypeSites()
    {
        $data = [];
        $types = Projet::getTypeSiteList();

        foreach ($types as $code => $type) {
            $data[$code] = [
                'name' => $type,
                'data' => $types[$code],
            ];
        }

        return json_encode($data);
    }

    public function getJsonTaches()
    {
        $data = [];
        $types = Tache::getObjetList();

        foreach ($types as $code => $type) {
            $data[$code] = [
                'name' => $type,
                'data' => Tache::getTacheType($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonTacheList()
    {
        $data = [];
        $types = Tache::getTacheList();

        foreach ($types as $code => $type) {
            $data[$code] = [
                'name' => $type,
                'data' => $types[$code],
            ];
        }

        return json_encode($data);
    }
    
    public function getJsonPhases()
    {
        $data = [];
        $phases = Etat::getPhaseList();

        foreach ($phases as $code => $phase) {
            $data[$code] = [
                'name' => $phase,
                'data' => $phases[$code],
            ];
        }

        return json_encode($data);
    }

    public function getJsonEtats()
    {
        $data = [];
        $phases = Etat::getPhaseList();

        foreach ($phases as $code => $phase) {
            $data[$code] = [
                'name' => $phase,
                'data' => Etat::getEtatType($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonTechnologies()
    {
        $data = [];
        $technologies = Technologie::getTechnologieList();

        foreach ($technologies as $code => $technologie) {
            $data[$code] = [
                'name' => $technologie,
                'data' => Technologie::getTechnologieType($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonBatiments()
    {
        $data = [];
        $batiments = Batiment::getBatimentList();

        foreach ($batiments as $code => $batiment) {
            $data[$code] = [
                'name' => $batiment,
                'data' => Batiment::getBatimentType($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonProgressions()
    {
        $data = [];
        $progressions = Progression::getProgressionList();

        foreach ($progressions as $code => $progression) {
            $data[$code] = [
                'name' => $progression,
                'color' => Progression::getProgressionColor($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonEnvironnements()
    {
        $data = [];
        $environnements = Environnement::getEnvironnementList(1);

        foreach ($environnements as $code => $environnement) {
            $data[$code] = [
                'name' => $environnement,
            ];
        }

        return json_encode($data);
    }

    public function getJsonServitudes()
    {
        $data = [];
        $servitudes = Servitude::getServitudeList();

        foreach ($servitudes as $code => $servitude) {
            $data[$code] = [
                'name' => $servitude,
                'highlight' => Servitude::isHighlighted($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonFonciers()
    {
        $data = [];
        $fonciers = Foncier::getFoncierList();

        foreach ($fonciers as $code => $foncier) {
            $data[$code] = [
                'name' => $foncier,
                'highlight' => Foncier::isHighlighted($code),
            ];
        }

        return json_encode($data);
    }

    public function getJsonAvisMairies()
    {
        $data = [];

        $avismairies = AvisMairie::getAvisMairieList();

        foreach ($avismairies as $code => $avismairie) {
            $data[$code] = [
                'name' => $avismairie,
            ];
        }

        return json_encode($data);
    }

    public function getJsonMissions()
    {
        $data = [];
        $missions = Mission::getMissionList();

        foreach ($missions as $code => $mission) {
            $data[$code] = [
                'name' => $mission,
            ];
        }

        return json_encode($data);
    }

    public function getJsonNiveaux()
    {
        $data = [];
        $niveaus = Niveau::getNiveauList();

        foreach ($niveaus as $code => $niveau) {
            $data[$code] = [
                'name' => $niveau,
            ];
        }

        return json_encode($data);
    }
}
