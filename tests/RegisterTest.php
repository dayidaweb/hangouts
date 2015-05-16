<?php

class RegisterTest extends TestCase
{
    use \Illuminate\Foundation\Testing\Migrations;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_register_user()
    {
        $this->visit('/auth/register')
             ->see('Register')
            ->type('Diego', 'name')
            ->type('diego@hernandev.com', 'email')
            ->type('abcd1234', 'password')
            ->type('abcd1234', 'password_confirmation')
            ->press('Register')
            ->seeInDatabase('users', ['email' => 'diego@hernandev.com']);
    }
}
