<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class AuthService {

    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }


    public function register($data): User {
        return $this->userRepository->create($data);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function deleteUser($userId) {
        $user = $this->userRepository->getUserById($userId);

        if(!$user) {
            return false;
        }

        return $this->userRepository->deleteUser($user);
    }
}
