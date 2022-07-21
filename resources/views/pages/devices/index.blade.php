<x-layout>
    <script type="application/javascript" src="{{url('js/devices.js')}}"></script>
    <h1>All devices</h1>
    <form id="categoryForm" class="d-flex mb-2" method="GET" action="{{url('/')}}">
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
    @guest
        <x-device.logged-out-device-table :devices="$devices"/>
    @else
        <x-device.logged-in-device-table :devices="$devices"/>
    @endguest
</x-layout>
