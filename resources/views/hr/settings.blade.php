@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">الإعدادات العامة</h2>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('hr.settings.update') }}">
        @csrf
        <div class="mb-4">
            <label class="block">الإضافة لكل ساعة إضافية (جنيه):</label>
            <input type="number" name="overtime" value="{{ $settings->overtime ?? '' }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">الخصم لكل ساعة تأخير (جنيه):</label>
            <input type="number" name="discount" value="{{ $settings->discount ?? '' }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">يوم الإجازة الأسبوعية 1:</label>
            <select name="day_off_1" class="border p-2 w-full">
                <option value="الجمعة" {{ ($settings->day_off_1 ?? '') == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                <option value="السبت" {{ ($settings->day_off_1 ?? '') == 'السبت' ? 'selected' : '' }}>السبت</option>
                <option value="الأحد" {{ ($settings->day_off_1 ?? '') == 'الأحد' ? 'selected' : '' }}>الأحد</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block">يوم الإجازة الأسبوعية 2 (اختياري):</label>
            <select name="day_off_2" class="border p-2 w-full">
                <option value="">لا يوجد</option>
                <option value="الجمعة" {{ ($settings->day_off_2 ?? '') == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                <option value="السبت" {{ ($settings->day_off_2 ?? '') == 'السبت' ? 'selected' : '' }}>السبت</option>
                <option value="الأحد" {{ ($settings->day_off_2 ?? '') == 'الأحد' ? 'selected' : '' }}>الأحد</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">حفظ</button>
    </form>

    <div class="mt-6 flex gap-4">
        <a href="{{ route('departments.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">إضافة قسم</a>
        <a href="{{ route('job_positions.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">إضافة مسمى وظيفي</a>
    </div>
</div>
@endsection
