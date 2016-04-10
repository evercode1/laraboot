<?php

namespace App;

use App\ModelTraits\HasModelTrait;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasModelTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['widget_name',
                           'slug',
                           'user_id'];

    /**
     * Get the user that owns the widget.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
