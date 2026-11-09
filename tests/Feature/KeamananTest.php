<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KeamananTest extends TestCase
{
    use RefreshDatabase;

    private function data(array $override = []): array
    {
        return array_merge([
            'nim' => '20230099',
            'nama' => 'Tes Mahasiswa',
            'email' => 'tes@mail.test',
            'jurusan' => 'Manajemen Informatika',
            'angkatan' => 2023,
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Rahasia No. 1',
        ], $override);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/mahasiswa')->assertRedirect('/login');
    }

    public function test_user_biasa_tidak_boleh_akses_mahasiswa(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get('/mahasiswa')->assertForbidden();
    }

    public function test_user_biasa_bisa_membuka_profil_sendiri(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get('/profil')->assertOk();
    }

    public function test_admin_bisa_tambah_data_dan_alamat_terenkripsi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/mahasiswa', $this->data())
            ->assertRedirect('/mahasiswa');

        $m = Mahasiswa::firstOrFail();
        $this->assertNotEquals('Jl. Rahasia No. 1', $m->alamat);   // di DB terenkripsi
        $this->assertEquals('Jl. Rahasia No. 1', $m->alamatDekripsi()); // bisa didekripsi
    }

    public function test_input_disanitasi_dari_tag_html(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/mahasiswa', $this->data(['nama' => '<script>alert(1)</script>Budi']));

        $this->assertSame('alert(1)Budi', Mahasiswa::firstOrFail()->nama);
    }

    public function test_validasi_menolak_data_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/mahasiswa', $this->data(['nim' => 'abc', 'email' => 'bukan-email']))
            ->assertSessionHasErrors(['nim', 'email']);
    }

    public function test_admin_bisa_hapus_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post('/mahasiswa', $this->data());
        $m = Mahasiswa::firstOrFail();

        $this->actingAs($admin)->delete("/mahasiswa/{$m->id}")->assertRedirect('/mahasiswa');
        $this->assertDatabaseMissing('mahasiswa', ['id' => $m->id]);
    }

    public function test_register_membuat_role_user_dan_password_di_hash(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna Baru',
            'email' => 'baru@mail.test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect('/dashboard');

        $u = User::where('email', 'baru@mail.test')->firstOrFail();
        $this->assertSame('user', $u->role);
        $this->assertNotEquals('rahasia123', $u->password);
        $this->assertTrue(Hash::check('rahasia123', $u->password));
    }

    public function test_rate_limiting_login_maksimal_5_percobaan(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'x@mail.test', 'password' => 'salah'])->assertStatus(302);
        }

        $this->post('/login', ['email' => 'x@mail.test', 'password' => 'salah'])->assertStatus(429);
    }
}
