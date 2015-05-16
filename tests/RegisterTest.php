<?php

class RegisterTest extends TestCase
{
    use \Illuminate\Foundation\Testing\Migrations;
    //use \Illuminate\Foundation\Testing\WithoutMiddleware;
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
            ->seeInDatabase('users', ['email' => 'diego@hernandev.com'])
            ->onPage('/');
    }

    public function test_register_user_with_invalid_data()
    {

        $this->visit('/auth/register')
            ->see('Register')
            ->type('Diego', 'name')
            ->press('Register')
            ->notSeeInDatabase('users', ['email' => 'diego@hernandev.com'])
            ->onPage('/auth/register')
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_register_user_ok()
    {
        $this->withoutMiddleware();
        $response = $this->call('POST', '/auth/register', [
            'name'  =>  'Diego',
            'email' =>  'diego@hernandev.com',
            'password'=>   'abcd1234',
            'password_confirmation' =>  'abcd1234',
        ]);
        $this->assertResponseStatus(302);
    }

    public function test_register_with_factory()
    {
        $user_data = $this->factory->raw('Hangout\User');
        $user_data['password_confirmation'] = $user_data['password'];
        unset($user_data['remember_token']);
        $this->visit('/auth/register')
            ->submitForm($user_data)
            ->seeInDatabase('users', ['email' => $user_data['email']]);
    }
}
