<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Tache
{
    const OBJET_UN = 'servitudes';
    const OBJET_DEUX = 'foncier';
    const OBJET_TROIS = 'mairie';
    const OBJET_QUATRE = 'urbanisme';
    const OBJET_CINQ = 'consultations';
    const OBJET_SIX = 'concertation';

    const DYNAMIQUE_UN = '1';
    const DYNAMIQUE_DEUX = '2';
    const DYNAMIQUE_TROIS = '3';

    /**
     * @return array
     */
    public static function getObjetList()
    {
        return [
            self::OBJET_UN => 'Servitudes',
            self::OBJET_DEUX => 'Foncier',
            self::OBJET_TROIS => 'Mairie',
            self::OBJET_QUATRE => 'Urbanisme',
            self::OBJET_CINQ => 'Consultations',
            self::OBJET_SIX => 'Concertation'
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
    public static function getTacheList()
    {
        return [
            'a_letude' => 'A l\'étude',
            'servitudes_incompatible' => 'Incompatible (-)',
            'servitudes_compatible' => 'Compatible (+)',
            'imitations' => 'Limitations (+)',
            'neant' => 'Néant (+)',
            'risque' => 'Risque (-)',
            'identification' => 'Identification',
            'foncier_contact_plus' => 'Contact (+)',
            'foncier_contact_minus' => 'Contact (-)',
            'visites' => 'Visites (0)',
            'signe' => 'Signé (+)',
            'indisponible' => 'Indisponible (-)',
            'inadapte' => 'Inadapté (-)',
            'a_contacter' => 'A contacter',
            'mairie_contact_plus' => 'Contact (+)',
            'mairie_contact_minus' => 'Contact (-)',
            'delib_plus' => 'Délib (+)',
            'delib_minus' => 'Délib (-)',
            'non_requis' => 'Non requis',
            'urbanisme_compatible' => 'Compatible (+)',
            'urbanisme_incompatible' => 'Incompatible (-)',
            'maj_requise' => 'Maj requise (-)',
            'maj_refusee' => 'Maj refusée (-)',
            'maj_en_cours' => 'Maj en cours (+)',
            'non_requises' => 'Non requises(+)',
            'requises' => 'Requises',
            'envoyees' => 'Envoyées (0)',
            'reponse_plus' => 'Réponse (+)',
            'reponse_minus' => 'Réponse (-)'
        ];
    }

    /**
     * @return array
     */
    public static function getTacheTypes()
    {
        return [
            self::OBJET_UN => [
                'a_letude' => 'A l\'étude',
                'servitudes_incompatible' => 'Incompatible (-)',
                'servitudes_compatible' => 'Compatible (+)',
                'imitations' => 'Limitations (+)',
                'neant' => 'Néant (+)',
                'risque' => 'Risque (-)'
            ],
            self::OBJET_DEUX => [
                'identification' => 'Identification',
                'foncier_contact_plus' => 'Contact (+)',
                'foncier_contact_minus' => 'Contact (-)',
                'visites' => 'Visites (0)',
                'signe' => 'Signé (+)',
                'indisponible' => 'Indisponible (-)',
                'inadapte' => 'Inadapté (-)'
            ],
            self::OBJET_TROIS => [
                'a_contacter' => 'A contacter',
                'mairie_contact_plus' => 'Contact (+)',
                'mairie_contact_minus' => 'Contact (-)',
                'delib_plus' => 'Délib (+)',
                'delib_minus' => 'Délib (-)',
                'non_requis' => 'Non requis'
            ],
            self::OBJET_QUATRE => [
                'urbanisme_compatible' => 'Compatible (+)',
                'urbanisme_incompatible' => 'Incompatible (-)',
                'maj_requise' => 'Maj requise (-)',
                'maj_refusee' => 'Maj refusée (-)',
                'maj_en_cours' => 'Maj en cours (+)',
            ],
            self::OBJET_CINQ => [
                'non_requises' => 'Non requises(+)',
                'requises' => 'Requises',
                'envoyees' => 'Envoyées (0)',
                'reponse_plus' => 'Réponse (+)',
                'reponse_minus' => 'Réponse (-)',
            ],
            self::OBJET_SIX => [
            ]
        ];
    }

    /**
     * @param string $tache
     * @return string|null
     */
    public static function getTacheType($tache)
    {
        $types = self::getTacheTypes();
        return isset($types[$tache]) ? $types[$tache] : null;
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
