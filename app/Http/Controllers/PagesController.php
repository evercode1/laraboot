<?php

namespace App\Http\Controllers;

use App\ImageTraits\ManagesImages;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class PagesController extends Controller
{
    use ManagesImages;

    public function __construct()
    {

        $this->setImageDefaultsFromConfig('marketingImage');

    }
    public function index()
    {

        $featuredImage = DB::table('marketing_images')->where('is_featured', 1)
            ->where('is_active', 1)
            ->first();

        $activeImages = DB::table('marketing_images')->where('is_featured', 0)
            ->where('is_active', 1)
            ->orderBy('image_weight', 'asc')
            ->get();

        $count = count($activeImages);

        $imagePath = $this->imagePath;

        return view('pages.index', compact('featuredImage', 'activeImages', 'count', 'imagePath'));
    }

    public function privacy()
    {

        return view('pages.privacy');
    }

    public function terms()
    {

        return view('pages.terms-of-service');
    }




}
