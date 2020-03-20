<?php

namespace Tests\Feature\Auth;

use App\Admin;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
    * @test
    */
    public function user_can_not_access_admin_dashboard()
    {
        $this->actingAs(factory(User::class)->create());

        $this->get('/admin')->assertRedirect('/admin/login');
    }

    /**
    * @test
    */
    public function authenticated_admin_can_access_admin_dashboard()
    {
        $this->actingAs(factory(Admin::class)->create(), 'admin');

        $this->get('/admin')->assertStatus(200);
    }

    /**
    * @test
    */
    public function admin_can_login_with_valid_credentials()
    {
        $admin = factory(Admin::class)->create();

        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'Admin123'
        ])->assertRedirect('/admin');
    }

    /**
    * @test
    */
    public function admin_can_not_login_with_invalid_credentials()
    {
        $response = $this->json('POST', 'admin/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password(8)
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
    * @test
    * @dataProvider clientFormValidationProvider
    */
    public function required_inputs_are_required_to_login($formInput, $formInputValue)
    {
        $this->post('admin/login', [$formInput => $formInputValue])
        ->assertSessionHasErrors($formInput);

        $response = $this->json('POST', 'admin/login', [
            $formInput => $formInputValue,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($formInput);
    }

    public function clientFormValidationProvider()
    {
        return [
            ['password', ''],
            ['email', ''],
            ['email', 'not-an-email'],
        ];
    }
}
