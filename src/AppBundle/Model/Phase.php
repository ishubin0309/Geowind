<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class Phase
{
    const SAISIE = 'saisie';
    const DECISION1 = 'decision1';
    const EXPLOR = 'exploration';
    const DECISION2 = 'decision2';
    const NEGOC = 'negociation';
    const DECISION3 = 'decision3';
    const DEVEL = 'developpement';
    const DECISION4 = 'decision4';
    const INSTR = 'instruction';
    const DECISION5 = 'decision5';
    const PRECONST = 'pre_construction';
    const DECISION6 = 'decision6';
    const CONSTR = 'construction';

    /**
     * @return array
     */
    public static function getPhaseList()
    {
        return [
            self::SAISIE => 'saisie',
            self::DECISION1 => 'décision1',
            self::EXPLOR => 'exploration',
            self::DECISION2 => 'décision2',
            self::NEGOC => 'négociation',
            self::DECISION3 => 'décision3',
            self::DEVEL => 'developpement',
            self::DECISION4 => 'décision4',
            self::INSTR => 'instruction',
            self::DECISION5 => 'décision5',
            self::PRECONST => 'pré-construction',
            self::DECISION6 => 'décision6',
            self::CONSTR => 'construction',
        ];
    }

    /**
     * @return array
     */
    public static function getPhaseColors()
    {
        return [
            self::SAISIE => '#FFFFFF',
            self::DECISION1 => '#000000',
            self::EXPLOR => '#CCCCCC',
            self::DECISION2 => '#FF99FF',
            self::NEGOC => '#00FFFF',
            self::DECISION3 => '#FFFF66',
            self::DEVEL => '#FFCC00',
            self::DECISION4 => '#83CAFF',
            self::INSTR => '#3333FF',
            self::DECISION5 => '#FF3300',
            self::PRECONST => '#66CC00',
            self::DECISION6 => '#FFCC00',
            self::CONSTR => '#FFCC00',
        ];
    }

    public static function getCssClass($phase)
    {
        $data = [
            self::SAISIE => 'indicateur-flash',
            self::DECISION1 => 'indicateur',
            self::EXPLOR => 'indicateur',
            self::DECISION2 => 'indicateur',
            self::NEGOC => 'indicateur',
            self::DECISION3 => 'indicateur',
            self::DEVEL => 'indicateur',
            self::DECISION4 => 'indicateur',
            self::INSTR => 'indicateur',
            self::DECISION5 => 'indicateur',
            self::PRECONST => 'indicateur',
            self::DECISION6 => 'indicateur',
            self::CONSTR => 'indicateur',
        ];

        return isset($data[$phase]) ? $data[$phase] : null;
    }

    /**
     * @param string $phase
     * @return string|null
     */
    public static function getPhaseColor($phase)
    {
        $colors = self::getPhaseColors();
        return isset($colors[$phase]) ? $colors[$phase] : null;
    }

    /**
     * @param string $code
     * @return string
     */
    public static function getName($code)
    {
        $names = self::getPhaseList();
        return isset($names[$code]) ? $names[$code] : '';
    }
}
