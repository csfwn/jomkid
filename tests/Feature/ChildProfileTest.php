<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_create_up_to_three_child_profiles(): void
    {
        $parent = User::factory()->create();

        foreach (range(1, 3) as $number) {
            $this->actingAs($parent)->post('/children', [
                'display_name' => "Anak {$number}",
                'birth_year' => 2020,
                'avatar_key' => 'owl-indigo',
                'leaderboard_opt_in' => false,
            ])->assertRedirect();
        }

        $this->assertSame(3, $parent->childProfiles()->count());

        $this->actingAs($parent)->post('/children', [
            'display_name' => 'Anak 4',
            'birth_year' => 2020,
            'avatar_key' => 'owl-coral',
            'leaderboard_opt_in' => false,
        ])->assertStatus(422);
    }

    public function test_parent_cannot_delete_another_parents_child_profile(): void
    {
        $owner = User::factory()->create();
        $otherParent = User::factory()->create();
        $child = ChildProfile::create([
            'user_id' => $owner->id,
            'display_name' => 'Bintang',
            'avatar_key' => 'owl-yellow',
        ]);

        $this->actingAs($otherParent)->delete("/children/{$child->id}")->assertForbidden();
        $this->assertNotNull($child->fresh());
    }
}
