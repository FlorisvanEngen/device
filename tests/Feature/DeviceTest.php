<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTest extends TestCase
{
    /**
     * Test to create a device
     *
     * @return void
     */
    public function testAddDevice()
    {
        // Go to create device page - Not authorized
        $response = $this->get('/devices/create?category=1');
        $response->assertStatus(302);

        $user = User::find(1);

        // Go to create device page - Authorized
        $response = $this->actingAs($user)
            ->get('/devices/create?category=1');
        $response->assertStatus(200);

        // Add device
        $response = $this->actingAs($user)
            ->post('/devices', [
                'name' => 'Unit test device',
                'category_id' => 1,
                'order' => 999,
                'description' => 'Draadloze oortjes dat omgevingsgeluid kan onderdrukken!',
                'created_by_id' => $user->id
            ]);
        $response->assertStatus(302);

        $device = Device::orderByDesc('id')->first();

        // TODO: add and remove device photo

        // Delete device
        $response = $this->actingAs($user)
            ->delete('devices/' . $device->id);
        $response->assertStatus(302);
    }
}
