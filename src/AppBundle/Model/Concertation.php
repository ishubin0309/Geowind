<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Concertation
{
    const OBJET_UN = 'presentation';
    const OBJET_DEUX = 'avis';
    const OBJET_TROIS = 'infomation';
    const OBJET_QUATRE = 'etude';
    const OBJET_CINQ = 'soutenance';
    const OBJET_SIX = 'memoire';
    const OBJET_SEPT = 'reunion';
    const OBJET_HUIT = 'porte_ouverte';
    const OBJET_NEUF = 'reporting';

    /**
     * @return array
     */
    public static function getObjetList()
    {
        return [
            self::OBJET_NEUF => 'Reporting',
            self::OBJET_UN => 'Présentation',
            self::OBJET_DEUX => 'Avis',
            self::OBJET_TROIS => 'Infomation',
            self::OBJET_QUATRE => 'Etude',
            self::OBJET_CINQ => 'Soutenance',
            self::OBJET_SIX => 'Mémoire',
            self::OBJET_SEPT => 'Réunion',
            self::OBJET_HUIT => 'Porte ouverte'
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
            'commune' => 'COMMUNE',
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
