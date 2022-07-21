<x-layout>
{{--    <script type="application/javascript" src="{{url('js/devices.js')}}"></script>--}}
    <h1>All devices</h1>
    <form id="categoryForm" class="d-flex mb-2" method="GET" action="{{url('/devices')}}">
        <label class="form-label align-self-center mb-0" for="category">Category:</label>
        <div class="col-md-2">
            <select id="category" name="category" class="form-control ms-2" onchange="$('#categoryForm').submit()">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        {{isset($currentCategory) && $currentCategory->id == $category->id ? 'selected' : ''}}>
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    {{ $devices->links() }}
    <table id="deviceTable" class="table table-striped">
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
            <th></th>
        </tr>
        @if(count($devices) > 0)
            @foreach($devices as $device)
                <tr data-deviceid="{{$device->id}}">
                    <td>{{$device->id}}</td>
                    <td>{{$device->name}}</td>
                    <td>{{$device->category->name}}</td>
                    <td>{{$device->order}}</td>
                    <td>{{$device->created_at->format('H:i:s d-m-Y')}}</td>
                    <td>
                        @auth
                            <a class="btn btn-link btn-sm" href="/devices/{{$device->id}}/edit">Edit</a>
                            <button type="button" class="btn btn-link link-danger btn-sm"
                                    onclick="deleteDevice({{$device->id . ',\'' . $device->name . '\''}})">Delete
                            </button>
                        @endauth
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">No devices has been found.</td>
            </tr>
        @endif
    </table>
    {{ $devices->links() }}
    @auth
        <a class="btn btn-primary" href="/devices/create">Create</a>
        <a class="btn btn-primary" href="/devices/order">Change the order</a>
        <x-delete-device-modal/>
    @endauth
</x-layout>
