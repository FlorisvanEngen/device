@props(['devices'])

<x-device.device-table :devices="$devices">
    <colgroup>
        <col style="width: 10%;">
        <col style="width: 25%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
        <col style="width: 25%;">
    </colgroup>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Category</th>
        <th>Order</th>
        <th>Created at</th>
    </tr>
    @if($devices->isNotEmpty())
        @foreach($devices as $device)
            <tr data-deviceid="{{ $device->id }}">
                <td>{{ $device->id }}</td>
                <td>{!! $device->name !!}</td>
                <td>{!! $device->category->name !!}</td>
                <td>{{ $device->order }}</td>
                <td>{{ $device->created_at }}</td>
            </tr>
        @endforeach
    @else
        <x-device.no-device-found />
    @endif
</x-device.device-table>
