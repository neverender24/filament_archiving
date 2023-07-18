<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'drawer_id'];

    public function drawer()
    {
        return $this->belongsTo(Drawer::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
