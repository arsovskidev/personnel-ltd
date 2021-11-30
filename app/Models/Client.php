<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;


class Client extends Model
{
    use HasUuid, HasFactory;

    /**
     * The Attributes that are allowed for mass assignment.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];
}
