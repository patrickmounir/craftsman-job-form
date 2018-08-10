<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Service::create(['id' => 804040, 'name' => 'Sonstige Umzugsleistungen']);
        \App\Service::create(['id' => 802030, 'name' => 'Abtransport, Entsorgung und Entrümpelung']);
        \App\Service::create(['id' => 411070, 'name' => 'Fensterreinigung']);
        \App\Service::create(['id' => 402020, 'name' => 'Holzdielen schleifen']);
        \App\Service::create(['id' => 108140, 'name' => 'Kellersanierung']);
    }
}
