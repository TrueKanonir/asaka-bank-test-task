<?php

namespace Database\Seeders;

use Exception;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UsersTableSeeder extends Seeder
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
                fn(array $user) => User::query()
                    ->updateOrCreate(
                        ['email' => $user['email']],
                        Arr::except($user, 'email')
                    )
            );
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    private function getData(): Collection
    {
        return collect([
            [
                'name' => 'Default Manager',
                'email' => 'manager@gmail.com',
                'password' => '123456',
                'role_id' => Role::manager()->id,
            ]
        ]);
    }
}
