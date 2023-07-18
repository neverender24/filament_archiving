<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drawer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'office_id'];

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

}
