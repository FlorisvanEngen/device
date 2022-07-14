@props(['name'])

<label for="{{$name}}" class="form-label">
    {{ucwords(str_replace('_path', '', str_replace('_id', '', $name)))}}
</label>
