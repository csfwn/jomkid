<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminDashboardController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_are_protected_by_role(): void
    {
        $parent = User::factory()->create(['role' => User::ROLE_PARENT]);
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $adminRoutes = [
            '/admin',
            '/admin/users',
            '/admin/packages',
            '/admin/students',
            '/admin/affiliates',
        ];

        foreach ($adminRoutes as $route) {
            $this->actingAs($parent)->get($route)->assertForbidden();
            $this->actingAs($admin)->get($route)->assertOk();
        }
    }

    public function test_admin_controller_remains_backward_compatible_with_cached_invokable_route(): void
    {
        $this->assertTrue(is_callable(new AdminDashboardController));
    }

    public function test_only_affiliates_and_admins_can_view_affiliate_dashboard(): void
    {
        $parent = User::factory()->create(['role' => User::ROLE_PARENT]);
        $affiliate = User::factory()->create(['role' => User::ROLE_AFFILIATE]);

        $this->actingAs($parent)->get('/affiliate')->assertForbidden();
        $this->actingAs($affiliate)->get('/affiliate')->assertOk();
    }
}
