<x-layout>
    <h1>Device: {{$device->name}}</h1>
    <x-back-button/>
    <x-form.input name="name" disabled value="{{$device->name}}"/>
    {{--        <div class="mb-3">--}}
    {{--            <label for="pdf_path" class="form-label">Pdf_path</label>--}}
    {{--            <input type="file" class="form-control" id="pdf_path" name="pdf_path" value="{{old('pdf_path')}}"/>--}}
    {{--            @error('pdf_path')--}}
    {{--            <p class="text-danger mt-1">{{ $message }}</p>--}}
    {{--            @enderror--}}
    {{--        </div>--}}
    <div class="mb-3">
        <x-form.label name="category_id"/>
        <select id="category_id" name="category_id" class="form-control" disabled>
            @foreach($categories as $category)
                <option value="{{$category->id}}"
                    {{ $device->category->id == $category->id ?? 'selected' }}>{{$category->name}}</option>
            @endforeach
        </select>
        <x-form.error name="category_id"/>
    </div>
    <x-form.textarea name="description" value="{{$device->description}}" disabled/>
    <a class="btn btn-primary" href="/devices/{{$device->id}}/edit">Edit</a>
    <button type="button" class="btn btn-danger" onclick="deleteDevice({{$device->id . ',\'' . $device->name . '\''}})">
        Delete
    </button>
    <x-delete-device-modal/>
</x-layout>
