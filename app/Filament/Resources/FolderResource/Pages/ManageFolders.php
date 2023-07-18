<?php

namespace App\Filament\Resources\FolderResource\Pages;

use App\Filament\Resources\FolderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFolders extends ManageRecords
{
    protected static string $resource = FolderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
