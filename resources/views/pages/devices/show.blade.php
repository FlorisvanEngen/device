<x-layout>
    <h1>Device: {{$device->name}}</h1>
    <x-device.back-button :category="$device->category"/>
    <x-form.input name="name" disabled value="{!! $device->name !!}"/>
    <div class="mb-3">
        <x-form.label name="pdf"/>
        <label class="form-control disabled">
            @if($device->pdf)
                <a href="{{url('media/' . $device->pdf->path)}}"
                   target="_blank">{!! $device->pdf->name !!}</a>
            @endif
        </label>
    </div>
    <x-form.input name="category_id" disabled value="{!! $device->category->name !!}"/>
    <x-form.input name="order" disabled value="{{ $device->order }}"/>
    <x-form.textarea name="description" value="{!! $device->description !!}" disabled/>
    @auth
        <a class="btn btn-primary edit-device" href="/devices/{{$device->id}}/edit">Edit</a>
        <button type="button" class="btn btn-danger delete-device"
                data-id="{{$device->id}}" data-name="{{$device->name}}">
            Delete
        </button>
    @endauth
    @if($device->photos->isNotEmpty())
        <hr/>
        <h1>Device photo's</h1>
        <div class="container">
            <div class="row">
                @foreach($device->photos as $photo)
                    <div class="col-md-3 d-flex flex-column mb-3">
                        <div class="p-2">
                            <img src="{{url('media/' . $photo->path)}}" width="100%">
                        </div>
                        <label class="form-label text-center">
                            {!! $photo->name !!}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <x-device.delete-device-modal/>
</x-layout>
