<x-layout>
    <h1>Device: {{$device->name}}</h1>
    <x-device.back-button :category="$device->category"/>
    <x-form.input name="name" disabled value="{{$device->name}}"/>
    <div class="mb-3">
        <x-form.label name="pdf_path"/>
        <label class="form-control disabled">
            @if($device->pdf_path !== null)
            <a href="{{url($device->pdf_path)}}"
               target="_blank">{{ $device->pdf_name }}</a>
            @endif
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
    @auth
        <a class="btn btn-primary" href="/devices/{{$device->id}}/edit">Edit</a>
        <button type="button" class="btn btn-danger delete-device"
                data-id="{{$device->id}}" data-name="{{$device->name}}">
            Delete
        </button>
    @endauth
    @if(count($photos) > 0)
        <hr/>
        <h1>Device photo's</h1>
        <div class="container">
            <div class="row">
                @foreach($photos as $photo)
                    <div class="col-md-3 d-flex flex-column mb-3">
                        <div class="p-2">
                            <img src="{{url($photo->photo_path)}}" width="100%">
                        </div>
                        <label class="form-label text-center">
                            {{ $photo->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <x-device.delete-device-modal/>
</x-layout>
