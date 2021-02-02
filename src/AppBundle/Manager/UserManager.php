<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Description of UserManager
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class UserManager
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(UserRepository $repository, EncoderFactoryInterface $encoderFactory)
    {
        $this->repository = $repository;
        $this->encoderFactory = $encoderFactory;
    }

    public function createAdminUser()
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        return $user;
    }

    public function createUser()
    {
        $user = new User();
        $user->setRoles([]);
        return $user;
    }

    public function saveUser(User $user)
    {
        $this->updatePassword($user);
        $this->repository->save($user);
    }

    public function removeUser(User $user)
    {
        $this->repository->remove($user);
        $this->repository->flush();
    }

    public function updatePassword(User $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
            $encoder = $this->encoderFactory->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($password, $salt);
            $user->setPassword($encodedPassword);
            $user->eraseCredentials();
        }
    }
}
