<?php

namespace App\Filament\Resources\DrawerResource\Pages;

use App\Filament\Resources\DrawerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDrawer extends EditRecord
{
    protected static string $resource = DrawerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
