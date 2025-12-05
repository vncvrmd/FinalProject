<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_login_and_access_dashboard()
    {
        // Create an employee user
        // Note: Using 'employee' as role to test case sensitivity or strict match
        $user = User::factory()->create([
            'role' => 'employee', 
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        // Should redirect to dashboard
        $response->assertRedirect(route('dashboard'));
        
        // Follow redirect to assert access
        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertStatus(200); 
    }

    public function test_employee_access_middleware_blocks_non_employees()
    {
         $user = User::factory()->create([
            'role' => 'customer', 
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
            ->get(route('products.index')) 
            ->assertStatus(403);
    }

    public function test_employee_login_with_capitalized_role_check()
    {
        // Issue Reproduction Attempt: Role is 'Employee' but code checks 'employee'
        $user = User::factory()->create([
            'role' => 'Employee', 
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);
        
        // This should pass authentication logic in general
        $this->assertAuthenticatedAs($user);

        // However, if we access a route protected by EmployeeAccessMiddleware
        // It might fail if the middleware is case sensitive
        $response = $this->get(route('products.index'));
        
        // With the fix, this should now be 200 OK
        $response->assertStatus(200);
    }

}
