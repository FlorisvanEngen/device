<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class DeviceOrderTest extends TestCase
{
    // ? refresh database with an SQL script
    protected static $firstTest = true;

    public function setUp() : void {
        parent::setUp();

        if (self::$firstTest) {
            $path = base_path('tests\Setup\deviceproject.sql');
            $sql = file_get_contents($path);
            DB::unprepared($sql);
            Device::factory(33)->create([
                'category_id' => 1
            ]);
            self::$firstTest = false;
        }
    }

    // ? refresh database with an modal
    // use RefreshDatabase;

    /**
     * @test
     * Test to change the order
     *
     * @return void
     */
    public function change_the_devices_order()
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

        assertTrue($newDevices != [], 'There are no device\'s sorted.');
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
