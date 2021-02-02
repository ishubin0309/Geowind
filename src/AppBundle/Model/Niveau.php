<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Niveau
{
    const EXPLORATOIRE = 'exploratoire';
    const PREDIAG = 'prediag';
    const ETUDE_IMPACT = 'etude_impact';
    const INST = 'inst';

    /**
     * @return array
     */
    public static function getNiveauList()
    {
        return [
            self::EXPLORATOIRE => 'exploratoire',
            self::PREDIAG => 'prédiag',
            self::ETUDE_IMPACT => 'étude d\'impact',
            self::INST => 'inst',
        ];
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getNiveauList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
