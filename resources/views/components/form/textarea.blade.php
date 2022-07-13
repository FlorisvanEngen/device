@props(['name', 'value' => old($name)])

<div class="mb-3">
    <x-form.label name="{{$name}}"/>
    <textarea class="form-control"
              id="{{$name}}"
              name="{{$name}}"
              rows="3"
              {{$attributes}}>{{$value}}</textarea>
    <x-form.error name="{{$name}}"/>
</div>
