<x-card class="flex flex-col w-full max-w-4xl mx-auto lg:my-10">
    <div class="flex flex-wrap items-center justify-between pb-3 mt-5 border-b lg:mt-0 sm:mt-8 border-zinc-200 dark:border-zinc-800 sm:flex-no-wrap">
        <div class="relative p-2">
            <div class="gap-0.5">
                <h2 class="text-xl font-semibold tracking-tight dark:text-zinc-100">{{ $title ?? '' }}</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description ?? '' }}</p>
            </div>
        </div>
    </div>
    <div class="flex flex-col pt-5 lg:flex-row lg:gap-8">
        <aside class="flex-shrink-0 pb-8 lg:pt-4 lg:pb-0 lg:w-48">
            <nav class="flex items-start justify-start lg:flex-col lg:gap-1">
                <div class="px-2.5 pb-1.5 text-xs lg:block hidden font-semibold leading-6 text-zinc-500">{{ trans('circlexo.settings.title') }}</div>
                <div class="flex items-center w-auto gap-2 lg:items-stretch lg:flex-col lg:w-full lg:gap-1">
                    <x-settings-sidebar-link :href="route('settings.profile')" icon="phosphor-user-circle-duotone">{{ trans('circlexo.settings.profile.title') }}</x-settings-sidebar-link>
                    <x-settings-sidebar-link :href="route('settings.security')" icon="phosphor-lock-duotone">{{ trans('circlexo.settings.security.title') }}</x-settings-sidebar-link>
                    <x-settings-sidebar-link :href="route('settings.api')" icon="phosphor-code-duotone">{{ trans('circlexo.settings.api.title') }}</x-settings-sidebar-link>
                </div>
                <div class="px-2.5 pt-3.5 pb-1.5 text-xs lg:block hidden font-semibold leading-6 text-zinc-500">{{ trans('circlexo.settings.billing') }}</div>
                <div class="flex items-center w-full ltr:ml-2 rtl:mr-2 gap-2 lg:items-stretch lg:flex-col ltr:lg:ml-0 rtl:lg:mr-0 lg:gap-1 lg:gap-0">
                    <x-settings-sidebar-link :href="route('settings.subscription')" icon="phosphor-credit-card-duotone">{{ trans('circlexo.settings.subscription.title') }}</x-settings-sidebar-link>
                    <x-settings-sidebar-link :href="route('settings.invoices')" icon="phosphor-invoice-duotone">{{ trans('circlexo.settings.invoices.title') }}</x-settings-sidebar-link>
                </div>
            </nav>
        </aside>

        <div class="py-3 lg:px-6 lg:w-full">
            {{ $slot }}
        </div>
    </div>
</x-card>
