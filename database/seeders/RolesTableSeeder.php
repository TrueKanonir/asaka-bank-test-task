<?php

namespace Database\Seeders;

use Exception;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $this
            ->getData()
            ->each(
                fn (array $role) => Role::query()
                    ->updateOrCreate(
                        ['slug' => $role['slug']],
                        ['name' => $role['name']]
                    )
            );

        // Warm up cache
        Role::getCached();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getData(): Collection
    {
        return collect([
            [
                'name' => 'Manager',
                'slug' => Role::DEFAULT['manager'],
            ],
            [
                'name' => 'Client',
                'slug' => Role::DEFAULT['client'],
            ]
        ]);
    }
}
