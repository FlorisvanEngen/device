<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Session;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AlertTest extends DuskTestCase
{
    /**
     * Test to see if the success alert shows
     * @return void
     */
    public function testSuccesAlert()
    {
        $this->browse(function (Browser $browser) {
            Session::flash('success', 'Show the succes toast!');
            $browser->visit('/');
            $browser->waitForText('Show the succes toast!');
        });
    }

    /**
     * Test to see if the error alert shows
     * @return void
     */
    public function testErrorAlert()
    {
        $this->browse(function (Browser $browser) {
            Session::flash('error', 'Show the error toast!');
            $browser->visit('/');
            $browser->waitForText('Show the error toast!');
        });
    }
}
