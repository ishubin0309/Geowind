<?php

namespace AppBundle\Model;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ExportOption
{
    /**
     * @var array
     */
    private $selectedOptions;
    
    public function getSelectedOptions()
    {
        return $this->selectedOptions;
    }

    public function setSelectedOptions($selectedOptions)
    {
        $this->selectedOptions = $selectedOptions;
        return $this;
    }
    
    public function isSelected($key)
    {
        return in_array($key, $this->selectedOptions);
    }
    
    public function getOptionList()
    {
        return [
            'date_creation' => 'Date de création',
            'date_maj' => 'Date de mise à jour',
            'type' => 'Type',
            'origine' => 'Origine',
            'chef_projet' => 'Chef de projet',
            'denomination' => 'Dénomination',
            'region' => 'Région',
            'departement' => 'Département',
            'commune' => 'Commune(s)',
            'carte' => 'Carte',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'environnement' => 'Environnement',
            'potentiel' => 'Potentiel (MW)',
            'raccord' => 'Raccord (km)',
            'materiel' => 'Matériel',
            'servitudes' => 'Servitudes',
            'avis_mairie' => 'Avis Mairie',
            'foncier' => 'Foncier',
            'progression' => 'Progression',
//            'date_t0' => 'Date T0',
//            'date_t1' => 'Date T1',
            'engage' => 'Engagé (€HT)',
            'paye' => 'Payé (€HT)',
            'commentaires' => 'Commentaires',
        ];
    }
}
