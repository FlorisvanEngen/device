<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to create a device
     *
     * @return void
     */
    public function testAddADevice()
    {
        // Go to create device page - Not authorized
        $response = $this->get('/devices/create?category=1');
        $response->assertStatus(302);

        // Go to create device page - Authorized
        $user = User::find(1);
        $response = $this->actingAs($user)
            ->get('/devices/create?category=1');
        $response->assertStatus(200);

        $response = $this->actingAs($user)
            ->post('devices', [
                'name' => 'Unit test device',
                'category_id' => 1,
                'order' => 999,
                'description' => 'Device voor een unit test'
            ]);
        $response->assertStatus(302);

        $dbDevice = Device::orderByDesc('id')->first();
        assertNotNull($dbDevice, 'The device haven\'t been created');
        assertSame('Unit test device', $dbDevice->name, 'The device haven\'t been created');
    }

    /**
     * Test to add a device
     *
     * @return void
     */
    public function testEditDeviceWithAPdfFile()
    {
        $user = User::find(1);
        $device = Device::orderByDesc('id')->first();
        $pdf = UploadedFile::fake()->create('unitTest.pdf', 28, 'application/pdf');

        $response = $this->actingAs($user)
            ->put('devices/' . $device->id, [
                'id' => $device->id,
                'name' => 'Unit test device 1',
                'pdf' => $pdf,
                'description' => 'Device voor een unit test dat is aangepast',
                'order' => 1000,
                'category_id' => 2
            ]);

        Storage::disk('pdf')->assertExists($pdf->hashName());
        $dbPdf = Media::where('type', 'pdf')->orderByDesc('id')->first();
        assertSame($pdf->name, $dbPdf->name, 'The PDF name has been changed');
        $dbDevice = Device::find($device->id);
        assertSame('Unit test device 1', $dbDevice->name, 'The device name haven\'t been changed');
    }

    /**
     * Test to add diffrent types of photo's
     *
     * @return void
     */
    public function testDevicePhotos()
    {
        $user = User::find(1);
        $device = Device::orderByDesc('id')->first();

        // Jpg
        $jpg = UploadedFile::fake()->image('unitTest.jpg');
        $response = $this->actingAs($user)
            ->post('media/' . $device->id, [
                'path' => $jpg
            ]);

        Storage::disk('img')->assertExists($jpg->hashName());
        $dbJpg = Media::where('type', 'img')->orderByDesc('id')->first();
        assertSame($jpg->name, $dbJpg->name, 'The JPG name has been changed');

        // Jpeg
        $jpeg = UploadedFile::fake()->image('unitTest.jpeg');
        $response = $this->actingAs($user)
            ->post('media/' . $device->id, [
                'path' => $jpeg
            ]);

        Storage::disk('img')->assertExists($jpeg->hashName());
        $dbJpeg = Media::where('type', 'img')->orderByDesc('id')->first();
        assertSame($jpeg->name, $dbJpeg->name, 'The JPEG name has been changed');

        // Gif
        $gif = UploadedFile::fake()->image('unitTest.gif');
        $response = $this->actingAs($user)
            ->post('media/' . $device->id, [
                'path' => $gif
            ]);

        Storage::disk('img')->assertExists($gif->hashName());
        $dbGif = Media::where('type', 'img')->orderByDesc('id')->first();
        assertSame($gif->name, $dbGif->name, 'The GIF name has been changed');

        // Png
        $png = UploadedFile::fake()->image('unitTest.png');
        $response = $this->actingAs($user)
            ->post('media/' . $device->id, [
                'path' => $png
            ]);

        Storage::disk('img')->assertExists($png->hashName());
        $dbPng = Media::where('type', 'img')->orderByDesc('id')->first();
        assertSame($png->name, $dbPng->name, 'The PNG name has been changed');

        // Pdf
        $pdf = UploadedFile::fake()->create('unitTest.pdf', 28, 'application/pdf');
        $response = $this->actingAs($user)
            ->post('media/' . $device->id, [
                'path' => $pdf
            ]);

        assertNotNull($response->baseResponse->exception,
            'Adding a PDF file as an img was successful, an exception was expected');
        Storage::disk('img')->assertMissing($pdf->hashName());

        // Delete a photo
        $media = Media::where('type', 'img')->orderByDesc('id')->first();

        $response = $this->actingAs($user)
            ->delete('media/' . $media->id, [
                'media' => $media->id
            ]);

        $dbMedia = Media::find($media->id);
        assertNull($dbMedia, 'The photo haven\'t been deleted');
        Storage::disk('img')->assertMissing($media->path);
    }

    /**
     * Test to delete a device
     *
     * @return void
     */
    public function testDeleteDevice()
    {
        $user = User::find(1);
        $device = Device::orderByDesc('id')->first();
        $response = $this->actingAs($user)
            ->delete('devices/' . $device->id);
        $response->assertStatus(302);

        $dbDevice = Device::orderByDesc('id')->first();
        if ($dbDevice) {
            assertNotSame($device->id, $dbDevice->id, 'The device haven\'t been deleted');
        } else {
            assertNull($dbDevice, 'The device haven\'t been deleted');
        }
    }
}
