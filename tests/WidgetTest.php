<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Widget;

class WidgetTest extends TestCase
{

   // use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testWidgetFactory()
    {
        $widgets = factory(Widget::class, 50)->create();
        //dd($widgets);
    }
}
