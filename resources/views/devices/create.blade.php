<x-layout>
    <h1>Create a device</h1>
    <x-back-button/>
    <form method="POST" action="/devices">
        @csrf
        <x-form.input name="name" required/>
        {{--        <div class="mb-3">--}}
        {{--            <label for="pdf_path" class="form-label">Pdf_path</label>--}}
        {{--            <input type="file" class="form-control" id="pdf_path" name="pdf_path" value="{{old('pdf_path')}}"/>--}}
        {{--            @error('pdf_path')--}}
        {{--            <p class="text-danger mt-1">{{ $message }}</p>--}}
        {{--            @enderror--}}
        {{--        </div>--}}
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
