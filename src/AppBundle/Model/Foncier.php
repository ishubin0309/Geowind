<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Foncier
{
    const A_RECENSER = 'a_recenser';
    const RECENSE = 'recense';
    const SIGNE_PTIE = 'signe_ptie';
    const SIGNE_TOT = 'signe_tot';
    const INDISPO = 'indispo';
    const INADAPTE = 'inadapte';

    /**
     * @return array
     */
    public static function getFoncierList()
    {
        return [
            self::A_RECENSER => 'à recenser',
            self::RECENSE => 'recensé',
            self::SIGNE_PTIE => 'signé ptie',
            self::SIGNE_TOT => 'signe tot',
            self::INDISPO => 'indispo',
            self::INADAPTE => 'inadapté',
        ];
    }

    /**
     * @return array
     */
    public static function getFoncierHighlights()
    {
        return [
            self::A_RECENSER => false,
            self::RECENSE => false,
            self::SIGNE_PTIE => false,
            self::SIGNE_TOT => false,
            self::INDISPO => false,
            self::INADAPTE => false,
        ];
    }

    /**
     * @param string $foncier
     * @return bool
     */
    public static function isHighlighted($foncier)
    {
        $highlights = self::getFoncierHighlights();
        return isset($highlights[$foncier]) ? $highlights[$foncier] : false;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getFoncierList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
