<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Concertation
{
    /**
     * @return array
     */
    public static function getObjetList()
    {
        return [
            'reporting' => 'Reporting',
            'rendez_vous' => 'Rendez-vous',
            'phasage' => 'Phasage',
            'preconsultation' => 'Préconsultation',
            'presentation' => 'Présentation',
            'avis' => 'Avis',
            'information' => 'Information',
            'etude' => 'Etude',
            'soutenance' => 'Soutenance',
            'memoire' => 'Mémoire',
            'reunion' => 'Réunion',
            'porte_ouverte' => 'Porte ouverte'
        ];
    }

    /**
     * @return array
     */
    public static function getDestinataireList()
    {
        return [
            'equipe' => 'EQUIPE',
            'partenaire' => 'PARTENAIRE',
            'proprietaires' => 'PROPRIETAIRES',
            'maire' => 'MAIRE',
            'conseil_municipal' => 'CONSEIL MUNICIPAL',
            'epci' => 'EPCI',
            'armee' => 'ARMEE',
            'dgac' => 'DGAC',
            'dot' => 'DDT',
            'meteo_france' => 'METEO FRANCE',
            'dreal' => 'DREAL',
            'stap' => 'STAP',
            'enedis' => 'ENEDIS',
            'anfr' => 'ANFR',
            'voirie' => 'VOIRIE',
            'sdis' => 'SDIS',
            'grt_gaz' => 'GRT-GAZ',
            'drac' => 'DRAC',
            'chambre_agriculture' => 'Chambre d’Agriculture',
            'prefecture' => 'PREFECTURE',
            'enqueteur' => 'ENQUETEUR',
            'public' => 'PUBLIC'
        ];
    }

    /**
     * @return array
     */
    public static function getConcertationTypes()
    {
        return [
        ];
    }

    /**
     * @param string $concertation
     * @return string|null
     */
    public static function getConcertationType($concertation)
    {
        $types = self::getConcertationTypes();
        return isset($types[$concertation]) ? $types[$concertation] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getObjetList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
