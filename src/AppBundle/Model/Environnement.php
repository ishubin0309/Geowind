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
    const MILIEUOUVERT = 'milieu_ouvert';
    const ZONEURBAINE = 'zone_urbaine';
    const FERME = 'ferme';
    const ACTIVITE = 'zone_activite';
    const LOTISSEMENT = 'lotissement';
    const HABITATCOLLECTIF = 'habitat_collectif';
    const ANCIENNECARRIERE = 'ancienne_carriere';
    const SITEPOLLUE = 'site_pollue';
    const DELAISSE = 'delaisse';

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
                self::ZONEMIXTE => 'Zone mixte',
                self::PATURAGES => 'Pâturages',
                self::PRAIRIE => 'Prairie',
                self::MILIEUOUVERT => 'Milieu ouvert',
                self::ZONEURBAINE => 'Zone urbaine',
                self::FERME => 'Ferme',
                self::ACTIVITE => 'Zone d\'activité',
                self::LOTISSEMENT => 'Lotissement',
                self::HABITATCOLLECTIF => 'Habitat collectif',
                self::ANCIENNECARRIERE => 'Ancienne carrière',
                self::SITEPOLLUE => 'Site pollué',
                self::DELAISSE => 'Délaissé',
            ];
        else
            return [
                self::FORET => 'Forêt',
                self::LANDES => 'Landes',
                self::TERREARABLE => 'Terre arable',
                self::ZONEMIXTE => 'Zone mixte',
                self::PATURAGES => 'Pâturages',
                self::PRAIRIE => 'Prairie',
                self::MILIEUOUVERT => 'Milieu ouvert',
                self::ZONEURBAINE => 'Zone urbaine',
                self::FERME => 'Ferme',
                self::ACTIVITE => 'Zone d\'activité',
                self::LOTISSEMENT => 'Lotissement',
                self::HABITATCOLLECTIF => 'Habitat collectif',
                self::ANCIENNECARRIERE => 'Ancienne carrière',
                self::SITEPOLLUE => 'Site pollué',
                self::DELAISSE => 'Délaissé',
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
