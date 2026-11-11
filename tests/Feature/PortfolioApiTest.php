<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_fetch_public_portfolio_data(): void
    {
        $response = $this->getJson('/api/portfolio');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'profile',
                    'skills' => ['all', 'technical_grid', 'progress_bars'],
                    'services',
                    'stories',
                    'featured_projects',
                    'projects',
                    'educations',
                    'certifications',
                ],
            ]);
    }

    public function test_visitor_can_submit_contact_message(): void
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I would love to hire you for a project!',
        ];

        $response = $this->postJson('/api/contact', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                ],
            ]);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
            'is_read' => false,
        ]);
    }

    public function test_admin_can_login_and_receive_sanctum_token(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@portofolio.test'],
            ['name' => 'Admin Portofolio', 'password' => bcrypt('password123')]
        );

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@portofolio.test',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'token_type',
                    'user' => ['id', 'name', 'email'],
                ],
            ]);
    }

    public function test_authenticated_admin_can_access_dashboard_stats(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@portofolio.test'],
            ['name' => 'Admin Portofolio', 'password' => bcrypt('password123')]
        );

        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/admin/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'has_profile',
                    'total_projects',
                    'featured_projects',
                    'total_skills',
                    'total_services',
                    'unread_messages',
                ],
            ]);
    }
}

