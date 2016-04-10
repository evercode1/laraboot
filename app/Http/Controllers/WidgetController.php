<?php

namespace App\Http\Controllers;

use App\Http\AuthTraits\OwnsRecord;
use Illuminate\Http\Request;
use App\Widget;
use Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedException;

class WidgetController extends Controller
{
    use OwnsRecord;

    public function __construct()
    {

        $this->middleware('admin', ['except' => ['index', 'show']]);
        $this->middleware('auth', ['except' => 'index'] );

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('widget.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('widget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'widget_name' => 'required|unique:widgets|string|max:40',

        ]);

        $slug = str_slug($request->widget_name, "-");

        $widget = Widget::create(['widget_name' => $request->widget_name,
                                  'slug' => $slug,
                                  'user_id' => Auth::id()]);

        $widget->save();

        alert()->success('Congrats!', 'You made a widget');

        return Redirect::route('widget.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = '')
    {
        $widget = Widget::findOrFail($id);

        if ($widget->slug !== $slug) {

            return Redirect::route('widget.show', ['id' => $widget->id,
                                                   'slug' => $widget->slug], 301);
        }

        return view('widget.show', compact('widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = Widget::findOrFail($id);

        return view('widget.edit', compact('widget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'widget_name' => 'required|string|max:40|unique:widgets,widget_name,' .$id

        ]);

        $widget = Widget::findOrFail($id);

        if ( ! $this->adminOrCurrentUserOwns($widget)){

            throw new UnauthorizedException;

        }

        $slug = str_slug($request->widget_name, "-");

        $widget->update(['widget_name' => $request->widget_name,
                         'slug' => $slug,
                         'user_id' => Auth::id()]);

        alert()->success('Congrats!', 'You updated a widget');

        return Redirect::route('widget.show', ['widget' => $widget, 'slug' =>$slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Widget::destroy($id);

        alert()->overlay('Attention!', 'You deleted a widget', 'error');

        return Redirect::route('widget.index');
    }
}
