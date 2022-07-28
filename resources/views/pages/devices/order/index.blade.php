<x-layout>
    <x-slot name="script">
        <script src="{{asset('build/js/editDeviceOrder.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            var categoryId = {{ $currentCategory->id }};
        </script>
    </x-slot>
    <h1>Change the order for the devices</h1>
    <div class="mb-3">
        <button type="button" class="btn btn-primary save-order">Save</button>
        <a class="btn btn-secondary" href="{{url('/')}}">Cancel</a>
    </div>
    <ul class="nav nav-tabs">
        @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link {{$currentCategory->id == $category->id ? 'active' : ''}}"
                   href="{{ url('/devices/order?category=' . $category->id) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
    <table id="deviceOrderTable" class="table table-striped">
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
        @foreach($currentCategory->devices as $device)
            <tr id="device_{{$device->id}}" draggable="true">
                <td>{{$device->id}}</td>
                <td>{{$device->name}}</td>
                <td>{{$device->category->name}}</td>
                <td id="order_{{$device->id}}">{{$device->order}}</td>
                <td>{{$device->created_at}}</td>
            </tr>
        @endforeach
    </table>
    <button type="button" class="btn btn-primary save-order">Save</button>
    <a class="btn btn-secondary" href="{{url('/?category=' . $currentCategory->id)}}">Cancel</a>
</x-layout>
