<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Insère les rôles de base dans la table roles.
     *
     * @return void
     */
    public function run(): void
    {
        Role::firstOrCreate(['nom' => 'admin']);
        Role::firstOrCreate(['nom' => 'utilisateur']);
    }
}
