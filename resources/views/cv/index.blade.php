@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">CV Analysis Results</h2>
        </div>

        <div class="card-body">
            <!-- Debug section -->
            @if($cvs->isEmpty())
                <div class="alert alert-info">No CVs found in the database.</div>
            @else
                <!-- Count of CVs -->
                <div class="alert alert-info">Found {{ $cvs->count() }} CV(s)</div>
                
                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Summary</th>
                                <!-- <th>Experience</th> -->
                                <th>Skills</th>
                                <th>Education</th>
                                <th>Fit Score</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cvs as $cv)
                                <tr>
                                    <td>{{ $cv->file_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($cv->summary)
                                            {{ Str::limit($cv->summary, 100) }}
                                            @if(strlen($cv->summary) > 100)
                                                <button class="btn btn-sm btn-link" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#summaryModal{{ $cv->id }}">
                                                    Read more
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted">No summary available</span>
                                        @endif
                                    </td>
                                    <!-- <td>{{ $cv->experience_years ?? 'N/A' }} years</td> -->
                                    <td>{{ $cv->skill_score ?? 'N/A' }}%</td>
                                    <td>{{ $cv->education_score ?? 'N/A' }}%</td>
                                    <td>{{ $cv->fit_score ?? 'N/A' }}%</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ Storage::url($cv->file_path) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <form action="{{ route('cvs.destroy', $cv) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this CV and its analysis?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        {{ $cv->status === 'processing' ? 'disabled' : '' }}
                                                        title="Delete CV">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Summary Modal -->
                                <div class="modal fade" id="summaryModal{{ $cv->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">CV Summary</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $cv->summary }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
