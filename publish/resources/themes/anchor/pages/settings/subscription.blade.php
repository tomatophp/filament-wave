<?php

    use Filament\Forms\Components\TextInput;
    use Livewire\Volt\Component;
    use function Laravel\Folio\{middleware, name};
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;

    middleware('auth:accounts');
    name('settings.subscription');

	new class extends Component
	{
        public function mount(): void
        {

        }
    }

?>

<x-layouts.app>
    @volt('settings.subscription')
        <div class="relative">
            <x-app.settings-layout
                title="{{ trans('circlexo.settings.subscription.title') }}"
                description="{{ trans('circlexo.settings.subscription.description') }}"
            >
                @subscriber

                <div class="relative w-full h-auto">
                    <x-app.alert id="no_subscriptions" :dismissable="false" type="success">
                        <div class="flex items-center w-full">
                            <x-phosphor-seal-check-duotone class="flex-shrink-0 mr-1.5 -ml-1.5 w-6 h-6" />
                            <span>{{ trans('circlexo.settings.subscription.no_subscriptions') }} {{ auth('accounts')->user()->plan()->name }} {{ auth('accounts')->user()->planInterval() }} {{ trans('circlexo.settings.subscription.plan') }}.</span>
                        </div>
                    </x-app.alert>
                    @if (session('update'))
                        <div class="my-4 text-sm text-green-600">{{ trans('circlexo.settings.subscription.no_subscriptions') }}</div>
                    @endif
                    <livewire:billing.update />
                </div>
                @endsubscriber

                @notsubscriber
                <div class="mb-4">
                    <x-app.alert id="no_subscriptions" :dismissable="false" type="info">
                        <div class="flex items-center gap-1.5">
                            <x-phosphor-shopping-bag-open-duotone class="flex-shrink-0 w-6 h-6" />
                            <span>{{ trans('circlexo.settings.subscription.no_subscriptions') }}</span>
                        </div>
                    </x-app.alert>
                </div>
                <livewire:billing.checkout />
                <p class="flex gap-1 items-center mt-3 mb-4">
                    <x-phosphor-shield-check-duotone class="w-4 h-4" />
                    <span>{{ trans('circlexo.settings.subscription.payment_by') }} </span><strong>{{ ucfirst(config('wave.billing_provider')) }} {{ trans('circlexo.settings.subscription.payment_provider') }}</strong>.
                </p>
                @endnotsubscriber
            </x-app.settings-layout>
        </div>
    @endvolt
</x-layouts.app>
