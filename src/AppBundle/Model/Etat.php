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

    const DYNAMIQUE_UN = '1';
    const DYNAMIQUE_DEUX = '2';
    const DYNAMIQUE_TROIS = '3';

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
            self::DYNAMIQUE_UN => '+',
            self::DYNAMIQUE_DEUX => '0',
            self::DYNAMIQUE_TROIS => '-'
        ];
    }

    /**
     * @return array
     */
    public static function getEtatList()
    {
        return [
            'nouveau' => 'Nouveau',
            // 'esquisse' => 'Esquisse',
            // 'fiche_complete' => 'Fiche complète',
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
            'en_travaux' => 'En travaux',
            'rejet_1' => 'Rejet',
            'admis_1' => 'Admis',
            'abandon_1' => 'Abandon',
            'en_attente_1' => 'En attente',
            'negocier_1' => 'Négocier',
            'a_deposer_1' => 'A déposer',
            'construire_1' => 'Construire',
            'cession_1' => 'Cession'
        ];
    }

    /**
     * @return array
     */
    public static function getEtatTypes()
    {
        $decision = [
            'rejet' => 'Rejet',
            'admis' => 'Admis',
            'abandon' => 'Abandon',
            'en_attente' => 'En attente',
            'negocier' => 'Négocier',
            'a_deposer' => 'A déposer',
            'construire' => 'Construire',
            'cession' => 'Cession'
        ];
        return [
            self::PHASE_UN => [
                // 'esquisse' => 'Esquisse',
                'nouveau' => 'Nouveau',
                // 'fiche_complete' => 'Fiche complète',
                'verification' => 'Vérification',
                'identification' => 'Identification',
                'contacts' => 'Contacts'
            ],
            self::PHASE_DEUX => [
                'rejet_1' => 'Rejet',
                'admis_1' => 'Admis',
                'abandon_1' => 'Abandon',
                'en_attente_1' => 'En attente',
                'negocier_1' => 'Négocier',
                'a_deposer_1' => 'A déposer',
                'construire_1' => 'Construire',
                'cession_1' => 'Cession'
            ],
            self::PHASE_TROIS => [
                'visites' => 'Visites',
                'pourpalers' => 'Pourpalers',
                'signatures' => 'Signatures',
                'sous_promesse' => 'Sous promesse'
            ],
            self::PHASE_QUATRE => [
                'rejet_2' => 'Rejet',
                'admis_2' => 'Admis',
                'abandon_2' => 'Abandon',
                'en_attente_2' => 'En attente',
                'negocier_2' => 'Négocier',
                'a_deposer_2' => 'A déposer',
                'construire_2' => 'Construire',
                'cession_2' => 'Cession'
            ],
            self::PHASE_CINQ => [
                'developpement' => 'Développement',
                'devis_etude' => 'Devis d\'études',
                'budgete' => 'Budgété',
                'a_letude' => 'A l\'étude',
                'avant_projet' => 'Avant projet',
                'prerapport' => 'Prérapport',
                'projet_fige' => 'Projet figé',
                'etudes_boucles' => 'Etudes bouclées'
            ],
            self::PHASE_SIX => [
                'rejet_3' => 'Rejet',
                'admis_3' => 'Admis',
                'abandon_3' => 'Abandon',
                'en_attente_3' => 'En attente',
                'negocier_3' => 'Négocier',
                'a_deposer_3' => 'A déposer',
                'construire_3' => 'Construire',
                'cession_3' => 'Cession'
            ],
            self::PHASE_SEPT => [
                'dossier_depose' => 'Dossier déposé',
                'completude' => 'Complétude',
                'a_lenquete' => 'A l\'enquête',
                'replique' => 'Réplique',
                'soutenance' => 'Soutenance',
                'autorise' => 'Autorisé',
                'purge' => 'Purgé'
            ],
            self::PHASE_HUIT => [
                'rejet_4' => 'Rejet',
                'admis_4' => 'Admis',
                'abandon_4' => 'Abandon',
                'en_attente_4' => 'En attente',
                'negocier_4' => 'Négocier',
                'a_deposer_4' => 'A déposer',
                'construire_4' => 'Construire',
                'cession_4' => 'Cession'
            ],
            self::PHASE_NEUF => [
                'bornage' => 'Bornage',
                'plan_exe' => 'Plan Exe',
                'baux_signe' => 'Baux signés',
                'etude_geo' => 'Etude géo',
                'contrat_rac' => 'Contrat de rac',
                'contrat_achat' => 'Contrat d\'achat'
            ],
            self::PHASE_DIX => [
                'rejet_5' => 'Rejet',
                'admis_5' => 'Admis',
                'abandon_5' => 'Abandon',
                'en_attente_5' => 'En attente',
                'negocier_5' => 'Négocier',
                'a_deposer_5' => 'A déposer',
                'construire_5' => 'Construire',
                'cession_5' => 'Cession'
            ],
            self::PHASE_ONZE => [
                'chiffrage' => 'Chiffrage',
                'data_room' => 'Data room',
                'audits' => 'Audits',
                'finance' => 'Finançé',
                'achats' => 'Achats',
                'en_service' => 'En service',
                'en_travaux' => 'En travaux'
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
