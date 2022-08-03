<x-layout>
    <x-slot name="script">
        <script src="{{asset('build/js/contact.js')}}" type="text/javascript"></script>
    </x-slot>
    <h1>Contact</h1>
    <form method="POST" action="{{route('contact.store')}}" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <x-form.input name="name" maxlength="50" required/>
        <x-form.input name="email" type="email" value="{{(old('email') ?: $loggedInEmail)}}" required/>
        <div class="mb-3">
            <x-form.label name="concern_type"/>
            <select id="concern_type" name="concern_type" class="form-control" required>
                <option value="-1" selected disabled>Select a concern type</option>
                <option value="Question">Question</option>
                <option value="Request">Request</option>
                <option value="Other">Other</option>
            </select>
            <x-form.error name="concern_type"/>
        </div>
        <div class="mb-3">
            <x-form.label name="category_id"/>
            <select id="category_id" name="category_id" class="form-control">
                <option value="-1" selected disabled>Select a category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
            <x-form.error name="category_id"/>
        </div>
        <div class="mb-3">
            <x-form.label name="device_id"/>
            <select id="device_id" name="device_id" class="form-control" disabled>
                <option value="-1" selected disabled>Select a device</option>
            </select>
            <x-form.error name="device_id"/>
        </div>
        <x-form.textarea name="text" required/>
        <x-form.button>
            Add device
        </x-form.button>
    </form>
</x-layout>
