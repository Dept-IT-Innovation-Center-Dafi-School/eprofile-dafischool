<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\Manager;
use App\Models\SchoolSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SchoolSettingsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_the_settings_page(): void
    {
        $this->get(route('admin.settings'))->assertRedirect(route('admin.login'));
    }

    public function test_renders_the_settings_page_for_an_authenticated_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('Pengaturan Sekolah');
    }

    public function test_updates_school_settings(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('phone', '(0411) 111-222')
            ->set('address', 'Jl. Baru No. 1, Makassar')
            ->set('email', 'kontak@darulfikri.sch.id')
            ->set('whatsappNumber', '6281111111111')
            ->set('mapsEmbedUrl', 'https://www.google.com/maps/embed?pb=test')
            ->set('instagramUrl', 'https://instagram.com/darulfikri')
            ->call('save')
            ->assertHasNoErrors();

        $setting = SchoolSetting::current();
        $this->assertSame('(0411) 111-222', $setting->phone);
        $this->assertSame('Jl. Baru No. 1, Makassar', $setting->address);
        $this->assertSame('kontak@darulfikri.sch.id', $setting->email);
        $this->assertSame('6281111111111', $setting->whatsapp_number);
        $this->assertSame('https://www.google.com/maps/embed?pb=test', $setting->maps_embed_url);
        $this->assertSame('https://instagram.com/darulfikri', $setting->instagram_url);
    }

    public function test_rejects_invalid_email(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('email', 'not-an-email')
            ->call('save')
            ->assertHasErrors(['email']);
    }

    public function test_extracts_the_src_url_from_a_pasted_iframe_embed_code(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('mapsEmbedUrl', '<iframe src="https://www.google.com/maps/embed?pb=test123" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame(
            'https://www.google.com/maps/embed?pb=test123',
            SchoolSetting::current()->maps_embed_url
        );
    }

    public function test_rejects_a_maps_link_that_is_not_an_embed_url(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->set('mapsEmbedUrl', 'https://maps.app.goo.gl/rcjWg8UVXXvm3BWe8')
            ->call('save')
            ->assertHasErrors(['mapsEmbedUrl']);
    }
}
