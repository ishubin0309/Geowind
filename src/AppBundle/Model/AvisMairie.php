<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class AvisMairie
{
    const CONTACTER = 'contacter';
    const FACULTATIF = 'facultatif';
    const INJOIGNABLE = 'injoignable';
    const CONTACT_MINUS = 'contact_minus';
    const CONTACT_PLUS = 'contact_plus';
    const INDECIS = 'indecis';
    const DELIB_PLUS = 'delib_plus';
    const DELIB_MINUS = 'delib_minus';

    /**
     * @return array
     */
    public static function getAvisMairieList()
    {
        return [
            self::CONTACTER => 'à contacter',
            self::FACULTATIF => 'facultatif',
            self::INJOIGNABLE => 'injoignable',
            self::CONTACT_MINUS => 'contact(-)',
            self::CONTACT_PLUS => 'contact(+)',
            self::INDECIS => 'indécis',
            self::DELIB_PLUS => 'délib(+)',
            self::DELIB_MINUS => 'délib(-)',
        ];
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getAvisMairieList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
