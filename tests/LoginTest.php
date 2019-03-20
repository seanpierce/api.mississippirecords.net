<?php

use App\Models\PasswordHash as PasswordHash;

class LoginTest extends TestCase
{
    /**
     * @group login
     * /items [POST]
     */
    public function test_log_in_a_user_with_valid_credentials()
    {
        // create a user/ token combo
        $user = factory('App\Models\User')->create();

        PasswordHash::create([
            'user_id' => $user->id,
            'password_hash' => password_hash('test123', PASSWORD_BCRYPT)
        ]);

        $parameters = [
            'email' => $user->email,
            'password' => 'test123'
        ];

        $this->post('login', $parameters);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' =>
                [
                    'name',
                    'email',
                    'token',
                ]
            ]);
    }
}