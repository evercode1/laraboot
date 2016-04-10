<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Profile extends Model
{
    protected $fillable =['user_id',
                          'first_name',
                          'last_name',
                          'birthdate',
                          'gender'];

    public function showBirthdate($birthdate)
    {

        return Carbon::parse($birthdate)->format('m/d/Y');
    }
    public function showGender($gender)
    {

        return $gender == 1 ? 'Male' : 'Female';
    }
    /**
     * Get the user that owns the profile.
     */
    public function user()
    {

        return $this->belongsTo('App\User');
    }
}
