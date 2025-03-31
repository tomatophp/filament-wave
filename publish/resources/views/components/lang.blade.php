@php
    if(!function_exists('try_svg')) {
        function try_svg($name, $classes) {
            try {
                return svg($name, $classes);
            }
            catch(\Exception $e) {
                return '❓';
            }
        }
    }

    $locales = config('filament-language-switcher.locals');
    $currentLocale = app()->getLocale();
    $currentLanguage = collect($locales)->firstWhere('code', $currentLocale);
    $otherLanguages = $locales;
    $showFlags = config('filament-language-switcher.show_flags');
@endphp

<div x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },
        open: function (event) {
            $refs.panel.open(event)
        },
        close: function (event) {
            $refs.panel.close(event)
        },
    }">

    <button
        @class([
            'block hover:opacity-75',
        ])
        id="filament-language-switcher"
        x-on:click="toggle"
    >
        <div
            x-tooltip="{
                content: '{{ trans('filament-language-switcher::translation.change') }}',
                theme: $store.theme,
            }"
            @class([
                'flex items-center justify-center rounded-md  bg-cover bg-center rounded-md',
                'w-11 h-8 bg-gray-200 dark:bg-gray-900 border border-gray-200 dark:border-gray-700'
            ])
            style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{config('filament-language-switcher.locals')[app()->getLocale()]['flag']?:null}}.svg')"
        >

        </div>
    </button>

    <div x-ref="panel" x-float.placement.bottom-end.flip.offset="{ offset: 8 }" x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95" class="ffi-dropdown-panel absolute z-10 divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10 max-w-[14rem]" style="display: none; left: 1152px; top: 59.5px;">
        <div class="filament-dropdown-list p-1">
            @foreach ($otherLanguages as $key=>$language)
                @php $isCurrent = app()->getLocale() === $key; @endphp
                <a
                    @class([
                        'filament-dropdown-list-item filament-dropdown-item group flex items-center whitespace-nowrap rounded-md p-2 text-sm outline-none text-gray-500 dark:text-gray-200',
                        'hover:bg-gray-50 focus:bg-gray-50 dark:hover:bg-white/5 dark:focus:bg-white/5 hover:text-gray-700 focus:text-gray-500 dark:hover:text-gray-200 dark:focus:text-gray-400' => !$isCurrent,
                        'cursor-default' => $isCurrent,
                    ])
                    @if (!$isCurrent)
                        href="{{ route('languages.user', ['local' => $key]) }}"
                    @endif
                >
                                    <span class="filament-dropdown-list-item-label truncate text-start flex justify-content-start gap-3">
                                       <div
                                           @class([
                                               'w-6 h-5 rounded-md bg-cover bg-center border border-gray-200 dark:border-gray-700',
                                           ])
                                           style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{$language['flag']}}.svg'); background-repeat: no-repeat"
                                       >

                                        </div>
                                        <span @class(['font-semibold' => $isCurrent])>{{ trans('filament-language-switcher::translation.lang.'.$key) }}</span>
                                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
