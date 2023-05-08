<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Environnement
{
    const BOISEOLD = 'boise';
    const BOCCAGEROLD = 'boccager';
    const OUVERTOLD = 'ouvert';
    const DEGRADEOLD = 'degrade';
    const FERMEOLD = 'ferme';
    const URBAINOLD = 'urbain';
    
    const FORET = 'foret';
    const LANDES = 'landes';
    const TERREARABLE = 'terre_arable';
    const ZONEMIXTE = 'zone_mixte';
    const PATURAGES = 'paturages';
    const PRAIRIE = 'prairie';
    const VERGER = 'verger';
    const ZONEURBAINE = 'zone_urbaine';
    const EXPLOITATION_AGRICOLE = 'exploitation_agricole';
    const ACTIVITE = 'zone_activite';
    const LOTISSEMENT = 'lotissement';
    const HABITATCOLLECTIF = 'habitat_collectif';
    const ANCIENNECARRIERE = 'ancienne_carriere';
    const SITEPOLLUE = 'site_pollue';
    const DELAISSE = 'delaisse';
    const TERRE_ELEVAGE = 'terre_elevage';
    const FRICHE_AGRICOLE = 'friche_agricole';

    /**
     * @return array
     */
    public static function getEnvironnementList($old_included=false)
    {
        if($old_included)
            return [
                self::BOISEOLD => 'boisé',
                self::BOCCAGEROLD => 'boccager',
                self::OUVERTOLD => 'ouvert',
                self::DEGRADEOLD => 'dégradé',
                self::FERMEOLD => 'ferme',
                self::URBAINOLD => 'urbain',

                self::FORET => 'Forêt',
                self::LANDES => 'Landes',
                self::TERREARABLE => 'Terre arable',
                self::ZONEMIXTE => 'Grandes cultures',
                self::PATURAGES => 'Pâturages',
                self::PRAIRIE => 'Prairie',
                self::VERGER => 'Verger',
                self::ZONEURBAINE => 'Zone urbaine',
                self::EXPLOITATION_AGRICOLE => 'Exploitation agricole',
                self::ACTIVITE => 'Zone d\'activité',
                self::LOTISSEMENT => 'Lotissement',
                self::HABITATCOLLECTIF => 'Habitat collectif',
                self::ANCIENNECARRIERE => 'Ancienne carrière',
                self::SITEPOLLUE => 'Site pollué',
                self::DELAISSE => 'Délaissé',
                self::TERRE_ELEVAGE => 'Terre d\'élevage',
                self::FRICHE_AGRICOLE => 'Friche agricole',
            ];
        else
            return [
                self::FORET => 'Forêt',
                self::LANDES => 'Landes',
                self::TERREARABLE => 'Terre arable',
                self::ZONEMIXTE => 'Grandes cultures',
                self::PATURAGES => 'Pâturages',
                self::PRAIRIE => 'Prairie',
                self::VERGER => 'Verger',
                self::ZONEURBAINE => 'Zone urbaine',
                self::EXPLOITATION_AGRICOLE => 'Exploitation agricole',
                self::ACTIVITE => 'Zone d\'activité',
                self::LOTISSEMENT => 'Lotissement',
                self::HABITATCOLLECTIF => 'Habitat collectif',
                self::ANCIENNECARRIERE => 'Ancienne carrière',
                self::SITEPOLLUE => 'Site pollué',
                self::DELAISSE => 'Délaissé',
                self::TERRE_ELEVAGE => 'Terre d\'élevage',
                self::FRICHE_AGRICOLE => 'Friche agricole',
            ];
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getEnvironnementList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
