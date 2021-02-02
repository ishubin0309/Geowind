<?php

namespace AppBundle\Command;

use AppBundle\Entity\Departement;
use AppBundle\Entity\Commune;
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
class LoadCommuneCommand extends ContainerAwareCommand
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
            ->setName('app:geo:load-commune')
            ->setDescription('Importe les communes.')
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

        $communesArray = [];

        foreach ($entries as $entry) {
            $code = $entry[1];
            if (!isset($communesArray[$code])) {
                $communesArray[$code] = [$entry[0], $entry[2], $entry[3]];
            }
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        $departements = $em->getRepository('AppBundle:Departement')->findAllIndexByCode();

        $i = 0;
        $batchSize = 500;

        foreach ($communesArray as $insee => $values) {
            $commune = new Commune();
            $commune->setCode($code);
            $commune->setNom($values[1]);
            $commune->setCode($values[0]);
            $commune->setInsee($insee);

            if (!isset($departements[$values[2]])) {
                throw new Exception('Veuillez importer les départements.');
            }

            $commune->setDepartement($departements[$values[2]]);

            $em->persist($commune);

            if (($i % $batchSize) === 0) {
                $em->flush();
                $em->clear('AppBundle\Entity\Commune'); // Detaches all objects from Doctrine!
            }

            ++$i;
        }

        $em->flush();
    }
}
