<?php

namespace AppBundle\Service;

use AppBundle\Entity\Projet;
use AppBundle\Model\ExportOption;
use League\Csv\Writer;
use SplTempFileObject;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProjetExport
{
    /**
     * @param ExportOption $exportOption
     * @return string
     */
    public function getCSVString(ExportOption $exportOption, Projet $projet)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(";");
        $options = $exportOption->getOptionList();
        
        $header = [];
        $data = [];

        foreach ($options as $key => $option) {
            if ($exportOption->isSelected($key)) {
                $header[] = $option;
                $data[] = $projet->getOptionValue($key);
            }
        }
        
        $csv->insertOne($header);
        $csv->insertOne($data);
        
        return (string) $csv;
    }
    
    /**
     * @param ExportOption $exportOption
     * @return string
     */
    public function getBulkCSVString(ExportOption $exportOption, array $projets)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(";");
        $options = $exportOption->getOptionList();
        
        $header = [];

        foreach ($options as $key => $option) {
            if ($exportOption->isSelected($key)) {
                $header[] = $option;
            }
        }
        
        $csv->insertOne($header);
        
        foreach ($projets as $projet) {
            $data = [];
            
            foreach ($options as $key => $option) {
                if ($exportOption->isSelected($key)) {
                    $data[] = $projet->getOptionValue($key);
                }
            }
            
            $csv->insertOne($data);
        }
        
        return (string) $csv;
    }
}
