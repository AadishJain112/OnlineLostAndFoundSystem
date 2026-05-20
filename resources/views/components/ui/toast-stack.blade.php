<div id="toast-stack" class="pointer-events-none fixed bottom-6 right-6 z-[100] flex w-full max-w-sm flex-col gap-3" aria-live="polite"></div>
@if (session('success'))
    <span data-flash-success class="hidden">{{ session('success') }}</span>
@endif
@if (session('error'))
    <span data-flash-error class="hidden">{{ session('error') }}</span>
@endif
@if (session('status'))
    <span data-flash-success class="hidden">{{ session('status') }}</span>
@endif
