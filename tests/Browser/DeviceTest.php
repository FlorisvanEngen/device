<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeviceTest extends DuskTestCase
{
    /**
     * Test to create, edit and delete a device without a Pdf file.
     *
     * @return void
     */
    public function testCreateEditAndDeleteDevice()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('All devices')
                ->scrollIntoView('.add-device')
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

            // Edit device
            $browser->type('#name', $name)
                ->select('#category_id')
                ->type('#description', 'This phone is the best of it\'s generation!')
                ->press('button[type=submit].add-device')
                ->waitForText('The device \'' . $name . '\' has been updated!');

            // Delete device
            $this->deleteDevice($browser, $name);
        });
    }

    /**
     * Test to create, edit and delete a device with a Pdf file.
     *
     * @return void
     */
    public function testCreateEditAndDeleteDeviceWithPdf()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('All devices')
                ->scrollIntoView('.add-device')
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
            $browser->click('.delete-pdf')
                ->waitUntilMissing('.delete-pdf');

            // Edit device
            $browser->type('#name', $name)
                ->select('#category_id')
                ->type('#description', 'This phone is the best of it\'s generation!')
                ->attach('#pdf', __DIR__ . '\testFiles\diagram.pdf')
                ->press('button[type=submit].add-device')
                ->waitForText('The device \'' . $name . '\' has been updated!');

            // Delete device
            $this->deleteDevice($browser, $name);
        });
    }

    /**
     * Test to add and delete a photo for a device
     *
     * @return void
     */
    public function testAddDeviceFoto()
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

            // Add photo
            $browser->attach('#path', __DIR__ . '\testFiles\illustration.png')
                ->press('button[type=submit].add-photo')
                ->waitForText('The photo has been added!');

            // Delete photo
            $browser->scrollIntoView('button[type=button].delete-photo')
                ->pause(100)
                ->press('button[type=button].delete-photo')
                ->waitUntilMissingText('illustration.png');

            // Delete device
            $this->deleteDevice($browser, $name);
        });
    }

    /**
     * TODO: Test to see if the appropriate error message is shown if an name is filled in when that name is alreadt in use.
     *
     * @return void
     */
    public function testCreateAndEditDeviceWithSameName() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('All devices')
                ->clickLink('Create')
                ->waitForText('Create a device');
        });
    }

    /**
     * Delete a device based on the current url. The browser needs to be on the edit page of a device.
     *
     * @param Browser $browser
     * @param string $name
     * @return void
     */
    private function deleteDevice(Browser $browser, string $name)
    {
        $url = str_replace('/edit', '', $browser->driver->getCurrentURL());

        $browser->visit($url)
            ->assertSee('Device: ' . $name)
            ->press('button[type=button].delete-device');

        $browser->whenAvailable('#deleteDeviceModal', function ($modal) {
            $modal->assertSee('Delete a device')
                ->press('#deviceDeleteButton');
        });

        $browser->waitForText('The device \'' . $name . '\' has been deleted!');
    }
}
