<?php

namespace AppBundle\Command;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Region;
use AppBundle\Exception\InvalidCsvException;
use AppBundle\Manager\UserManager;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create an admin user
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class LoadDepartementCommand extends ContainerAwareCommand
{
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:geo:load-departement')
            ->setDescription('Importe les départements.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $pathname = $rootDir . '/Resources/csv/communes.csv';

        $csv = Reader::createFromPath($pathname);
        $csv->setDelimiter(',');
        $header = $csv->fetchOne();

        $expectedHeader = [
            'CODE_COMM',
            'INSEE_COM',
            'Commune(s)',
            'CODE_DEPT',
            'Dept',
            'CODE_REG',
            'Region',
        ];

        if ($header !== $expectedHeader) {
            throw new InvalidCsvException('Csv header different from expected header');
        }

        $csv->setOffset(1);
        $entries = $csv->fetchAll();

        $departementsArray = [];

        foreach ($entries as $entry) {
            $code = $entry[3];
            if (!isset($departementsArray[$code])) {
                $departementsArray[$code] = [$entry[4], $entry[5]];
            }
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $regions = $em->getRepository('AppBundle:Region')->findAllIndexByCode();

        foreach ($departementsArray as $code => $values) {
            $departement = new Departement();
            $departement->setCode($code);
            $departement->setNom($values[0]);

            if (!isset($regions[$values[1]])) {
                throw new Exception('Veuillez importer les régions.');
            }

            $departement->setRegion($regions[$values[1]]);
            $em->persist($departement);
        }

        $em->flush();
    }
}
