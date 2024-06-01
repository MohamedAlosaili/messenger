<?php

namespace App\Services;

use App\Models\User;

class AuthTokenService {


    public function generateToken(User $user) {
        return $user->createToken("messenger_session_token");
    }
}
