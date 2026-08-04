<?php

namespace Tests\Feature;

use App\Livewire\Admin\Account\Manager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AccountPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_the_account_page_for_an_authenticated_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.account'))
            ->assertOk()
            ->assertSee('Ganti Password')
            ->assertSee($user->email);
    }

    public function test_updates_name_and_email(): void
    {
        $user = User::factory()->create(['email' => 'old@example.com']);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('name', 'Nama Baru')
            ->set('email', 'new@example.com')
            ->call('updateProfile')
            ->assertHasNoErrors();

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertSame('new@example.com', $user->email);
    }

    public function test_rejects_email_already_used_by_another_user(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $user = User::factory()->create(['email' => 'me@example.com']);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('email', 'taken@example.com')
            ->call('updateProfile')
            ->assertHasErrors(['email']);

        $this->assertSame('me@example.com', $user->fresh()->email);
    }

    public function test_updates_password_with_correct_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('currentPassword', 'old-password')
            ->set('newPassword', 'new-password-123')
            ->set('newPasswordConfirmation', 'new-password-123')
            ->call('updatePassword')
            ->assertHasNoErrors();

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_rejects_password_update_with_wrong_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('currentPassword', 'wrong-password')
            ->set('newPassword', 'new-password-123')
            ->set('newPasswordConfirmation', 'new-password-123')
            ->call('updatePassword')
            ->assertHasErrors(['currentPassword']);

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }

    public function test_rejects_password_update_when_confirmation_does_not_match(): void
    {
        $user = User::factory()->create(['password' => Hash::make('old-password')]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('currentPassword', 'old-password')
            ->set('newPassword', 'new-password-123')
            ->set('newPasswordConfirmation', 'does-not-match')
            ->call('updatePassword')
            ->assertHasErrors(['newPasswordConfirmation']);

        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
    }
}
