<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository {

    private $messageService;

    public function create($data): User {
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        return User::create($data);
    }

    public function getUserById($id): ?User
    {
        $user = User::find($id);

        if(!$user || $user["deleted_at"]) {
            return null;
        }

        return $user;
    }

    public function getUserByEmail($email): ?User
    {
        $user = User::where('email', $email)->first();

        if(!$user || $user["deleted_at"]) {
            return null;
        }

        return $user;
    }

    public function deleteUser($user) {
        DB::transaction(function () use ($user) {
            try {
                $user->delete();
                $this->messageService->deleteUserMessages($user['id']);

                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }

        });
    }
}
