<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Technologie
{
    const TECHNOLOGIE_UN = 'photovoltaique';
    const TECHNOLOGIE_DEUX = 'eolienne';

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

    /**
     * @return array
     */
    public static function getTechnologieTypes()
    {
        return [
            self::TECHNOLOGIE_UN => [
                'Type' => 'Type1', 
                'Marque' => 'JNE',  
                'Modèle' => '300W', 
                'Puissance nominale' => '300Wc', 
                'Longeur' => '1640mm', 
                'Largeur' => '992mm', 
                'Epaisseur' => '40mm'
            ],
            self::TECHNOLOGIE_DEUX => [
                'Type' => 'Type2', 
                'Marque' => 'Vestas',  
                'Modèle' => 'V126', 
                'Puissance nominale' => '3Mw', 
                'Hauteur mat' => '100 m', 
                'Diamètre rotor' => '126 m', 
                'Hauteur totale' => '163 m'
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
