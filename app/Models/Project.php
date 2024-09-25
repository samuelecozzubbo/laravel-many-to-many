<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    protected $fillable = ['type_id', 'title', 'description', 'start_date', 'end_date', 'collaborators', 'img', 'slug'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
    ];
}
