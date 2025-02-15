<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HRSettings;

class HRSettingsController extends Controller
{
    public function index()
    {
        $settings = HRSettings::first(); // جلب أول إعدادات من الجدول
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'overtime' => 'required|numeric',
            'discount' => 'required|numeric',
            'day_off_1' => 'required|string',
            'day_off_2' => 'required|string',
            'alternative_day_off' => 'nullable|string',

        ]);

        $settings = HRSettings::first(); // جلب البيانات الحالية
        $settings->update($request->all()); // تحديث البيانات الجديدة

        return redirect()->route('settings.index')->with('success', 'تم تحديث الإعدادات بنجاح!');
    }
}
