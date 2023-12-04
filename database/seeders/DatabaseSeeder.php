<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    private $permissions = [
        'role-gestion',
        'permission-gestion',
        'utilisateur-gestion',
        'operation-creer',
        'operation-lire',
        'operation-modifier',
        'operation-supprimer',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::create([
            "name_fr"=> "Cameroun",
            "name_en"=> "Cameroon"
        ]);
        Country::create([
            "name_fr"=> "Nigeria",
            "name_en"=> "Nigeria"
        ]);
        Country::create([
            "name_fr"=> "Côte d'Ivoire",
            "name_en"=> "Ivory Coast"
        ]);
        Country::create([
            "name_fr"=> "Tchad",
            "name_en"=> "Chad"
        ]);

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = \App\Models\User::factory()->create([
            'name' => 'Bloo Admin',
            'email' => 'noahowonofx@gmail.com',
            'activated' => true
        ]);
        $super = Role::create(['name' => 'SuperAdmin']);
        $admin = Role::create(['name' => 'Admin']);
        $operateur = Role::create(['name' => 'Operateur']);
        $client = Role::create(['name' => 'Client']);
        $lecteur = Role::create(['name' => 'Lecteur']);
        $permissions = Permission::pluck('id', 'id')->all();
        $super->syncPermissions($permissions);
        $admin->syncPermissions($permissions);
        $operateur->syncPermissions($permissions);
        $client->syncPermissions([
            'operation-creer',
            'operation-lire',
            'operation-modifier',
            'operation-supprimer'
        ]);
        $user->assignRole([$super->id]);
    }
}
