@props(['devices', 'currentCategory'])

<x-device.device-table :devices="$devices">
    <colgroup>
        <col style="width: 10%;">
        <col style="width: 20%;">
        <col style="width: 15%;">
        <col style="width: 15%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
    </colgroup>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Category</th>
        <th>Order</th>
        <th>Created at</th>
        <th>Photos</th>
        <th></th>
    </tr>
    @if($devices->isNotEmpty())
        @foreach($devices as $device)
            <tr data-deviceid="{{ $device->id }}">
                <td>{{ $device->id }}</td>
                <td>{!! $device->name !!}</td>
                <td>{!! $device->category->name !!}</td>
                <td>{{ $device->order }}</td>
                <td>{{ $device->created_at }}</td>
                <td>{{ $device->photos->count() }}</td>
                <td>
                    <a class="btn btn-link btn-sm" href="/devices/{{ $device->id }}/edit">Edit</a>
                    <button type="button" class="btn btn-link link-danger btn-sm delete-device"
                            data-id="{{ $device->id }}" data-name="{{ $device->name }}">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <x-device.no-device-found/>
    @endif
</x-device.device-table>
<a class="btn btn-primary add-device" href="/devices/create?category={{ $currentCategory->id }}">Create</a>
<a class="btn btn-primary order-devices" href="/devices/order?category={{ $currentCategory->id }}">Change the order</a>
<x-device.delete-device-modal/>
