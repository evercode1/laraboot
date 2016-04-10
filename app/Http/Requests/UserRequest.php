<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                  'name' => 'required|string|max:20|unique:users,name,' . $this->user,
                  'email' => 'required|email|unique:users,email,'. $this->user,
                  'is_subscribed' => 'boolean',
                  'is_admin' => 'boolean',
                  'user_type_id' => 'in:10,20',
                  'status_id' => 'in:7,10',
        ];
    }
}
