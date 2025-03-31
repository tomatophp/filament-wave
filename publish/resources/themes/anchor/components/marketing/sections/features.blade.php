<section>
    <x-marketing.elements.heading
        level="h2"
        title="{{ trans('circlexo.marketing.features.title') }}"
        description="{{ trans('circlexo.marketing.features.description') }}"
    />
    <div class="text-center">
        <div class="grid grid-cols-2 gap-x-6 gap-y-12 mt-12 text-center lg:mt-16 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-16">
            @foreach(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'home')->where('type','feature-section')->get() as $key=>$feature)
                <div>
                    <div class="flex justify-center items-center mx-auto bg-zinc-100 rounded-full size-12">
                        <x-icon name="{{ $feature->icon }}" class="w-6 h-6" />
                    </div>
                    <div class="mt-6">
                        <h3 class="font-medium text-zinc-900">{{ $feature->name }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">
                            {{ $feature->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
