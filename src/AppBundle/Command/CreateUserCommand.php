<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create an admin user
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class CreateUserCommand extends Command
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
            ->setName('app:user:create-admin')
            ->setDescription('Creates a new admin user.')
            ->setHelp('app:user-create-admin [username] [password]')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $user = $this->userManager->createAdminUser();
        $user->setPlainPassword($password);
        $user->setUsername($username);
        $user->setPrenom('Admin');
        $user->setNom('Admin');
        $this->userManager->saveUser($user);
        $output->write('Admin User successfully created.');
    }
}
