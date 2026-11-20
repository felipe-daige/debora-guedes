<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => config('site.admin.email')], [
            'name' => config('site.admin.name'),
            'password' => config('site.admin.password'),
        ]);

        $this->call(PropertySeeder::class);
    }
}
