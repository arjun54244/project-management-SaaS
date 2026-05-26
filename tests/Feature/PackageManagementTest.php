<?php

namespace Tests\Feature;

use App\Livewire\PackageForm;
use App\Livewire\PackageList;
use App\Models\Package;
use App\Models\User;
use App\Models\Client;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PackageManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_package_list_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Package::create(['name' => 'Gold Plan', 'duration_months' => 12, 'base_price' => 100]);

        $response = $this->get(route('packages.index'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(PackageList::class);
        $response->assertSee('Gold Plan');
    }

    public function test_can_create_package()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(PackageForm::class)
            ->set('name', 'Silver Plan')
            ->set('duration_months', 6)
            ->set('base_price', 50.00)
            ->set('status', 'active')
            ->call('save')
            ->assertRedirect(route('packages.index'));

        $this->assertDatabaseHas('packages', ['name' => 'Silver Plan']);
    }

    public function test_can_update_package()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $package = Package::create(['name' => 'Old Plan', 'duration_months' => 1, 'base_price' => 10]);

        Livewire::test(PackageForm::class, ['package' => $package])
            ->set('name', 'Updated Plan')
            ->set('duration_months', 1)
            ->set('base_price', 10)
            ->set('status', 'active')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('packages.index'));

        $this->assertDatabaseHas('packages', ['id' => $package->id, 'name' => 'Updated Plan']);
    }

    public function test_can_delete_package_without_subscriptions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $package = Package::create(['name' => 'To Delete', 'duration_months' => 1, 'base_price' => 10]);

        Livewire::test(PackageList::class)
            ->call('delete', $package->id);

        $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    }

    public function test_cannot_delete_package_with_active_subscriptions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $package = Package::create(['name' => 'Busy Package', 'duration_months' => 1, 'base_price' => 10]);
        $client = Client::create(['name' => 'Test Client', 'email' => 'test@client.com']);

        Subscription::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'price_before_discount' => 10,
            'final_price' => 10,
            'status' => 'active' // Ensure this matches enum value or string logic
        ]);

        Livewire::test(PackageList::class)
            ->call('delete', $package->id)
            ->assertSee('Cannot delete package with active subscriptions');

        $this->assertDatabaseHas('packages', ['id' => $package->id]);
    }
}
