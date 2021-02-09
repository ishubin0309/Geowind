<?php

namespace AppBundle\Model;

use AppBundle\Model\Etat;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Progression
{
    /**
     * @return array
     */
    public static function getProgressionColors()
    {
        return [
            'nouveau' => '#FFFFFF',
            'verification' => '#FFFFFF',
            'identification' => '#FFFFFF',
            'contacts' => '#FFFFFF',
            'visites' => '#FF99FF',
            'pourpalers' => '#FF99FF',
            'signatures' => '#FF99FF',
            'sous_promesse' => '#FF99FF',
            'accord_municipal' => '#FF99FF',
            'devis_etude' => '#00FFFF',
            'budgete' => '#00FFFF',
            'a_letude' => '#00FFFF',
            'avant_projet' => '#00FFFF',
            'prerapport' => '#00FFFF',
            'projet_fige' => '#00FFFF',
            'etudes_boucles' => '#00FFFF',
            'dossier_depose' => '#0000FF',
            'completude' => '#0000FF',
            'a_lenquete' => '#0000FF',
            'replique' => '#0000FF',
            'soutenance' => '#0000FF',
            'autorise' => '#0000FF',
            'purge' => '#0000FF',
            'bornage' => '#FFFF00',
            'plan_exe' => '#FFFF00',
            'baux_signe' => '#FFFF00',
            'etude_geo' => '#FFFF00',
            'contrat_rac' => '#FFFF00',
            'contrat_achat' => '#FFFF00',
            'chiffrage' => '#00CC33',
            'data_room' => '#00CC33',
            'audits' => '#00CC33',
            'finance' => '#00CC33',
            'achats' => '#00CC33',
            'en_travaux' => '#00CC33',
            'en_service' => '#00CC33',
            'rejet' => '#FF0000',
            'abandon' => '#FF0000',
            'retenu' => '#999999',
            'en_attente' => '#FFFFFF',
            'a_negocier' => '#FF99FF',
            'a_developper' => '#00FFFF',
            'a_deposer' => '#0000FF',
            'a_construire' => '#00CC33',
            'en_recours' => '#000000',
            'refuse' => '#000000',
        ];
    }

    public static function getCssClass($progression)
    {
        if(in_array($progression, ['nouveau','verification','identification','contacts','en_attente'])) return 'indicateur-flash';
        else return 'indicateur';
    }

    /**
     * @param string $progression
     * @return string|null
     */
    public static function getProgressionColor($progression)
    {
        $colors = self::getProgressionColors();
        return isset($colors[$progression]) ? $colors[$progression] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = Etat::getEtatList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
