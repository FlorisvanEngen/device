<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeviceTest extends DuskTestCase
{
    /**
     * Test to create a device
     * @return void
     */
    public function testCreateAndDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/devices/create?category=1')
                ->assertSee('Create a device');

            $name = 'Samsung galaxy flipZ 4';

            //CreateDevice
            $browser->type('#name', $name);
            $browser->select('#category_id');
            $browser->type('#description', 'This phone has a foldable screen. The newest of its generation!');
            $browser->press('button[type=submit].add-device');
            $browser->waitForText('The device has been added!');

            //Delete device
            $browser->press('button[type=button].delete-device');
            $browser->whenAvailable('#deleteDeviceModal', function ($modal) {
                $modal->assertSee('Delete a device')
                      ->press('#deviceDeleteButton');
            });

            $browser->waitForText('The device \'' . $name . '\' has been deleted!');
        });
    }

    /**
     * Test to create a device with a PDF file
     * @return void
     */
    public function testCreateAndDeleteDeviceWithPdf()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/devices/create?category=1')
                ->assertSee('Create a device');

            $name = 'Samsung galaxy foldZ 4';

            //Create device
            $browser->type('#name', $name);
            $browser->select('#category_id');
            $browser->type('#description', 'This phone has a foldable screen. The newest of its generation!');
            $browser->attach('#pdf', __DIR__ . '\testFiles\diagram.pdf');
            $browser->press('button[type=submit].add-device');
            $browser->waitForText('The device has been added!');

            //Delete device
            $browser->press('button[type=button].delete-device');
            $browser->whenAvailable('#deleteDeviceModal', function ($modal) {
                $modal->assertSee('Delete a device')
                      ->press('#deviceDeleteButton');
            });

            $browser->waitForText('The device \'' . $name . '\' has been deleted!');
        });
    }

    // /**
    //  * Test to edit a device
    //  * @return void
    //  */
    // public function testEditDevice()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //             ->assertSee('All devices');
    //     });
    // }

    // /**
    //  * Test to edit a device with a PDF file
    //  * @return void
    //  */
    // public function testEditDeviceWithPdfFile()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //             ->assertSee('All devices');
    //     });
    // }

    // public function testAddDeviceFoto()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/')
    //             ->assertSee('All devices');
    //     });
    // }
}
