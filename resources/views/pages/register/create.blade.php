<x-layout>
    <h1>Register</h1>
    <form method="POST" action="/register" autocomplete="off">
        @csrf
        <x-form.input name="name" required />
        <x-form.input name="email" type="email" required />
        <x-form.input name="password" type="password" required />
        <x-form.button>
            Register
        </x-form.button>
    </form>
</x-layout>
