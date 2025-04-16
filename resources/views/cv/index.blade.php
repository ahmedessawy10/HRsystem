@extends('layouts.master')

@section('title', 'AI CV Analyzer')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">

            <!-- Start Card -->
            <section id="ai-cv-analyzer">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">AI CV Analyzer</h2>
                            </div>

                            <div class="card-body">
                                <!-- Upload Form -->
                                <div class="bg-white rounded shadow p-4 mb-4 border border-gray-200">
                                    <h4 class="mb-3">Upload New CV</h4>
                                    <form action="{{ route('cv.analyze') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Select CV File (PDF, DOC, DOCX)</label>
                                            <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required
                                                class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">
                                            <i class="fa fa-upload"></i> Upload & Analyze
                                        </button>
                                    </form>
                                </div>

                                <!-- CV List -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h4 class="card-title">Analyzed CVs</h4>
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
                                                        <td class="d-flex gap-2">
                                                            <a href="{{ Storage::url($cv->path) }}"
                                                                class="btn btn-sm btn-info" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <form action="{{ route('cv-analysis.destroy', $cv) }}"
                                                                method="POST">
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
                                <!-- End CV List -->

                            </div> <!-- end card-body -->
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection