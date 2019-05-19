<?php

namespace App\Domain;

use App\Domain\Model\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;

    public function countAll(): int;

    public function getAll(): array;
}
