<?php
    use function Laravel\Folio\{middleware, name};
    name('subscription.welcome');
    middleware('auth:accounts');
?>

<x-layouts.app>
	<x-app.container x-data class="space-y-6" x-cloak>
        <div class="w-full">
            <x-app.heading
                title="{{ trans('circlexo.settings.subscription.welcome.title') }}"
                description="{{ trans('circlexo.settings.subscription.welcome.description') }}"
            />
            <div class="py-5 space-y-5">
                <p>{{ trans('circlexo.settings.subscription.welcome.body') }}</p>
            </div>
        </div>
    </x-app.container>
    <x-slot name="javascript">
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
        <script>
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        </script>
    </x-slot>
</x-layouts.app>
