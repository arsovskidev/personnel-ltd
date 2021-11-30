<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Disable the ability to change the UUID on update/save.
     *
     * @var bool
     */
    protected $isLockedUuid = true;

    /**
     * Using by eloquent to get the type of the primary key.
     * A UUID is identified as a string.
     * @return string 
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Using by eloquent to get if the primary key is auto increment.
     * A UUID is not, so we need to return false.
     * @return bool 
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Add behavior to creating and saving eloquent events.
     * @return void
     */
    public static function bootHasUuid()
    {
        // Create A UUID to the model if it does not have one.
        static::creating(function (Model $model) {
            $model->keyType = 'string';
            $model->incrementing = false;

            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });

        // Set original if trying to change the UUID on update/save.
        static::saving(function (Model $model) {
            $original_id = $model->getOriginal('id');
            if (!is_null($original_id) && $model->isLockedUuid) {
                if ($original_id !== $model->id) {
                    $model->id = $original_id;
                }
            }
        });
    }
}
