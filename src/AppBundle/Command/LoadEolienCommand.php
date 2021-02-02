<?php

namespace AppBundle\Command;

use AppBundle\Entity\ParcEolien;
use AppBundle\Exception\InvalidCsvException;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class LoadEolienCommand extends ContainerAwareCommand
{
    const COL_ID = 0;
    const COL_COMMUNE = 4;
    const COL_DEPARTEMENT = 5;
    const COL_REGION = 6;
    const COL_LONGITUDE = 7;
    const COL_LATITUDE = 8;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:load-eolien')
            ->setDescription('Importe parc eoliens.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $pathname = $rootDir . '/Resources/csv/eoliennes.csv';

        $csv = Reader::createFromPath($pathname);
        $csv->setDelimiter(';');

        $header = $csv->fetchOne();

        
        $expectedHeader = [
            'ID',
            'Puissancenominalunitaire',
            'Emailcontact',
            'Puissancenominaletotale',
            'NOM_COMM',
            'NOM_DEPT',
            'NOM_REGION',
            'LongitudeI',
            'LatitudeI',
            'Dnomination',
            'Description',
            'Miseenservice',
            'Typedemachine',
            'Dveloppeur',
            'Oprateur',
            'Commune',
            'Dpartement',
            'Nomcontact',
            'Tlephone',
        ];

        if ($header !== $expectedHeader) {
            throw new InvalidCsvException('Csv header different from expected header');
        }

        $offset = 1;
        $limit = 200;
        
        $entries = $csv->setOffset($offset)->setLimit($limit)->fetchAll();
        
        while (!empty($entries)) {
            $this->handleEntries($entries);
            $output->writeln($offset . '->' . ($offset+$limit) . ' OK');
            $offset += $limit;
            $entries = $csv->setOffset($offset)->setLimit($limit)->fetchAll();
        }
        
        $output->write('Terminé.');
    }
    
    private function handleEntries(array $entries)
    {
        $ids = [];
        
        foreach ($entries as $entry) {
            
            if (empty($entry[self::COL_ID])) {
                continue;
            }
            
            $ids[] = $entry[self::COL_ID];
        }
        
        if (empty($ids)) {
            return;
        }
        
        $em = $this->entityManager;
        $parcEoliens = $em->getRepository('AppBundle:ParcEolien')
                        ->findByIdsIndexById($ids);

        foreach ($entries as $entry) {
            
            $id = $entry[self::COL_ID];
            
            if (empty($id)) {
                continue;
            }
            
            if (isset($parcEoliens[$id])) {
                $parcEolien = $parcEoliens[$id];
            } else {
                $parcEolien = new ParcEolien();
                
                $parcEolien->setId($id);
                $em->persist($parcEolien);
                $parcEoliens[$id] = $parcEolien;
            }
            
            $longitude = floatval(str_replace(',', '.', $entry[self::COL_LONGITUDE]));
            $latitude = floatval(str_replace(',', '.', $entry[self::COL_LATITUDE]));
            
            $parcEolien
                ->setCommune($entry[self::COL_COMMUNE])
                ->setRegion($entry[self::COL_REGION])
                ->setDepartement($entry[self::COL_DEPARTEMENT])
                ->setLongitude($longitude)
                ->setLatitude($latitude)
            ;
            
        }
        
        $em->flush();
        $em->clear();
    }
}
