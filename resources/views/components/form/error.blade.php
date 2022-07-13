@props(['name'])

@error($name)
<p class="text-danger mt-1">{{ $message }}</p>
@enderror
