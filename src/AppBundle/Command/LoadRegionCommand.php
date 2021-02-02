<?php

namespace AppBundle\Command;

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
class LoadRegionCommand extends ContainerAwareCommand
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
            ->setName('app:geo:load-region')
            ->setDescription('Importe régions.')
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

        $regionsArray = [];

        foreach ($entries as $entry) {
            $code = $entry[5];
            if (!isset($regionsArray[$code])) {
                $regionsArray[$code] = $entry[6];
            }
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($regionsArray as $code => $name) {
            $region = new Region();
            $region->setCode($code);
            $region->setNom($name);
            $em->persist($region);
        }

        $em->flush();
    }
}
