<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_filament_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_access_filament_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@portofolio.test',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertSuccessful();
        $response->assertSee('Portofolio CMS');
    }

    public function test_authenticated_admin_can_view_resources(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/projects')->assertSuccessful();
        $this->actingAs($user)->get('/admin/services')->assertSuccessful();
        $this->actingAs($user)->get('/admin/skills')->assertSuccessful();
        $this->actingAs($user)->get('/admin/education')->assertSuccessful();
        $this->actingAs($user)->get('/admin/contact-messages')->assertSuccessful();
    }
}
