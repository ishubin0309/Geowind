<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Servitude
{
    const VERIFIER = 'a_verifier';
    const COMPATIBLE = 'compatible';
    const AVIS_REQUIS = 'avis_requis';
    const INCOMPATIBLE = 'incompatible';

    public static function getServitudeList()
    {
        return [
            self::VERIFIER => 'à vérifier',
            self::COMPATIBLE => 'compatible',
            self::AVIS_REQUIS => 'avis requis',
            self::INCOMPATIBLE => 'incompatible',
        ];
    }

    /**
     * @return array
     */
    public static function getServitudeHighlights()
    {
        return [
            self::VERIFIER => false,
            self::COMPATIBLE => false,
            self::AVIS_REQUIS => false,
            self::INCOMPATIBLE => false,
        ];
    }

    /**
     * @param string $servitude
     * @return bool
     */
    public static function isHighlighted($servitude)
    {
        $highlights = self::getServitudeHighlights();
        return isset($highlights[$servitude]) ? $highlights[$servitude] : false;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getServitudeList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
