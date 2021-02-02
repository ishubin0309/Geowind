<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Mission
{
    const ACCP = 'accp';
    const ETUDE = 'etude';
    const REPRO = 'repro';
    const FRAIS_DIVERS = 'frais_divers';

    /**
     * @return array
     */
    public static function getMissionList()
    {
        return [
            self::ACCP => 'accp',
            self::ETUDE => 'étude',
            self::REPRO => 'repro',
            self::FRAIS_DIVERS => 'frais divers',
        ];
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getMissionList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
