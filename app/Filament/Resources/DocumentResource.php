<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Drawer;
use App\Models\Folder;
use App\Models\Document;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DocumentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DocumentResource\RelationManagers;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('control'),

                        Select::make('drawer_id')
                            ->label('Drawers')
                            ->options(Drawer::all()->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated( 
                                fn (callable $set) => $set('folder_id', null)
                            ),

                        Select::make('folder_id')
                            ->label('Folders')
                            ->options(function (callable $get) {
                                $drawer = Drawer::find($get('drawer_id'));
                                
                                if (! $drawer) {
                                    return Folder::all()->pluck('name', 'id');
                                }

                                return $drawer->folders->pluck('name', 'id');
                            })
                            ->searchable(),
                            
                        DatePicker::make('date_received'),

                        RichEditor::make('description')
                            ->disableAllToolbarButtons()
                            ->enableToolbarButtons([
                                'bold',
                                'undo',
                                'bulletList',
                                'orderedList',
                                'italic',
                                'strike',
                            ]),
                        
                            
                        TextInput::make('personnel')->label("Indicate person involved"),

                        Toggle::make('is_public'),

                        Hidden::make('user_id')->default(auth()->user()->id),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('control')->searchable()->sortable()->copyable(),
                TextColumn::make('date_received')->date(),
                TextColumn::make('description')->searchable()->sortable()->html(),
                TextColumn::make('folder.name')->searchable()->sortable(),
                TextColumn::make('folder.drawer.name')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->slideOver(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }    

    public static function getGloballySearchableAttributes(): array
    {
        return ['control', 'description'];
    }

    public static function getGlobalSearchResultDetails($model): array
    {
        return [
            'Control' => $model->control,
            'Folder' => $model->folder->name,
        ];
    }
}
