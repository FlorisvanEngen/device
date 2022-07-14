<x-layout>
    <script src="{{url('/js/deletePdf.js')}}"></script>
    <script src="{{url('/js/deletePhoto.js')}}"></script>
    <h1>Device: {{$device->name}}</h1>
    <x-back-button/>
    <form method="POST" action="/devices/{{$device->id}}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <x-form.input name="name" value="{{(old('name') ?: $device->name)}}" required/>
        @if($device->pdf_path != null)
            <div class="mb-3">
                <x-form.label name="pdf_path"/>
                <div id="pdfPathLabel" class="d-flex align-items-start">
                    <label class="form-control">
                        <a href="{{url('/storage/' . $device->pdf_path)}}"
                           target="_blank">{{ str_replace('pdf/', '', $device->pdf_path) }}</a>
                    </label>
                    <button class="btn btn-danger ms-2" type="button" onclick="deletePdf({{$device->id}})">
                        Delete
                    </button>
                </div>
                <input id="pdf_path" class="form-control d-none" name="pdf_path" type="file" name="pdf_path"
                       accept="application/pdf">
                <x-form.error name="pdf_path"/>
            </div>
        @else
            <x-form.input name="pdf_path" type="file" accept="application/pdf"/>
        @endif
        <div class="mb-3">
            <x-form.label name="category_id"/>
            <select id="category_id" name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        {{ (old('category_id') ?: $device->category->id) == $category->id ?? 'selected' }}>{{$category->name}}</option>
                @endforeach
            </select>
            <x-form.error name="category_id"/>
        </div>
        <x-form.textarea name="description" value="{{(old('description') ?: $device->description)}}" required/>
        <x-form.button>
            Update device
        </x-form.button>
    </form>
    <hr/>
    <h1>Device photo's</h1>
    <form class="d-flex flex-row justify-content-center mb-3" method="POST" action="{{url('/devices/photo/' . $device->id)}}" enctype="multipart/form-data">
        @csrf
        <label class="form-label flex-shrink-0 mb-0 align-self-center" for="photo_path">
            New photo:
        </label>
        <input id="photo_path" class="form-control ms-2" name="photo_path" type="file" accept="image/*" required/>
        <button type="submit" class="btn btn-primary flex-shrink-0 ms-2">
            Add photo
        </button>
    </form>
    @if(count($photos))
        <div class="container">
            <div class="row">
                @foreach($photos as $photo)
                    <div id="photo{{$photo->id}}" class="col-md-3 d-flex flex-column mb-3">
                        <div class="p-2">
                            <img src="{{url('/storage/'. $photo->photo_path)}}" width="100%">
                        </div>
                        <button type="button" class="btn btn-danger" onclick="deletePhoto({{$photo->id}})">
                            Delete
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layout>
