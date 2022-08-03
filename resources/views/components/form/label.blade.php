@props(['name'])

<label for="{{$name}}" class="form-label">
    {{ucfirst(str_replace('_type', ' type', str_replace('_id', '', $name)))}}
</label>
