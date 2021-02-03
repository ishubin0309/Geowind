<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Etat
{
    const PHASE_UN = 'exploratoire';
    const PHASE_DEUX = 'decision1';
    const PHASE_TROIS = 'negociation';
    const PHASE_QUATRE = 'decision2';
    const PHASE_CINQ = 'developpement';
    const PHASE_SIX = 'decision3';
    const PHASE_SEPT = 'instruction';
    const PHASE_HUIT = 'decision4';
    const PHASE_NEUF = 'preconstruction';
    const PHASE_DIX = 'decision5';
    const PHASE_ONZE = 'construction';

    /**
     * @return array
     */
    public static function getPhaseList()
    {
        return [
            self::PHASE_UN => 'Exploratoire',
            self::PHASE_DEUX => 'Décision1',
            self::PHASE_TROIS => 'Négociation',
            self::PHASE_QUATRE => 'Décision2',
            self::PHASE_CINQ => 'Développement',
            self::PHASE_SIX => 'Décision3',
            self::PHASE_SEPT => 'Instruction',
            self::PHASE_HUIT => 'Décision4',
            self::PHASE_NEUF => 'Pré-construction',
            self::PHASE_DIX => 'Décision5',
            self::PHASE_ONZE => 'Construction'
        ];
    }
    /**
     * @return array
     */
    public static function getDynamiqueList()
    {
        return [
            '++' => '++',
            '+' => '+',
            '0' => '0',
            '-' => '-',
            '--' => '--',
        ];
    }

    /**
     * @return array
     */
    public static function getEtatList()
    {
        return [
            'nouveau' => 'Nouveau',
            'verification' => 'Vérification',
            'identification' => 'Identification',
            'contacts' => 'Contacts',
            'visites' => 'Visites',
            'pourpalers' => 'Pourpalers',
            'signatures' => 'Signatures',
            'sous_promesse' => 'Sous promesse',
            'accord_municipal' => 'Accord municipal',
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
            'en_travaux' => 'En travaux',
            'en_service' => 'En service',
            'rejet' => 'Rejeté',
            'abandon' => 'Abandon',
            'retenu' => 'Retenu',
            'en_attente' => 'En attente',
            'a_negocier' => 'A négocier',
            'a_developper' => 'A développer',
            'a_deposer' => 'A déposer',
            'a_construire' => 'A construire',
            'en_recours' => 'En recours',
            'refuse' => 'Refusé',
        ];
    }

    /**
     * @return array
     */
    public static function getEtatTypes()
    {
        $decision = [
            'rejet' => 'Rejeté',
            'abandon' => 'Abandon',
            'retenu' => 'Retenu',
            'en_attente' => 'En attente',
            'a_negocier' => 'A négocier',
            'a_developper' => 'A développer',
            'a_deposer' => 'A déposer',
            'a_construire' => 'A construire',
            'en_recours' => 'En recours',
            'refuse' => 'Refusé'
        ];
        return [
            self::PHASE_UN => [
                'nouveau' => 'Nouveau',
                'verification' => 'Vérification',
                'identification' => 'Identification',
                'contacts' => 'Contacts'
            ],
            self::PHASE_DEUX => $decision,
            self::PHASE_TROIS => [
                'visites' => 'Visites',
                'pourpalers' => 'Pourpalers',
                'signatures' => 'Signatures',
                'sous_promesse' => 'Sous promesse',
                'accord_municipal' => 'Accord municipal'
            ],
            self::PHASE_QUATRE => $decision,
            self::PHASE_CINQ => [
                'devis_etude' => 'Devis d\'études',
                'budgete' => 'Budgété',
                'a_letude' => 'A l\'étude',
                'avant_projet' => 'Avant projet',
                'prerapport' => 'Prérapport',
                'projet_fige' => 'Projet figé',
                'etudes_boucles' => 'Etudes bouclées'
            ],
            self::PHASE_SIX => $decision,
            self::PHASE_SEPT => [
                'dossier_depose' => 'Dossier déposé',
                'completude' => 'Complétude',
                'a_lenquete' => 'A l\'enquête',
                'replique' => 'Réplique',
                'soutenance' => 'Soutenance',
                'autorise' => 'Autorisé',
                'purge' => 'Purgé'
            ],
            self::PHASE_HUIT => $decision,
            self::PHASE_NEUF => [
                'bornage' => 'Bornage',
                'plan_exe' => 'Plan Exe',
                'baux_signe' => 'Baux signés',
                'etude_geo' => 'Etude géo',
                'contrat_rac' => 'Contrat de rac',
                'contrat_achat' => 'Contrat d\'achat'
            ],
            self::PHASE_DIX => $decision,
            self::PHASE_ONZE => [
                'chiffrage' => 'Chiffrage',
                'data_room' => 'Data room',
                'audits' => 'Audits',
                'finance' => 'Finançé',
                'achats' => 'Achats',
                'en_travaux' => 'En travaux',
                'en_service' => 'En service'
            ]
        ];
    }

    /**
     * @param string $etat
     * @return string|null
     */
    public static function getEtatType($etat)
    {
        $types = self::getEtatTypes();
        return isset($types[$etat]) ? $types[$etat] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getPhaseList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
