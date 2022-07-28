<x-layout>
    <h1>Device: {{$device->name}}</h1>
    <x-device.back-button :category="$device->category"/>
    <form method="POST" action="{{ route('devices.update', ['device' => $device->id] )}}" enctype="multipart/form-data"
          autocomplete="off">
        @method('PATCH')
        @csrf
        <input id="id" name="id" type="hidden" value="{{$device->id}}"/>
        <x-form.input name="name" value="{{(old('name') ?: $device->name)}}" maxlength="30" required/>
        @if($device->pdf)
            <div class="mb-3">
                <x-form.label name="pdf"/>
                <div id="pdfPathLabel" class="d-flex align-items-start">
                    <label class="form-control">
                        <a href="{{url('media/' . $device->pdf->path)}}"
                           target="_blank">{!! $device->pdf->name !!}</a>
                    </label>
                    <button type="button" class="btn btn-danger ms-2 delete-file"
                            data-id="{{$device->pdf->id}}">
                        Delete
                    </button>
                </div>
                <input id="pdf" class="form-control d-none" name="pdf" type="file"
                       accept="application/pdf">
                <x-form.error name="pdf"/>
            </div>
        @else
            <x-form.input name="pdf" type="file" accept="application/pdf"/>
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
        <x-form.input name="order" value="{{(old('order') ?: $device->order)}}" type="number" pattern="\d" required/>
        <x-form.textarea name="description" value="{{(old('description') ?: $device->description)}}" required/>
        <x-form.button>
            Update device
        </x-form.button>
    </form>
    <hr/>
    <h1>Device photo's</h1>
    <form class="d-flex flex-row justify-content-center mb-3" method="POST"
          action="{{route('media.store', ['device' => $device->id])}}" enctype="multipart/form-data">
        @csrf
        <label class="form-label flex-shrink-0 mb-0 align-self-center" for="path">
            New photo:
        </label>
        <input id="path" class="form-control ms-2" name="path" type="file" accept="image/*" required/>
        <button type="submit" class="btn btn-primary flex-shrink-0 ms-2">
            Add photo
        </button>
    </form>
    @if(count($device->media))
        <div class="container">
            <div class="row">
                @foreach($device->media as $photo)
                    <div id="photo{{$photo->id}}" class="col-md-3 d-flex flex-column mb-3">
                        <div class="p-2">
                            <img src="{{url('media/' . $photo->path)}}" width="100%">
                        </div>
                        <label class="form-label text-center">
                            {{ $photo->name }}
                        </label>
                        <button type="button" class="btn btn-danger delete-file" data-id="{{$photo->id}}">
                            Delete
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-layout>
