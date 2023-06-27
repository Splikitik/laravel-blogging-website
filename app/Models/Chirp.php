<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Request as ModelsRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'status',
        'description',
        'image', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requests(): BelongsTo
    {
        return $this->belongsTo(ModelsRequest::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
