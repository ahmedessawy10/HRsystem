<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HRSetting;

class SettingsController extends Controller
{
    // عرض صفحة الإعدادات
    public function index()
    {
        $settings = HRSetting::first(); // جلب البيانات الحالية
        return view('settings', compact('settings'));
    }

    // تحديث الإعدادات
    public function update(Request $request)
    {
        $request->validate([
            'overtime' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'start_time' => 'required',
            'end_time' => 'required',
            'day_off_1' => 'required',
            'day_off_2' => 'nullable',
        ]);

        $settings = HRSetting::first();
        if (!$settings) {
            $settings = new HRSetting();
        }

        $settings->overtime = $request->overtime;
        $settings->discount = $request->discount;
        $settings->start_time = $request->start_time;
        $settings->end_time = $request->end_time;
        $settings->day_off_1 = $request->day_off_1;
        $settings->day_off_2 = $request->day_off_2;
        $settings->save();

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
