<x-layout>
    <h1>Login</h1>
    <form method="POST" action="/sessions">
        @csrf
        <x-form.input name="email" type="email" required/>
        <x-form.input name="password" type="password" required/>
        <x-form.button>
            Login
        </x-form.button>
    </form>
</x-layout>
