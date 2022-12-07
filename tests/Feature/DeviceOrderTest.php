<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class deviceOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to change the order
     *
     * @return void
     */
    public function testChangeOrder()
    {
        $user = User::find(1);
        $devices = Device::where('category_id', 1)
            ->orderBy('order')
            ->get(['id', 'order']);

        $newDevices = [];
        $lastDevice = $devices->last();
        $devicesLength = count($devices);
        foreach ($devices as $device) {
            $newDevices[$device->id] = [
                'id' => $device->id,
                'order' => $devicesLength
            ];
            $devicesLength = $devicesLength - 1;
        }

        $response = $this->actingAs($user)
            ->post('devices/order', ['devices' => $newDevices]);

        $newFirstDevice = Device::where('category_id', 1)->orderBy('order')->first();
        assertSame(
            $lastDevice->id,
            $newFirstDevice->id,
            'The last device isn\'t the new first device'
        );
    }
}
