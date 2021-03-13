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
            // self::OBJET_SIX => 'Concertation'
        ];
    }

    /**
     * @return array
     */
    public static function getTacheList()
    {
        return [
            'a_letude' => 'A l\'étude',
            'verif_positive' => 'Vérif positive (+)',
            'verif_negative' => 'Vérif négative (-)',
            'avec_requis' => 'Avis requis (-)',
            'compatible' => 'Compatible (+)',
            'incompatible' => 'Incompatible (-)',
            'neant_superflu' => 'Néant/Superflu (+)',
            'a_identifier' => 'A identifier',
            'contact_plus' => 'Contact (+)',
            'contact_minus' => 'Contact (-)',
            'visites' => 'Visites (+)',
            'signe_partie' => 'Signé en partie (+)',
            'signe_totalite' => 'Signé en totalité (+)',
            'deja_pris' => 'Déjà pris (-)',
            'inadapte' => 'Inadapté (-)',
            'a_contacter' => 'A contacter',
            'reunion' => 'Réunion (+)',
            'deliberation_plus' => 'Délibération (+)',
            'deliberation_minus' => 'Délibération (-)',
            'superflu' => 'Superflu (+)',
            'a_renseigner' => 'A renseigner',
            'compatible' => 'Compatible (+)',
            'incompatible' => 'Incompatible (-)',
            'majour_requise' => 'Majour requise (-)',
            'majour_refusee' => 'Majour refusée (-)',
            'majour_en_cours' => 'Majour en cours (+)',
            'majour_achevee' => 'Majour achevée (+)',
            'avis_sollicites' => 'Avis sollicités',
            'non_requises' => 'Non requises(+)',
            'pour_la_forme' => 'Pour la fome (+)',
            'avis_favorable' => 'Avis favorable (+)',
            'avis_defavorable' => 'Avis défavorable (-)',
            'avis_reserve' => 'Avis réservé (+)'
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
                'verif_positive' => 'Vérif positive (+)',
                'verif_negative' => 'Vérif négative (-)',
                'avec_requis' => 'Avis requis (-)',
                'compatible' => 'Compatible (+)',
                'incompatible' => 'Incompatible (-)',
                'neant_superflu' => 'Néant/Superflu (+)'
            ],
            self::OBJET_DEUX => [
                'a_identifier' => 'A identifier',
                'contact_plus' => 'Contact (+)',
                'contact_minus' => 'Contact (-)',
                'visites' => 'Visites (+)',
                'signe_partie' => 'Signé en partie (+)',
                'signe_totalite' => 'Signé en totalité (+)',
                'deja_pris' => 'Déjà pris (-)',
                'inadapte' => 'Inadapté (-)'
            ],
            self::OBJET_TROIS => [
                'a_contacter' => 'A contacter',
                'contact_plus' => 'Contact (+)',
                'contact_minus' => 'Contact (-)',
                'reunion' => 'Réunion (+)',
                'deliberation_plus' => 'Délibération (+)',
                'deliberation_minus' => 'Délibération (-)',
                'superflu' => 'Superflu (+)'
            ],
            self::OBJET_QUATRE => [
                'a_renseigner' => 'A renseigner',
                'compatible' => 'Compatible (+)',
                'incompatible' => 'Incompatible (-)',
                'majour_requise' => 'Majour requise (-)',
                'majour_refusee' => 'Majour refusée (-)',
                'majour_en_cours' => 'Majour en cours (+)',
                'majour_achevee' => 'Majour achevée (+)'
            ],
            self::OBJET_CINQ => [
                'avis_sollicites' => 'Avis sollicités',
                'non_requises' => 'Non requises(+)',
                'pour_la_forme' => 'Pour la fome (+)',
                'avis_favorable' => 'Avis favorable (+)',
                'avis_defavorable' => 'Avis défavorable (-)',
                'avis_reserve' => 'Avis réservé (+)'
            ],
            /* self::OBJET_SIX => [
            ] */
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
