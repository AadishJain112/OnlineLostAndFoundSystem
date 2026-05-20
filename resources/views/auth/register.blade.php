<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="font-display text-2xl font-bold gradient-text">Create account</h1>
        <p class="mt-2 text-sm text-slate-500">Join the community today</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <x-ui.input-floating label="Name" name="name" :value="old('name')" required />
        <x-input-error :messages="$errors->get('name')" />
        <x-ui.input-floating label="Email" name="email" type="email" :value="old('email')" required />
        <x-input-error :messages="$errors->get('email')" />
        <x-ui.input-floating label="Password" name="password" type="password" required />
        <x-input-error :messages="$errors->get('password')" />
        <x-ui.input-floating label="Confirm password" name="password_confirmation" type="password" required />
        <x-ui.btn type="submit" variant="primary" class="w-full justify-center">Register</x-ui.btn>
        <p class="text-center text-sm"><a href="{{ route('login') }}" class="text-brand-600 hover:underline">Already registered?</a></p>
    </form>
</x-guest-layout>
