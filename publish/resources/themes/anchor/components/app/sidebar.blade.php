<div x-data="{ sidebarOpen: false }"  @open-sidebar.window="sidebarOpen = true"
    x-init="
        $watch('sidebarOpen', function(value){
            if(value){ document.body.classList.add('overflow-hidden'); } else { document.body.classList.remove('overflow-hidden'); }
        });
    "
    class="relative z-50 w-screen md:w-auto" x-cloak>
    {{-- Backdrop for mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false" class="fixed top-0 ltr:right-0 rtl:left-0 z-50 w-screen h-screen duration-300 ease-out bg-black/20 dark:bg-white/10"></div>

    {{-- Sidebar --}}
    <div :class="{ 'ltr:-translate-x-full  rtl:translate-x-full': !sidebarOpen }"
        class="fixed ltr:border-r rtl:border-l border-zinc-200/70 dark:border-zinc-700 top-0 ltr:left-0 rtl:right-0 flex items-stretch ltr:-translate-x-full  rtl:translate-x-full overflow-hidden ltr:lg:translate-x-0 rtl:lg:-translate-x-0 z-50 h-dvh md:h-screen transition-[width,transform] duration-150 ease-out bg-zinc-50 dark:bg-zinc-900 w-64 group @if(config('wave.dev_bar')){{ 'pb-10' }}@endif">
        <div class="flex flex-col justify-between w-full overflow-auto md:h-full h-svh pt-4 pb-2.5">
            <div class="relative flex flex-col">
                <button x-on:click="sidebarOpen=false" class="flex items-center justify-center flex-shrink-0 w-10 h-10 ltr:ml-4 rtl:mr-4 rounded-md lg:hidden text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 dark:hover:bg-zinc-700/70 hover:bg-gray-200/70">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>

                <div class="flex items-center px-5 gap-2">
                    <a href="{{ url('/') }}" class="flex justify-center items-center py-4 ltr:pl-0.5 rtl:pr-0.5 gap-1 font-bold text-zinc-900">
                        <x-logo class="w-auto h-7" />
                    </a>
                </div>
                <div class="flex items-center px-4 pt-1 pb-3">
                    <div class="relative flex items-center w-full h-full rounded-lg">
                        <x-phosphor-magnifying-glass class="absolute ltr:left-0 rtl:right-0 w-5 h-5 ltr:ml-2 rtl:mr-2 text-gray-400 -translate-y-px" />
                        <input type="text" class="w-full py-2 ltr:pl-8 rtl:pr-8 text-sm border rounded-lg bg-zinc-200/70 focus:bg-white duration-50 dark:bg-zinc-950 ease border-zinc-200 dark:border-zinc-700/70 dark:ring-zinc-700/70 focus:ring dark:text-zinc-200 dark:focus:ring-zinc-700/70 dark:focus:border-zinc-700 focus:ring-zinc-200 focus:border-zinc-300 dark:placeholder-zinc-400" placeholder="{{ trans('circlexo.dashboard.search') }}">
                    </div>
                </div>

                <div class="flex flex-col justify-start items-center px-4 space-y-1.5 w-full h-full text-slate-600 dark:text-zinc-400">
                    <x-app.sidebar-link href="{{ url('/dashboard') }}" icon="phosphor-house" :active="Request::is('dashboard')">
                        {{ trans('circlexo.dashboard.title') }}</x-app.sidebar-link>
                    @foreach(menu('dashboard') as $item)
                        <x-app.sidebar-link href="{{$item->is_route? route($item->route) : $item->url }}" icon="{{ $item->icon }}" :active="Request::is(str($item->url)->remove('/')->toString())">
                            {{ $item->title[app()->getLocale()] }}</x-app.sidebar-link>
                    @endforeach
                </div>
            </div>

            <div class="relative px-2.5 space-y-1.5 text-zinc-700 dark:text-zinc-400">
                @foreach(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'dashboard')->where('type','sidebar-menu')->get() as $key=>$feature)
                    <x-app.sidebar-link href="{{ $feature->key }}" target="_blank" icon="{{ $feature->icon }}" active="false">
                        {{ $feature->name }}</x-app.sidebar-link>
                @endforeach
                <x-app.sidebar-link :href="route('changelogs')" icon="phosphor-book-open-text-duotone" :active="Request::is('changelog') || Request::is('changelog/*')">
                    {{ trans('circlexo.changelog.title') }}</x-app.sidebar-link>

{{--                <div x-show="sidebarTip" x-data="{ sidebarTip: $persist(true) }" class="px-1 py-3" x-collapse x-cloak>--}}
{{--                    <div class="relative w-full px-4 py-3 space-y-1 border rounded-lg bg-zinc-50 text-zinc-700 dark:text-zinc-100 dark:bg-zinc-800 border-zinc-200/60 dark:border-zinc-700">--}}
{{--                        <button @click="sidebarTip=false" class="absolute top-0 right-0 z-50 p-1.5 mt-2.5 ltr:mr-2.5 rtl:ml-2.5 rounded-full opacity-80 cursor-pointer hover:opacity-100 hover:bg-zinc-100 hover:dark:bg-zinc-700 hover:dark:text-zinc-300 text-zinc-500 dark:text-zinc-400">--}}
{{--                            <x-phosphor-x-bold class="w-3 h-3" />--}}
{{--                        </button>--}}
{{--                        <h5 class="pb-1 text-sm font-bold -translate-y-0.5">Edit This Section</h5>--}}
{{--                        <p class="block pb-1 text-xs opacity-80 text-balance">You can edit any aspect of your user dashboard. This section can be found inside your theme component/app/sidebar file.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
