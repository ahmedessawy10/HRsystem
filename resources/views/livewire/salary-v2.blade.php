<div>
    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card-body card-dashboard">
        <!-- الفلتر لاختيار السنة والشهر -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="fw-bold fs-5"> user name </label>
                    <input wire:model.live.debounce.150ms="user" class="form-control ">

                    </input>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="fw-bold fs-5"> year</label>
                    <select wire:model.live="year" class="form-control ">
                        @foreach(range(Carbon\Carbon::now()->year - 5, Carbon\Carbon::now()->year) as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="fw-bold fs-5"> month</label>
                    <select wire:model.live="month" class="form-control ">
                        @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}">{{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{-- <div class="mb-3 d-flex  space-x-4">

         
        </div> --}}

        <div wire:loading class="text-center">
            Loading...
        </div>

        <div wire:loading.remove style="overflow: auto">
            <!-- جدول عرض بيانات الرواتب -->
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                    <tr class="">
                        <th>Name</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th>Attendances (Days)</th>
                        <th>Absents (Days)</th>
                        <th>Late (Hours)</th>
                        <th>Extra (Hours)</th>
                        <th>LateCost </th>
                        <th>ExtraCost</th>
                        <th>Net Salary</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->department?->name ?? 'N/A' }}</td>
                        <td>{{ number_format($user->salaries[0]?->salary) ?? 0}} EGP</td>
                        <td>{{$user->attendances_count}}</td>
                        <td>{{$user->salaries[0]->absent}}</td>
                        <td class=" text-danger font-bold">{{ $user->salaries[0]->delay_hours ?? 0 }}</td>
                        <td class="text-success font-bold ">{{ $user->salaries[0]->extra_hours ??0 }}
                        </td>
                        <td class=" text-danger font-bold">{{ $user->salaries[0]->delay_cost ??0}}
                        </td>
                        <td class="text-success font-bold">{{ $user->salaries[0]->extra_cost ??0 }}</td>
                        <td class="font-bold">{{ number_format($user->salaries[0]->net_salary, 2)??0 }} EGP</td>
                        <td>
                            <a href="{{ route('salaries.edit', $user->salaries[0]->id) }}" class="btn"><i
                                    class="fa fa-edit"></i>

                                </i></a>


                            <a href="{{ route('salaries.print', $user->salaries[0]->id) }}" class="btn"><i
                                    class="fa fa-print"></i>

                                </i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No data found</td>
                        @endforelse
                </tbody>
            </table>

            <!-- الترقيم -->
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>