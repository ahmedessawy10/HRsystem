@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">AI CV Analyzer</h2>
        </div>

        <div class="card-body">
            <!-- Upload Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-10 border border-gray-200">
                <h3 class="text-2xl font-semibold mb-6">Upload New CV</h3>
                <form action="{{ route('cv.analyze') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Select CV File (PDF, DOC, DOCX)</label>
                        <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Upload & Analyze
                    </button>
                </form>
            </div>

            <!-- CV List -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Analyzed CVs</h3>
                </div>
                <div class="card-body">
                    @if($cvs->isEmpty())
                        <p class="text-muted">No CVs uploaded yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Experience</th>
                                        <th>Skills</th>
                                        <th>Education</th>
                                        <th>Fit Score</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cvs as $cv)
                                    <tr>
                                        <td>{{ $cv->name }}</td>
                                        <td>{{ $cv->experience_years }} years</td>
                                        <td>{{ $cv->skill_score }}%</td>
                                        <td>{{ $cv->education_score }}%</td>
                                        <td>{{ $cv->fit_score }}%</td>
                                        <td>
                                            <a href="{{ Storage::url($cv->path) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('cv-analysis.destroy', $cv) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
