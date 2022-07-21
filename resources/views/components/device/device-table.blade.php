@props(['devices'])

{{ $devices->links() }}
<table id="deviceTable" class="table table-striped">
    {{ $slot }}
</table>
{{ $devices->links() }}
