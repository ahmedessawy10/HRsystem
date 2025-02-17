<div>
    <div class="card-body card-dashboard">
        <!-- الفلتر لاختيار السنة والشهر -->
        <div class="mb-3 flex space-x-4">
            <select wire:model="year" class="form-control w-auto">
                @foreach(range(Carbon\Carbon::now()->year - 5, Carbon\Carbon::now()->year) as $y)
                <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>

            <select wire:model="month" class="form-control w-auto">
                @foreach(range(1, 12) as $m)
                <option value="{{ $m }}">{{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>

        <!-- جدول عرض بيانات الرواتب -->
        <table class="table table-striped table-bordered zero-configuration">
            <thead>
                <tr class="">
                    <th>Name</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Attendances (Days)</th>
                    <th>Late (Minutes)</th>
                    <th>Extra (Minutes)</th>
                    <th>Net Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->department?->name ?? 'N/A' }}</td>
                    <td>{{ number_format($user->salary) }} EGP</td>
                    <td>{{ $user->attendances_count }}</td>
                    <td class=" text-danger font-bold">{{ $user->total_late }}</td>
                    <td class="text-success font-bold">{{ $user->total_extra }}</td>
                    <td class="font-bold">{{ number_format($user->netSalary, 2) }} EGP</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- الترقيم -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links('pagination::bootstrap-4') }}

        </div>
    </div>
</div>