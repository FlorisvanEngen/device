<x-layout>
    <h1>Create a device</h1>
    <x-back-button/>
    <form method="POST" action="/devices" enctype="multipart/form-data">
        @csrf
        <x-form.input name="name" required/>
        <x-form.input name="pdf_path" type="file"/>
        <div class="mb-3">
            <x-form.label name="category_id"/>
            <select id="category_id" name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        {{ old('category_id') == $category->id ?? 'selected' }}>{{$category->name}}</option>
                @endforeach
            </select>
            <x-form.error name="category_id"/>
        </div>
        <x-form.textarea name="description" required/>
        <x-form.button>
            Submit
        </x-form.button>
    </form>
</x-layout>
