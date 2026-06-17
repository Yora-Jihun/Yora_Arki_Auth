<x-landing>
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-lg space-y-8">
            <div class="text-center space-y-4">
                <a href="{{ route('welcome') }}" wire:navigate class="inline-flex items-center justify-center gap-3" aria-label="Yora Arki Home">
                    <span class="grid h-12 w-12 place-items-center bg-blue-600 text-base font-bold text-white">
                        YA
                    </span>
                    <span class="text-xl font-semibold tracking-tight text-slate-950">Yora Arki</span>
                </a>

                <div class="space-y-2">
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-950">Welcome</h1>
                    <p class="text-base leading-6 text-slate-600 max-w-md mx-auto">
                        A secure authentication system built with Laravel, Livewire, and Tailwind CSS.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center bg-[#0A5FFF] px-6 py-3.5 text-sm font-semibold text-white transition duration-200 hover:bg-[#0757E8] focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                >
                    Sign in
                </a>
                <a
                    href="{{ route('register') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 transition duration-200 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-200"
                >
                    Create account
                </a>
            </div>
        </div>
    </div>
</x-landing>