<?php

namespace Tests\Feature;

use App\Livewire\ClientForm;
use App\Livewire\ClientList;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_list_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Client::create(['name' => 'John Doe', 'email' => 'john@example.com']);

        $response = $this->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(ClientList::class);
        $response->assertSee('John Doe');
    }

    public function test_can_create_client()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(ClientForm::class)
            ->set('name', 'Jane Doe')
            ->set('email', 'jane@example.com')
            ->set('status', 'active')
            ->call('save')
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', ['email' => 'jane@example.com']);
    }

    public function test_can_update_client_via_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Old Name', 'email' => 'old@example.com', 'status' => 'active']);

        Livewire::test(ClientForm::class, ['client' => $client])
            ->set('name', 'New Name')
            ->call('save')
            ->assertRedirect(route('clients.index'));

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'New Name']);
    }

    public function test_can_delete_client_via_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'To Delete', 'email' => 'delete@example.com']);

        Livewire::test(ClientList::class)
            ->call('delete', $client->id);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_can_toggle_status_via_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $client = Client::create(['name' => 'Status Test', 'email' => 'status@example.com', 'status' => 'active']);

        Livewire::test(ClientList::class)
            ->call('toggleStatus', $client->id);

        $this->assertEquals('inactive', $client->fresh()->status);
    }
}
