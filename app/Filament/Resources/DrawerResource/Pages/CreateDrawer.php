<?php

namespace App\Filament\Resources\DrawerResource\Pages;

use App\Filament\Resources\DrawerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDrawer extends CreateRecord
{
    protected static string $resource = DrawerResource::class;

    protected function beforeCreate(): void
    {

    }
}
