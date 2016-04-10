<?php

namespace App\Http\Controllers;

use App\ImageTraits\ManagesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Requests\CreateImageRequest;
use App\MarketingImage;
use App\Http\Requests\EditImageRequest;


class MarketingImageController extends Controller
{
    use ManagesImages;

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('admin');

        $this->setImageDefaultsFromConfig('marketingImage');


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $thumbnailPath = $this->thumbnailPath;

        return view('marketing-image.index', compact('thumbnailPath'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketing-image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateImageRequest $request)
    {
        //create new instance of model to save from form

        $marketingImage = new MarketingImage([
            'image_name'        => $request->get('image_name'),
            'image_extension'   => $request->file('image')->getClientOriginalExtension(),
            'is_active'         => $request->get('is_active'),
            'is_featured'       => $request->get('is_featured'),
            'image_weight'      => $request->get('image_weight')

        ]);

        // format checkbox values

        $this->formatCheckboxValue($marketingImage);

        // save model

        $marketingImage->save();

        // get instance of file

        $file = $this->getUploadedFile();

        // pass in the file and the model

        $this->saveImageFiles($file, $marketingImage);

        alert()->success('Congrats!', 'Marketing Image And Thumbnail Created!');

        return redirect()->route('marketing-image.show', [$marketingImage]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        $thumbnailPath = $this->thumbnailPath;

        $imagePath = $this->imagePath;


        return view('marketing-image.show', compact('marketingImage', 'thumbnailPath', 'imagePath'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        $thumbnailPath = $this->thumbnailPath;

        return view('marketing-image.edit', compact('marketingImage', 'thumbnailPath'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, EditImageRequest $request)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        $this->setUpdatedImageValues($request, $marketingImage);

        // if file, we have additional requirements before saving

        if ($this->newFileIsUploaded()) {

            $this->deleteExistingImages($marketingImage);

            $this->setNewFileExtension($request, $marketingImage);
        }

        $this->formatCheckboxValue($marketingImage);

        $marketingImage->save();

        // check for file, if new file, overwrite existing file

        if ($this->newFileIsUploaded()){

            $file = $this->getUploadedFile();

            $this->saveImageFiles($file, $marketingImage);

        }

        $thumbnailPath = $this->thumbnailPath;

        $imagePath = $this->imagePath;

        alert()->success('Congrats!', 'image edited!');

        return view('marketing-image.show', compact('marketingImage', 'thumbnailPath', 'imagePath'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        $this->deleteExistingImages($marketingImage);

        MarketingImage::destroy($id);

        alert()->error('Notice', 'image deleted!');

        return redirect()->route('marketing-image.index');
    }

    public function formatCheckboxValue($marketingImage)
    {

        $marketingImage->is_active = ($marketingImage->is_active == null) ? 0 : 1;
        $marketingImage->is_featured = ($marketingImage->is_featured == null) ? 0 : 1;
    }

    /**
     * @param EditImageRequest $request
     * @param $marketingImage
     */
    private function setNewFileExtension(EditImageRequest $request, $marketingImage)
    {
        $marketingImage->image_extension = $request->file('image')->getClientOriginalExtension();
    }

    /**
     * @param EditImageRequest $request
     * @param $marketingImage
     */
    private function setUpdatedImageValues(EditImageRequest $request, $marketingImage)
    {

        $marketingImage->is_active = $request->get('is_active');
        $marketingImage->is_featured = $request->get('is_featured');
        $marketingImage->image_weight = $request->get('image_weight');
    }


}
