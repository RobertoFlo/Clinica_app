<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web',
        ]);
        Role::firstOrCreate([
            'name' => 'usuario',
            'guard_name' => 'web',
        ]);
        $user = User::factory()->create([
            'name' => 'Super_User',
            'email' => 'test@example.com',
            'password' => Hash::make('admin123')
        ]);
        $user->assignRole('administrador');
        $this->call([
            carga::class,
        ]);
    }
}
