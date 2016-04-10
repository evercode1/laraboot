<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class ApiController extends Controller
{

    public function marketingImageData()
    {

        $result['data'] = DB::table('marketing_images')
            ->select('id',
                'image_name',
                'image_extension',
                'is_active',
                'is_featured',
                'image_weight',
                'created_at')
            ->get();

        return json_encode($result);

    }

    public function profileData(){

        $result['data'] = DB::table('profiles')
                        ->select('profiles.id as id',
                                 'first_name',
                                 'last_name',
                                 'gender',
                                 'birthdate',
                                 'name',
                                 'users.id as user')
                        ->leftJoin('users', 'user_id', '=', 'users.id')
                        ->get();

        return json_encode($result);

    }

    public function userData(){

        $result['data'] = DB::table('users')
                        ->select('id',
                                 'name',
                                 'email',
                                 'is_subscribed',
                                 'is_admin',
                                 'status_id',
                                 'created_at')
                        ->get();

        return json_encode($result);

    }

    public function widgetData(){

        $result['data'] = DB::table('widgets')
                        ->select('id',
                                 'slug',
                                 'widget_name',
                                 'created_at')
                        ->get();

        return json_encode($result);

    }



}
