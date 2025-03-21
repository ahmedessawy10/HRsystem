<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appSetting = AppSetting::find(1);
        return view('appSettings.app.settings', compact('appSetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'time_zone' => 'required|string',
            'date_format' => 'required|string',
            'logo' => "image|nullable",
            'favicon' => "image|nullable",
            'time_format' => "required",
            'language' => "required",
        ]);

        $data = $request->except(['logo', 'favicon']);

        if (in_array($request->language, LaravelLocalization::getSupportedLanguagesKeys())) {
            app()->setLocale($request->language);
            LaravelLocalization::setLocale($request->language);
        }

        // Set the application's locale


        $data['is_demo'] = boolval($data['is_demo']);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = $file->getClientOriginalName();
            $destinationPath = public_path() . '/uploads';
            $file->move($destinationPath, $logo);
            $data['logo'] = $logo;
        }
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $favicon = $file->getClientOriginalName();
            $destinationPath = public_path() . '/uploads';
            $file->move($destinationPath,  $favicon);
            $data['favicon'] =  $favicon;
        }

        AppSetting::updateOrCreate(
            [
                'id' => 1
            ],
            $data
        );

        return redirect()->back()->with('success', __("app.updete message"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
