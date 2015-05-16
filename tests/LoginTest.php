<?php

class LoginTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\Migrations;

    public function test_login()
    {

        $password = 'abcd1234';
        $hashed_password = bcrypt($password);
        $user = $this->factory->make('Hangout\User');
        $user->password = $hashed_password;
        $user->save();

        $this->visit('/auth/login')
            ->type($user->email,'email')
            ->type($password, 'password')
            ->press('Login')
            ->onPage('/');
    }

    public function test_login_when_already_authenticated()
    {
        $this->be($this->factory->make('Hangout\User'));
        $this->visit('/auth/login')
            ->onPage('/');
    }
}
