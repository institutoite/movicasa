<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseResource\Pages;
use App\Filament\Resources\HouseResource\RelationManagers;
use App\Models\House;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use App\Models\photo;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Collection;


class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    RichEditor::make('description')
                    ->toolbarButtons([
                        'bold',            // Negrita
                        'italic',          // Cursiva
                        'underline',       // Subrayado
                        'strike',          // Tachado
                        'bulletList',      // Lista con viñetas
                        'orderedList',     // Lista numerada
                        'link',            // Insertar enlace
                        'blockquote',      // Cita
                        'codeBlock',       // Bloque de código
                        'undo',            // Deshacer
                        'redo',            // Rehacer
                    ])
                    ->required()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'category') // Asume que tienes una relación definida en tu modelo
                    // ->searchable()
                    ->placeholder('Selecciona una categoría')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->required()
                    ->numeric()
                    ->step('0.01')
                    ->rules(['regex:/^\d+(\.\d{1,2})?$/']) // Acepta hasta 2 decimales
                    ->prefix('Bs.')
                    ->placeholder('Ingrese el precio')
                    ->minValue(0)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('bedrooms')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('bathrooms')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ancho')
                    ->label('Ancho')
                    ->required()
                    ->numeric()
                    ->step('0.01') // Permite decimales
                    ->minValue(0) // Opcional: impide valores negativos
                    ->placeholder('Ingrese el ancho en metros')
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('largo')
                    ->label('Largo')
                    ->required()
                    ->numeric()
                    ->step('0.01') // Permite decimales
                    ->minValue(0) // Opcional: impide valores negativos
                    ->placeholder('Ingrese el largo en metros')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('longitud')
                    ->label('Longitud')
                    ->numeric()
                    ->step('0.000001') // Permite varios decimales para mayor precisión
                    ->placeholder('Ingrese la longitud')
                    ->minValue(-180) // Longitud válida va de -180 a 180
                    ->maxValue(180)
                    ->default(null)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('latitud')
                    ->label('Latitud')
                    ->numeric()
                    ->step('0.000001') // Permite varios decimales para mayor precisión
                    ->placeholder('Ingrese la latitud')
                    ->minValue(-90) // Latitud válida va de -90 a 90
                    ->maxValue(90)
                    ->default(null)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('garage')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('area')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_featured')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')
                ->searchable(),
            Tables\Columns\TextColumn::make('category_id')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('address')
                ->searchable(),
            Tables\Columns\TextColumn::make('price')
                ->money()
                ->sortable(),
            Tables\Columns\TextColumn::make('bedrooms')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('bathrooms')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('ancho')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('largo')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('longitud')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('latitud')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('garage')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('area')
                ->numeric()
                ->sortable(),
            Tables\Columns\IconColumn::make('is_featured')
                ->boolean(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            // Aquí puedes añadir filtros si lo necesitas
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            
            // Botón para Cargar Imágenes
            Action::make('uploadImages')
                ->label('Cargar Imágenes') // Texto del botón
                ->color('success')
                ->modalHeading('Cargar Imágenes para la Casa')
                ->modalWidth('lg')
                ->form([
                    FileUpload::make('photos')
                        ->label('Seleccionar Imágenes')
                        ->multiple() // Permite cargar múltiples imágenes
                        ->directory('houses') // Carpeta de almacenamiento
                        ->image()
                        ->required(),
                ])
                ->action(function (House $record, array $data) {
                    if (!empty($data['photos'])) {
                        foreach ($data['photos'] as $photoPath) {
                            photo::create([
                                'house_id' => $record->id,
                                'path' => $photoPath,
                            ]);
                        }
                    }
                })
                ->requiresConfirmation()
                ->button(), // Botón sin ícono, solo texto
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouses::route('/'),
            'create' => Pages\CreateHouse::route('/create'),
            'edit' => Pages\EditHouse::route('/{record}/edit'),
        ];
    }
}
