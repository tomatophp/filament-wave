<?php
    use Filament\Forms\Components\TextInput;
    use Livewire\Volt\Component;
    use function Laravel\Folio\{middleware, name};
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Filament\Tables\Actions\Action;
    use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Actions\DeleteAction;
    use Filament\Tables\Actions\EditAction;
    use Filament\Tables\Actions\ViewAction;

    use Illuminate\Support\Str;

    middleware('auth:accounts');
    name('settings.api');

	new class extends Component implements HasForms, Tables\Contracts\HasTable
	{
        use InteractsWithForms, Tables\Concerns\InteractsWithTable;

        // variables for (b)rowing keys
        public $keys = [];

        public ?array $data = [];

        public function mount(): void
        {
            $this->form->fill();
            $this->refreshKeys();
        }

        public function form(Form $form): Form
        {
            return $form
                ->schema([
                    TextInput::make('key')
                        ->label(trans('circlexo.settings.api.key'))
                        ->required()
                ])
                ->statePath('data');
        }

        public function add(){

            $state = $this->form->getState();
            $this->validate();

            $apiKey = auth('accounts')->user()->createApiKey(Str::slug($state['key']));

            Notification::make()
                ->title(trans('circlexo.settings.api.notifications'))
                ->success()
                ->send();

            $this->form->fill();

            $this->refreshKeys();
        }

        public function table(Table $table): Table
        {
            return $table->query(config('wave.models.api_keys')::query()->where('user_id', auth('accounts')->user()->id))
                ->emptyStateHeading(trans('circlexo.settings.api.empty'))
                ->columns([
                    TextColumn::make('name')->label(trans('circlexo.settings.api.name')),
                    TextColumn::make('created_at')->label(trans('circlexo.settings.api.created')),
                ])
                ->actions([
                    ViewAction::make()
                        ->slideOver()
                        ->modalWidth('md')
                        ->form([
                            TextInput::make('name')->label(trans('circlexo.settings.api.name')),
                            TextInput::make('key')->label(trans('circlexo.settings.api.key'))
                            // ...
                        ]),
                    EditAction::make()
                        ->slideOver()
                        ->modalWidth('md')
                        ->form([
                            TextInput::make('name')->label(trans('circlexo.settings.api.name'))
                                ->required()
                                ->maxLength(255),
                            // ...
                        ]),
                    DeleteAction::make(),
            ]);
        }

        public function refreshKeys(){
            $this->keys = auth('accounts')->user()->apiKeys;
        }
	}

?>

<x-layouts.app>
    @volt('settings.api')
        <div class="relative">
            <x-app.settings-layout
                title="{{ trans('circlexo.settings.api.title') }}"
                description="{{ trans('circlexo.settings.api.description') }}"
            >
                <div class="flex flex-col">
                    <form wire:submit="add" class="w-full max-w-lg">
                        {{ $this->form }}
                        <div class="w-full pt-6 text-right">
                            <x-button type="submit">{{ trans('circlexo.settings.api.create') }}</x-button>
                        </div>
                    </form>
                    <hr class="my-8 border-zinc-200">
                    <x-elements.label class="block text-sm font-medium leading-5 text-zinc-700">{{ trans('circlexo.settings.api.current') }}</x-elements.label>
                    <div class="pt-5">
                        {{ $this->table }}
                    </div>
                </div>
            </x-app.settings-layout>
        </div>
    @endvolt
</x-layouts.app>
