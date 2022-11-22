<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Test if a user can login
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Login');

            $browser->type('#email', 'floris.van.engen@connectionSystems.nl');
            $browser->type('#password', 'password123');
            $browser->press('button[type=submit]');
            $browser->waitForText('Login successful!');
        });
    }

    /**
     * Test if a user can logout
     * @return void
     */
    public function testLogout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/');

            $browser->click('#navbarDropdownMenuLink');
            $browser->assertSee('Logout');
            $browser->press('button[type=submit].dropdown-item');
            $browser->waitForText('Goodbye!');
        });
    }
}
