<div {{ $attributes->merge(['class' => 'mx-auto w-full mb-4']) }}>
    <a href="{{ $href ?? '' }}" wire:navigate class="inline-flex items-center px-2.5 py-1.5 mb-3 lg:mb-1 md:mb-6 text-xs font-semibold rounded-full border cursor-pointer text-zinc-900 bg-zinc-100 border-zinc-200 group">
        <x-heroicon-o-arrow-right class="ltr:hidden rtl:relative ltr:mr-2 rtl:ml-2 ltr:-ml-0.5 rtl:-mr-0.5 w-3.5 h-3.5 duration-200 ease-out ltr:translate-x-1 rtl:-translate-x-1 group-hover:translate-x-0.5" />
        <x-heroicon-o-arrow-left class="rtl:hidden ltr:relative  ltr:mr-2 rtl:ml-2 ltr:-ml-0.5 rtl:-mr-0.5 w-3.5 h-3.5 duration-200 ease-out ltr:translate-x-1 rtl:-translate-x-1 group-hover:translate-x-0.5" />
        {{ $text ?? trans('circlexo.back') }}
    </a>
</div>
