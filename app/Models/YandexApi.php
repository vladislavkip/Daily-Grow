<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YandexApi extends Model
{
    use HasFactory;

    protected $table = 'yandex_api';

    protected $fillable = ['user_id', 'yandex_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}