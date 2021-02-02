<?php

namespace AppBundle\Helper;

use AppBundle\Model\Progression;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class LegendMenu
{
    public function getProgressionList()
    {
        return Progression::getProgressionList();
    }

    public function getColor($progression)
    {
        return Progression::getProgressionColor($progression);
    }

    public function getCssClass($progression)
    {
        return Progression::getCssClass($progression);
    }
}
