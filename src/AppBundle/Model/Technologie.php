<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Technologie
{
    const TECHNOLOGIE_UN = 'photovoltaique';
    const TECHNOLOGIE_DEUX = 'eolienne';

    const EQUIPEMENT_UN = 'type1';
    const EQUIPEMENT_DEUX = 'type2';
    const EQUIPEMENT_TROIS = 'type3';
    const EQUIPEMENT_QUATRE = 'type4';

    /**
     * @return array
     */
    public static function getTechnologieList()
    {
        return [
            self::TECHNOLOGIE_UN => 'photovoltaïque',
            self::TECHNOLOGIE_DEUX => 'Eolienne'
        ];
    }
    public static function getEquipementList()
    {
        return [
            self::EQUIPEMENT_UN => 'Type1',
            self::EQUIPEMENT_DEUX => 'Type2',
            self::EQUIPEMENT_TROIS => 'Type3',
            self::EQUIPEMENT_QUATRE => 'Type4'
        ];
    }

    /**
     * @return array
     */
    public static function getTechnologieTypes()
    {
        return [
            self::TECHNOLOGIE_UN => [
                'Type1' => [
                    'Marque' => 'JNE',  
                    'Modèle' => '300W', 
                    'Puissance nominale (Wc)' => '300', 
                    'Longeur (mm)' => '1640', 
                    'Largeur (mm)' => '992', 
                    'Epaisseur (mm)' => '40'
                ]
            ],
            self::TECHNOLOGIE_DEUX => [
                'Type1 (50m-0,8Mw)' => [
                    'Marque' => 'Enercon',  
                    'Modèle' => 'E53', 
                    'Puissance nominale (Mw)' => '0,8', 
                    'Hauteur mat (m)' => '50', 
                    'Diamètre rotor (m)' => '52,9', 
                    'Hauteur totale(m)' => '76,45'
                ],
                'Type2 (59m-1Mw)' => [
                    'Marque' => 'EWT',  
                    'Modèle' => 'DW61', 
                    'Puissance nominale (Mw)' => '1', 
                    'Hauteur mat (m)' => '59', 
                    'Diamètre rotor (m)' => '60,9', 
                    'Hauteur totale(m)' => '89,45'
                ],
                'Type3 (100m-3Mw)' => [
                    'Marque' => 'Vestas',  
                    'Modèle' => 'V126', 
                    'Puissance nominale (Mw)' => '3', 
                    'Hauteur mat (m)' => '100', 
                    'Diamètre rotor (m)' => '126', 
                    'Hauteur totale(m)' => '163'
                ],
                'Type4 (35m-0,9Mw)' => [
                    'Marque' => 'EWT',  
                    'Modèle' => 'DW52', 
                    'Puissance nominale (Mw)' => '0,9', 
                    'Hauteur mat (m)' => '35', 
                    'Diamètre rotor (m)' => '51,5', 
                    'Hauteur totale(m)' => '60,75'
                ],
            ]
        ];
    }

    /**
     * @param string $technologie
     * @return string|null
     */
    public static function getTechnologieType($technologie)
    {
        $types = self::getTechnologieTypes();
        return isset($types[$technologie]) ? $types[$technologie] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getTechnologieList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
