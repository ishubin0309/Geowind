<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Projet;
use AppBundle\Model\Progression;
use AppBundle\Model\Etat;
use AppBundle\Model\Environnement;
use AppBundle\Model\Mission;
use AppBundle\Model\Niveau;
use AppBundle\Model\Foncier;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\Servitude;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class OptionFormatterExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('type_projet_format', [$this, 'typeProjetFormatter']),
            new \Twig_SimpleFilter('type_site_format', [$this, 'typeSiteFormatter']),
            new \Twig_SimpleFilter('servitude_format', [$this, 'servitudeFormatter']),
            new \Twig_SimpleFilter('phase_format', [$this, 'phaseFormatter']),
            new \Twig_SimpleFilter('progression_format', [$this, 'progressionFormatter']),
            new \Twig_SimpleFilter('foncier_format', [$this, 'foncierFormatter']),
            new \Twig_SimpleFilter('environnement_format', [$this, 'environnementFormatter']),
            new \Twig_SimpleFilter('avis_mairie_format', [$this, 'avisMairieFormatter']),
            new \Twig_SimpleFilter('niveau_format', [$this, 'niveauFormatter']),
            new \Twig_SimpleFilter('mission_format', [$this, 'missionFormatter']),
        ];
    }

    /**
     * @param string $method
     * @return string
     */
    public function typeProjetFormatter($method)
    {
        $types = Projet::getTypeProjetList();
        return isset($types[$method]) ? $types[$method] : $method;
    }

    /**
     * @param string $method
     * @return string
     */
    public function typeSiteFormatter($method)
    {
        $types = Projet::getTypeSiteList();
        return isset($types[$method]) ? $types[$method] : $method;
    }

    /**
     * @param string $method
     * @return string
     */
    public function servitudeFormatter($method)
    {
        return Servitude::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function environnementFormatter($method)
    {
        return Environnement::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function foncierFormatter($method)
    {
        return Foncier::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function niveauFormatter($method)
    {
        return Niveau::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function missionFormatter($method)
    {
        return Mission::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function phaseFormatter($method)
    {
        $phases = Etat::getPhaseList();
        return isset($phases[$method]) ? $phases[$method] : '-';
    }

    /**
     * @param string $method
     * @return string
     */
    public function progressionFormatter($method)
    {
        return Progression::getName($method);
    }

    /**
     * @param string $method
     * @return string
     */
    public function avisMairieFormatter($method)
    {
        return AvisMairie::getName($method);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'option_formatter_extension';
    }
}
