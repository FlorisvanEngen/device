<x-layout>
    <script src="{{url('/js/editDeviceOrder.js')}}" type="text/javascript"></script>
    <script>
        var categoryId = {{ $currentCategory->id }};
        var devices = [@foreach($devices as $device){'id': '{{$device->id}}', 'order': {{$device->order}}}{{ !$loop->last ? ',' : ''}}@endforeach];
    </script>
    <h1>Change the order for the devices</h1>
    <div class="mb-3">
        <button type="button" class="btn btn-primary" onclick="saveOrder()">Save</button>
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
    <table class="table table-striped">
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
        @foreach($devices as $device)
            <tr id="device_{{$device->id}}"
                draggable="true" ondragover="allowDrop(event)"
                ondragstart="dragStart(event)" ondrop="drop(event)">
                <td>{{$device->id}}</td>
                <td>{{$device->name}}</td>
                <td>{{$device->category->name}}</td>
                <td id="order_{{$device->id}}">{{$device->order}}</td>
                <td>{{$device->created_at->format('H:i:s d-m-Y')}}</td>
            </tr>
        @endforeach
    </table>
    <button type="button" class="btn btn-primary" onclick="saveOrder()">Save</button>
    <a class="btn btn-secondary" href="{{url('/?category=' . $currentCategory->id)}}">Cancel</a>
</x-layout>
