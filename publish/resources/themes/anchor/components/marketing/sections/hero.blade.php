<section class="relative top-0 flex flex-col items-center justify-center w-full min-h-screen -mt-24 bg-white lg:min-h-screen">

        <div class="flex flex-col items-center justify-between flex-1 w-full max-w-2xl gap-6 px-8 pt-32 mx-auto ltr:text-left rtl:text-right md:px-12 xl:px-20 lg:pt-32 lg:pb-16 lg:max-w-7xl lg:flex-row">
            <div class="w-full lg:w-1/2">
                <h1 class="text-6xl font-bold tracking-tight ltr:text-left rtl:text-right sm:text-7xl md:text-8xl sm:text-center lg:text-left text-zinc-900 text-balance">
                    <span class="block ltr:origin-left rtl:origin-right lg:scale-90 text-nowrap mb-6">
                        {{ trans('circlexo.marketing.hero.title-main') }}
                    </span>
                    <span class="ltr:pr-4 rtl:pl-4 text-transparent text-neutral-600 bg-clip-text bg-gradient-to-b from-neutral-900 to-neutral-500">
                        {{ trans('circlexo.marketing.hero.title-secondary') }}
                    </span>
                </h1>
                <p class="mx-auto mt-5 text-2xl font-normal ltr:text-left rtl:text-right sm:max-w-md ltr:lg:ml-0 rtl:lg:mr-0 lg:max-w-md sm:text-center ltr:lg:text-left rtl:lg:text-right text-zinc-500">
                    {{ trans('circlexo.marketing.hero.subtitle') }}
                    <span class="hidden sm:inline"> {{ trans('circlexo.marketing.hero.subtitle-hidden') }}</span>.
                </p>
                <div class="flex flex-col items-center justify-center gap-3 mx-auto mt-8 md:gap-2 lg:justify-start ltr:md:ml-0 rtl:md:mr-0 md:flex-row">
                    <x-button href="{{route('register')}}" tag="a" size="lg" class="w-full lg:w-auto">{{ trans('circlexo.marketing.hero.cta') }}</x-button>
                    <x-button href="{{route('pricing')}}" tag="a" size="lg" color="secondary" class="w-full lg:w-auto">{{ trans('circlexo.marketing.hero.cta2') }}</x-button>
                </div>
            </div>
            <div class="flex items-center justify-center w-full mt-12 lg:w-1/2 lg:mt-0">
                <img alt="Wave Character" class="relative w-full lg:scale-125 xl:translate-x-6" src="/wave/img/character.png" style="max-width:450px;">
            </div>
        </div>
        <div class="flex-shrink-0 lg:h-[150px] flex border-t border-zinc-200 items-center w-full bg-white">
            <div class="grid h-auto grid-cols-1 px-8 py-10 mx-auto gap-5 divide-y max-w-7xl lg:divide-y-0 divide-zinc-200 lg:py-0 ltr:lg:divide-x md:px-12 lg:px-20 lg:divide-zinc-200 lg:grid-cols-3">
                @foreach(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'home')->where('type', 'hero-section')->get() as $key=>$feature)
                    <div @if($key!=0) class="pt-5 lg:pt-0 lg:px-10" @endif>
                        <h3 class="flex items-center font-medium text-zinc-900">
                            {{ $feature->name }}
                        </h3>
                        <p class="mt-2 text-sm font-medium text-zinc-500">
                            {{ $feature->description }}
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
</section>
