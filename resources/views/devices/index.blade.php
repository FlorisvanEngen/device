<x-layout>
    <h1>All devices</h1>
    <table class="table table-striped">
        <colgroup>
            <col style="width: 10%;">
            <col style="width: 30%;">
            <col style="width: 20%;">
            <col style="width: 20%;">
            <col style="width: 20%;">
        </colgroup>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Category</th>
            <th>Created at</th>
            <th></th>
        </tr>
        @foreach($devices as $device)
            <tr>
                <td>{{$device->id}}</td>
                <td>{{$device->name}}</td>
                <td>{{$device->category->name}}</td>
                <td>{{$device->created_at->format('H:i:s d-m-Y')}}</td>
                <td>
                    <a class="btn btn-link" href="/devices/{{$device->id}}">Show</a>
                    <a class="btn btn-link" href="/devices/{{$device->id}}/edit">Edit</a>
                    <button type="button" class="btn btn-link link-danger" onclick="deleteDevice({{$device->id . ',\'' . $device->name . '\''}})">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $devices->links() }}
    <a class="btn btn-primary" href="/devices/create">Create</a>
    <x-delete-device-modal/>
</x-layout>
