<?php

namespace AppBundle\Command;

use AppBundle\Entity\Mairie;
use AppBundle\Entity\Region;
use AppBundle\Exception\InvalidCsvException;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class LoadMairieCommand extends ContainerAwareCommand
{
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
            ->setName('app:load-mairie')
            ->setDescription('Importe mairie.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //                $rootDir = $this->get('kernel')->getRootDir();
//        $pathname = $rootDir . '/Resources/csv/mairie.xls';
//        $inputFileName = $pathname;
//
//        try {
//            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
//            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
//            $excel = $objReader->load($inputFileName);
//        } catch(Exception $e) {
//            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
//        }
//
//
//        $worksheet = $excel->getSheet(0);
//        $data = $worksheet->toArray(0, true, true, false);
//
//        foreach ($data as $line) {
//            var_dump($line);
//
//        }
//

        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $pathname = $rootDir . '/Resources/csv/mairies.csv';

        $csv = Reader::createFromPath($pathname);
        $csv->setDelimiter(';');

        $header = $csv->fetchOne();

        $expectedHeader = [
            'CLASSEMENT',
            'MAIRIE',
            'ADRES1 MAIRIE',
            'ADRES2 MAIRIE',
            'CODE POSTAL',
            'COMMUNE',
            'CIVILITE MAIRE',
            'PRENOM MAIRE',
            'NOM MAIRE',
            'TEL',
            'FAX',
            'POPULATION 2016',
            'EMAIL 1',
            'EMAIL 2',
            'EMAIL 3',
            'EMAIL 4',
            'EMAIL 5',
            'Site internet',
            'CODES INSEE',
            'CANTONS 2015 (Nouvelles délimitations)',
            'CANTONS 2014 (Anciennes délimitations)',
            'CODES SIREN',
            'RÉGIONS',
            '',
            '',
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
        $insees = [];
        
        foreach ($entries as $entry) {
            
            if (empty($entry[18])) {
                continue;
            }
            
            $insees[] = $entry[18];
        }
        
        if (empty($insees)) {
            return;
        }
        
        $em = $this->entityManager;
        $mairies = $em->getRepository('AppBundle:Mairie')
                        ->findByInseeIdxByInsee($insees);

        foreach ($entries as $entry) {
            
            $insee = $entry[18];
            
            if (empty($insee)) {
                continue;
            }
            
            if (isset($mairies[$insee])) {
                $mairie = $mairies[$insee];
            } else {
                $mairie = new Mairie();
                $em->persist($mairie);
                $mairies[$insee] = $mairie;
            }
            
            $mairie
                ->setClassement($entry[0])
                ->setMairie($entry[1])
                ->setAddress1($entry[2])
                ->setAddress2($entry[3])
                ->setCodePostal($entry[4])
                ->setCommune($entry[5])
                ->setCiviliteMaire($entry[6])
                ->setPrenomMaire($entry[7])
                ->setNomMaire($entry[8])
                ->setTelephone($entry[9])
                ->setFax($entry[10])
                ->setPopulation2016($entry[11])
                ->setEmail1($entry[12])
                ->setEmail2($entry[13])
                ->setEmail3($entry[14])
                ->setEmail4($entry[15])
                ->setEmail5($entry[16])
                ->setSiteInternet($entry[17])
                ->setInsee($entry[18])
                ->setCanton2015($entry[19])
                ->setCanton2015($entry[20])
                ->setSiren($entry[21])
                ->setRegion($entry[22])
            ;
        }
        
        
        
        $em->flush();
        $em->clear();
    }
}
