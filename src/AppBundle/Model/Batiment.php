<?php

namespace AppBundle\Model;

/**
 * @author Haffoudhi
 */
class Batiment
{
    const BATIMENT_UN = 'type1';

    /**
     * @return array
     */
    public static function getBatimentList($old_included=false)
    {
        return [
            self::BATIMENT_UN => 'Panneau photovoltaïque',
        ];
    }

    /**
     * @return array
     */
    public static function getBatimentTypes()
    {
        return [
            self::BATIMENT_UN => [
                // 'Type' => 'Type1',
                'Photo' => 'BatimeType1.JPG',
                'Longueur' => '36 m',
                'Largeur' => '18 m',
                'Surface au sol' => '648 m²',
                'Surface utile' => '500 m²',
                'Travées' => '2',
                'Faitage' => '10 m',
                'Bas de pente' => '3 m',
                'Haut de pente' => '6 m',
                'Pente (%)' => '39%',
                'Bardage' => ['Sans', 'Nord', 'Sud', 'Est', 'Ouest'],
                'Ossature' => ['Metallique', 'Bois', 'Béton'],
                'Charpente' => ['Metallique', 'Bois', 'Béton'],
                'Couverture' => ['Bac acier', 'Fibrociment', 'PV']
            ],
        ];
    }

    /**
     * @param string $batiment
     * @return string|null
     */
    public static function getBatimentType($batiment)
    {
        $types = self::getBatimentTypes();
        return isset($types[$batiment]) ? $types[$batiment] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getBatimentList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
