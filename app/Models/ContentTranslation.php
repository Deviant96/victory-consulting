<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'language_code',
        'field',
        'value',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
