<?php
    use function Laravel\Folio\{middleware, name};
	middleware('auth:accounts');
    name('dashboard');
?>

<x-layouts.app>
	<x-app.container x-data class="lg:gap-6" x-cloak>

{{--		<x-app.alert id="dashboard_alert" class="hidden lg:flex">This is the user dashboard where users can manage settings and access features. <a href="https://devdojo.com/wave/docs" target="_blank" class="mx-1 underline">View the docs</a> to learn more.</x-app.alert>--}}

        <x-app.heading
                title="{{ trans('circlexo.dashboard.title') }}"
                description="{{ trans('circlexo.dashboard.description') }}"
                :border="false"
            />

        <div class="grid grid-cols-1 w-full mt-6 gap-5 md:grid-cols-2 md:gap-3">
            @foreach(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'dashboard')->where('type','widget')->get() as $key=>$feature)
                <x-app.dashboard-card
                    href="{{ $feature->key }}"
                    target="_blank"
                    title="{{ str($feature->name)->replace('$NAME', auth('accounts')->user()->name) }}"
                    description="{{ str($feature->description)->replace('$NAME', auth('accounts')->user()->name) }}"
                    link_text="{{ trans('circlexo.dashboard.link') }}"
                    image="{{ $feature->getFirstMediaUrl('image') }}"
                    icon="{{ $feature->icon }}"
                />
            @endforeach
        </div>

		<div class="mt-5 gap-5">
			@subscriber
				<p>You are a subscribed user with the <strong>{{ auth('accounts')->user()->roles()->first()?->name }}</strong> role.
				<x-app.message-for-subscriber />
			@else
				<p>This current logged in user has a <strong>{{ auth('accounts')->user()->roles()->first()?->name }}</strong> role. To upgrade, <a href="{{ route('settings.subscription') }}" class="underline">subscribe to a plan</a>.
			@endsubscriber

			@admin
				<x-app.message-for-admin />
			@endadmin
		</div>
    </x-app.container>
</x-layouts.app>
