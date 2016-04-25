<?php

use Illuminate\Database\Seeder;
use App\Widget;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Widget::unguard();

        Widget::truncate();

        factory(Widget::class, 50)->create();

        Widget::reguard();
    }
}
