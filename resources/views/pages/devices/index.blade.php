<x-layout>
    <h1>All devices</h1>
    {{ $devices->links() }}
    <ul class="nav nav-tabs">
        @foreach($categories as $category)
            <li class="nav-item">
                <a class="nav-link {{$currentCategory->id == $category->id ? 'active' : ''}}"
                   href="{{ url('/?category=' . $category->id) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
    @guest
        <x-device.logged-out-device-table :devices="$currentCategory->devices"/>
    @else
        <x-device.logged-in-device-table :devices="$devices" :currentCategory="$currentCategory"/>
    @endguest
</x-layout>
