<?php


namespace App\Application\Service;

use App\Domain\Model\User;
use App\Domain\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function addUser(User $user): User
    {
        return $this->userRepository->save($user);
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }
}
