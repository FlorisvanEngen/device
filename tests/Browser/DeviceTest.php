<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeviceTest extends DuskTestCase
{
    /**
     * Test to create, edit and delete a device without a Pdf file
     * @return void
     */
    public function testCreateEditAndDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('All devices')
                ->clickLink('Create')
                ->waitForText('Create a device');

            $name = 'Samsung galaxy flipZ 4';

            // Create device
            $browser->type('#name', $name);
            $browser->select('#category_id');
            $browser->type('#description', 'This phone has a foldable screen. The newest of its generation!');
            $browser->press('button[type=submit].add-device');
            $browser->waitForText('The device has been added!');


            $browser->click('.edit-device')
                ->waitForText('Device: ' . $name);

            $name = 'Samsung galaxy s10e';

            // Delete Pdf
            $browser->click('.delete-file')
                ->waitUntilMissing('.delete-file');

            // Edit device
            $browser->type('#name', $name)
                ->select('#category_id')
                ->type('#description', 'This phone is the best of it\'s generation!')
                ->attach('#pdf', __DIR__ . '\testFiles\diagram.pdf')
                ->press('button[type=submit].add-device')
                ->waitForText('The device \'' . $name . '\' has been updated!');

            $url = str_replace('/edit', '', $browser->driver->getCurrentURL());

            // Delete device
            $browser->visit($url)
                ->assertSee('Device: ' . $name)
                ->press('button[type=button].delete-device');

            // Delete device
            $browser->whenAvailable('#deleteDeviceModal', function ($modal) {
                $modal->assertSee('Delete a device')
                    ->press('#deviceDeleteButton');
            });

            $browser->waitForText('The device \'' . $name . '\' has been deleted!');
        });
    }

    /**
     * Test to create, edit and delete a device with a Pdf file
     * @return void
     */
    public function testCreateEditAndDeleteDeviceWithPdf()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('All devices')
                ->clickLink('Create')
                ->waitForText('Create a device');

            $name = 'Samsung galaxy foldZ 4';

            // Create device
            $browser->type('#name', $name)
                ->select('#category_id')
                ->type('#description', 'This phone has a foldable screen. The newest of its generation!')
                ->attach('#pdf', __DIR__ . '\testFiles\diagram.pdf')
                ->press('button[type=submit].add-device')
                ->waitForText('The device has been added!');

            $browser->click('.edit-device')
                ->waitForText('Device: ' . $name);

            $name = 'Samsung galaxy s10e';

            // Delete Pdf
            $browser->click('.delete-file')
                ->waitUntilMissing('.delete-file');

            // Edit device
            $browser->type('#name', $name)
                ->select('#category_id')
                ->type('#description', 'This phone is the best of it\'s generation!')
                ->attach('#pdf', __DIR__ . '\testFiles\diagram.pdf')
                ->press('button[type=submit].add-device')
                ->waitForText('The device \'' . $name . '\' has been updated!');

            $url = str_replace('/edit', '', $browser->driver->getCurrentURL());

            // Delete device
            $browser->visit($url)
                ->assertSee('Device: ' . $name)
                ->press('button[type=button].delete-device');

            $browser->whenAvailable('#deleteDeviceModal', function ($modal) {
                $modal->assertSee('Delete a device')
                    ->press('#deviceDeleteButton');
            });

            $browser->waitForText('The device \'' . $name . '\' has been deleted!');
        });
    }

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
