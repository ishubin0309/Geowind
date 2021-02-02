<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Progression
{
    const EN_VERIF = 'en_verif';
    const ECARTE = 'ecarte';
    const EN_STBY = 'en_stby';
    const RETENU = 'retenu';
    const EN_SECUR = 'en_secur';
    const EN_DVPT = 'en_dvpt';
    const EN_DVPT2 = 'en_dvpt2';
    const EN_INST = 'en_inst';
    const AUTORISE = 'autorise';
    const REFUSE = 'refuse';
    const CONSTRUIT = 'construit';
    const EN_RECOURS = 'en_recours';

    /**
     * @return array
     */
    public static function getProgressionList()
    {
        return [
            'nouveau' => 'Nouveau',
            // 'esquisse' => 'Esquisse',
            'fiche_complete' => 'Fiche complète',
            'verification' => 'Vérification',
            'identification' => 'Identification',
            'contacts' => 'Contacts',
            'visites' => 'Visites',
            'pourpalers' => 'Pourpalers',
            'signatures' => 'Signatures',
            'sous_promesse' => 'Sous promesse',
            'developpement' => 'Développement',
            'devis_etude' => 'Devis d\'études',
            'budgete' => 'Budgété',
            'a_letude' => 'A l\'étude',
            'avant_projet' => 'Avant projet',
            'prerapport' => 'Prérapport',
            'projet_fige' => 'Projet figé',
            'etudes_boucles' => 'Etudes bouclées',
            'dossier_depose' => 'Dossier déposé',
            'completude' => 'Complétude',
            'a_lenquete' => 'A l\'enquête',
            'replique' => 'Réplique',
            'soutenance' => 'Soutenance',
            'autorise' => 'Autorisé',
            'purge' => 'Purgé',
            'bornage' => 'Bornage',
            'plan_exe' => 'Plan Exe',
            'baux_signe' => 'Baux signés',
            'etude_geo' => 'Etude géo',
            'contrat_rac' => 'Contrat de rac',
            'contrat_achat' => 'Contrat d\'achat',
            'chiffrage' => 'Chiffrage',
            'data_room' => 'Data room',
            'audits' => 'Audits',
            'finance' => 'Finançé',
            'achats' => 'Achats',
            'en_service' => 'En service',
            'en_travaux' => 'En travaux'
        ];
    }

    /**
     * @return array
     */
    public static function getProgressionColors()
    {
        return [
            self::EN_VERIF => '#FFFFFF',
            self::ECARTE => '#000000',
            self::EN_STBY => '#CCCCCC',
            self::RETENU => '#FF99FF',
            self::EN_SECUR => '#00FFFF',
            self::EN_DVPT => '#FFFF66',
            self::EN_DVPT2 => '#FFCC00',
            self::EN_INST => '#83CAFF',
            self::AUTORISE => '#3333FF',
            self::REFUSE => '#FF3300',
            self::CONSTRUIT => '#66CC00',
            self::EN_RECOURS => '#FFCC00',
            'nouveau' => '#FFFFFF',
            // 'esquisse' => '#FFFFFF',
            'fiche_complete' => '#FFFFFF',
            'verification' => '#FFFFFF',
            'identification' => '#FFFFFF',
            'contacts' => '#FFFFFF',
            'visites' => '#FFFFFF',
            'pourpalers' => '#FFFFFF',
            'signatures' => '#FFFFFF',
            'sous_promesse' => '#FFFFFF',
            'developpement' => '#FFFFFF',
            'devis_etude' => '#FFFFFF',
            'budgete' => '#FFFFFF',
            'a_letude' => '#FFFFFF',
            'avant_projet' => '#FFFFFF',
            'prerapport' => '#FFFFFF',
            'projet_fige' => '#FFFFFF',
            'etudes_boucles' => '#FFFFFF',
            'dossier_depose' => '#FFFFFF',
            'completude' => '#FFFFFF',
            'a_lenquete' => '#FFFFFF',
            'replique' => '#FFFFFF',
            'soutenance' => '#FFFFFF',
            'autorise' => '#FFFFFF',
            'purge' => '#FFFFFF',
            'bornage' => '#FFFFFF',
            'plan_exe' => '#FFFFFF',
            'baux_signe' => '#FFFFFF',
            'etude_geo' => '#FFFFFF',
            'contrat_rac' => '#FFFFFF',
            'contrat_achat' => '#FFFFFF',
            'chiffrage' => '#FFFFFF',
            'data_room' => '#FFFFFF',
            'audits' => '#FFFFFF',
            'finance' => '#FFFFFF',
            'achats' => '#FFFFFF',
            'en_service' => '#FFFFFF',
            'en_travaux' => '#FFFFFF',
        ];
    }

    public static function getCssClass($progression)
    {
        $data = [
            self::EN_VERIF => 'indicateur-flash',
            self::ECARTE => 'indicateur',
            self::EN_STBY => 'indicateur',
            self::RETENU => 'indicateur',
            self::EN_SECUR => 'indicateur',
            self::EN_DVPT => 'indicateur',
            self::EN_DVPT2 => 'indicateur',
            self::EN_INST => 'indicateur',
            self::AUTORISE => 'indicateur',
            self::REFUSE => 'indicateur',
            self::CONSTRUIT => 'indicateur',
            self::EN_RECOURS => 'indicateur',
        ];

        return isset($data[$progression]) ? $data[$progression] : null;
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
        $names = self::getProgressionList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
