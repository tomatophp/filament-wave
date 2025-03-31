<?php
    use Filament\Forms\Components\TextInput;
    use Livewire\Volt\Component;
    use function Laravel\Folio\{middleware, name};
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;

    middleware('auth:accounts');
    name('settings.security');

	new class extends Component implements HasForms
	{
        use InteractsWithForms;

        public ?array $data = [];

        public function mount(): void
        {
            $this->form->fill();
        }

        public function form(Form $form): Form
        {
            return $form
                ->schema([
                    TextInput::make('current_password')
                        ->label(trans('circlexo.settings.security.current_password'))
                        ->required()
                        ->rule('current_password:accounts')
                        ->password()
                        ->revealable(),
                    TextInput::make('password')
                        ->label(trans('circlexo.settings.security.password'))
                        ->required()
                        ->minLength(4)
                        ->password()
                        ->revealable(),
                    TextInput::make('password_confirmation')
                        ->label(trans('circlexo.settings.security.password_confirmation'))
                        ->required()
                        ->password()
                        ->revealable()
                        ->same('password')
                    // ...
                ])
                ->statePath('data');
        }

        public function save(): void
        {
            $state = $this->form->getState();
            $this->validate();

            auth('accounts')->user()->forceFill([
                'password' => bcrypt($state['password'])
            ])->save();

            $this->form->fill();

            Notification::make()
                ->title(trans('circlexo.settings.security.notification'))
                ->success()
                ->send();
        }

	}

?>

<x-layouts.app>
    @volt('settings.security')
        <div class="relative">
            <x-app.settings-layout
                title="{{ trans('circlexo.settings.security.title') }}"
                description="{{ trans('circlexo.settings.security.description') }}"
            >
                <form wire:submit="save" class="w-full max-w-lg">
                    {{ $this->form }}
                    <div class="w-full pt-6 text-right">
                        <x-button type="submit">{{ trans('circlexo.settings.save') }}</x-button>
                    </div>
                </form>

            </x-app.settings-layout>
        </div>
    @endvolt
</x-layouts.app>
