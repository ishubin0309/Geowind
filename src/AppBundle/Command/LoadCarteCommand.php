<?php

namespace AppBundle\Command;

use AppBundle\Entity\Projet;
use AppBundle\Exception\InvalidCsvException;
use AppBundle\Manager\UserManager;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\Environnement;
use AppBundle\Model\Foncier;
use AppBundle\Model\Progression;
use AppBundle\Model\Servitude;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create an admin user
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class LoadCarteCommand extends ContainerAwareCommand
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
            ->setName('app:carte:import')
            ->setDescription('Importe des cartes.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $pathname = $rootDir . '/Resources/csv/cartes.csv';

        $csv = Reader::createFromPath($pathname);
        $csv->setDelimiter(',');
        $header = $csv->fetchOne();

        $expectedHeader = [
            'Carte',
            'Longitude (I)',
            'Latitude (I)',
        ];

        if ($header !== $expectedHeader) {
            throw new InvalidCsvException('Csv header different from expected header');
        }

        $csv->setOffset(1);
        $entries = $csv->fetchAll();

        $em = $this->getContainer()->get('doctrine')->getManager();

        $admin = $em->getRepository('AppBundle:User')->findOneByUsername('admin');

        $regions = $em->getRepository('AppBundle:Region')->findAllIndexByCode();
        $departements = $em->getRepository('AppBundle:Departement')->findAllIndexByCode();
        $inseeCodes = [];

        foreach ($entries as $entry) {
            $inseeCodes[] = $this->getInseeCode($entry[0]);
        }

        $communes = $em->getRepository('AppBundle:Commune')->findByInseeIdxByInsee($inseeCodes);
        $today = new \DateTime('today');

        foreach ($entries as $entry) {

            $carte = $entry[0];
            $longitude = $entry[1];
            $latitude = $entry[2];
            $insee = $this->getInseeCode($carte);

            $projet = new Projet();

            $projet->setLongitude($longitude);
            $projet->setLatitude($latitude);

            $projet->setCarte($carte . '.tif');
            $projet->setCarteOriginalName($carte . '.tif');
            $projet->setDenomination($carte);

            $commune = $communes[$insee];
            $departement = $commune->getDepartement();

            $projet->getCommunes()->add($commune);
            $projet->setDepartement($departement);

            $projet->setDateCreation($today);
            $projet->setDateMaj($today);
            $projet->setChefProjet($admin);
            $projet->setOrigine($admin);

            $projet->setType(Projet::TYPE_EOL);
            $projet->setEnvironnement(Environnement::BOCCAGER);
            $projet->setServitude(Servitude::AVIS_REQUIS);
            $projet->setProgression(Progression::EN_VERIF);
            $projet->setAvisMairie(AvisMairie::CONTACTER);
            $projet->setFoncier(Foncier::A_RECENSER);

            $em->persist($projet);
        }

        $em->flush();
    }

    /**
     * @param string $carte
     * @return string
     */
    private function getInseeCode($carte)
    {
        preg_match('/([a-zA-Z0-9]+)_TOPO_(\d+)/', $carte, $matches);

        if (isset($matches[1])) {
            $inseeCode = (string) $matches[1];
        } else {
            $inseeCode = '00000';
        }

        if (strlen($inseeCode) === 4) {
            $inseeCode = '0' . $inseeCode;
        }

        return $inseeCode;
    }
}
