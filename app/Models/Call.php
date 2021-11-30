<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Call extends Model
{
    use HasFactory;

    /**
     * The Attributes that are allowed for mass assignment.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'client_type',
        'type',
        'duration',
        'score',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
