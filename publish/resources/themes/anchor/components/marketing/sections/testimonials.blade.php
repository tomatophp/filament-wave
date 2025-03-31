<section class="w-full">
    <x-marketing.elements.heading
        level="h2"
        title="{{ trans('circlexo.marketing.testimonials.title') }}"
        description="{{ trans('circlexo.marketing.testimonials.description') }}"
    />
    <ul role="list" class="grid grid-cols-1 gap-12 py-12 mx-auto max-w-2xl lg:max-w-none lg:grid-cols-3">
        <li>
            @foreach(\TomatoPHP\FilamentTypes\Models\Type::query()->where('for', 'home')->where('type','testimonials-section')->get() as $key=>$feature)
                <figure class="flex flex-col justify-between h-full">
                    <blockquote class="">
                        <p class="text-sm sm:text-base font-medium text-zinc-500">
                            {{ $feature->description }}
                        </p>
                    </blockquote>
                    <figcaption class="flex flex-col justify-between mt-6">
                        <img alt="#_" src="{{ $feature->getFirstMediaUrl('image') }}" class="object-cover rounded-full grayscale size-14">
                        <div class="mt-4">
                            <div class="font-medium text-zinc-900">{{ $feature->name }}</div>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </li>
    </ul>
</section>
