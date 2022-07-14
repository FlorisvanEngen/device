<x-layout>
    <h1>Device: {{$device->name}}</h1>
    <x-back-button/>
    <x-form.input name="name" disabled value="{{$device->name}}"/>
    <div class="mb-3">
        <x-form.label name="pdf_path"/>
        <label class="form-control disabled">
            <a href="{{url('/storage/' . $device->pdf_path)}}"
               target="_blank">{{ str_replace('pdf/', '', $device->pdf_path) }}</a>
        </label>
    </div>
    <div class="mb-3">
        <x-form.label name="category_id"/>
        <select id="category_id" name="category_id" class="form-control" disabled>
            @foreach($categories as $category)
                <option value="{{$category->id}}"
                    {{ $device->category->id == $category->id ?? 'selected' }}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <x-form.input name="order" disabled value="{{$device->order}}"/>
    <x-form.textarea name="description" value="{{$device->description}}" disabled/>
    @can('admin')
        <a class="btn btn-primary" href="/devices/{{$device->id}}/edit">Edit</a>
        <button type="button" class="btn btn-danger"
                onclick="deleteDevice({{$device->id . ',\'' . $device->name . '\''}})">
            Delete
        </button>
    @endcan
    @if(count($photos) > 0)
        <hr/>
        <h1>Device photo's</h1>
        <div class="container">
            <div class="row">
                @foreach($photos as $photo)
                    <div class="col-md-3 d-flex flex-column mb-3">
                        <div class="p-2">
                            <img src="{{url('/storage/'. $photo->photo_path)}}" width="100%">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <x-delete-device-modal/>
</x-layout>
