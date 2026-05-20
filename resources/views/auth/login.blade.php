<x-guest-layout>
    <div class="mb-8 text-center" data-aos="fade-up">
        <h1 class="font-display text-2xl font-bold gradient-text">Welcome back</h1>
        <p class="mt-2 text-sm text-slate-500">Sign in to your account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div data-aos="fade-up" data-aos-delay="50">
            <x-ui.input-floating label="Email" name="email" type="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div data-aos="fade-up" data-aos-delay="100">
            <x-ui.input-floating label="Password" name="password" type="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
            Remember me
        </label>
        <x-ui.btn type="submit" variant="primary" class="w-full justify-center">Sign in</x-ui.btn>
        @if (Route::has('password.request'))
            <p class="text-center text-sm"><a href="{{ route('password.request') }}" class="text-brand-600 hover:underline">Forgot password?</a></p>
        @endif
        <p class="text-center text-sm text-slate-500">No account? <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:underline">Register</a></p>
    </form>
</x-guest-layout>
