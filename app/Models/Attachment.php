<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    public function email() {
        return $this->belongsTo(Email::class, 'email_id');
    }
}
