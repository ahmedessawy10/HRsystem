@extends('layouts.master')
@section('content')
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ __('Upload CV for Analysis') }}</h3>
                    <a href="{{ route('cv-analysis.index') }}" class="btn btn-secondary">
                        <i class="fa fa-list"></i> {{ __('Back to List') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('cv.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="cv_file">{{ __('Select CV File (PDF, DOC, DOCX)') }}</label>
                        <input type="file" name="cv_file" id="cv_file" class="form-control" required>
                        @error('cv_file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="fa fa-upload"></i> {{ __('Upload and Analyze') }}
                    </button>
                </form>

                <div id="analysisResult" class="mt-4" style="display: none;">
                    <h4>{{ __('Analysis Results') }}</h4>
                    <div class="alert alert-info" role="alert">
                        <div id="resultContent"></div>
                    </div>
                </div>

                @if(isset($cvs) && $cvs->count() > 0)
                    <div class="mt-5">
                        <h4>{{ __('Recent Analyses') }}</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('File Name') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Summary') }}</th>
                                        <th>{{ __('Experience') }}</th>
                                        <th>{{ __('Skills') }}</th>
                                        <th>{{ __('Soft Skills') }}</th>
                                        <th>{{ __('Education') }}</th>
                                        <th>{{ __('Relevance') }}</th>
                                        <th>{{ __('Fit Score') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cvs as $cv)
                                    <tr>
                                        <td>{{ $cv->file_name }}</td>
                                        <td>{{ $cv->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($cv->summary)
                                                <div class="text-wrap" style="max-width: 200px; max-height: 80px; overflow-y: auto;">
                                                    {{ Str::limit($cv->summary, 100) }}
                                                    @if(strlen($cv->summary) > 100)
                                                        <a href="#" class="view-summary" data-bs-toggle="modal" data-bs-target="#summaryModal" data-summary="{{ $cv->summary }}">
                                                            {{ __('Read More') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $cv->experience_years }} {{ __('years') }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $cv->skill_score }}%" 
                                                     aria-valuenow="{{ $cv->skill_score }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $cv->skill_score }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" 
                                                     style="width: {{ $cv->soft_skills }}%" 
                                                     aria-valuenow="{{ $cv->soft_skills }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $cv->soft_skills }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: {{ $cv->education_score }}%" 
                                                     aria-valuenow="{{ $cv->education_score }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $cv->education_score }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: {{ $cv->relevant_experience }}%" 
                                                     aria-valuenow="{{ $cv->relevant_experience }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $cv->relevant_experience }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ $cv->fit_score }}%" 
                                                     aria-valuenow="{{ $cv->fit_score }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $cv->fit_score }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $cv->status === 'completed' ? 'success' : ($cv->status === 'processing' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($cv->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ Storage::url($cv->file_path) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   target="_blank"
                                                   title="{{ __('View CV') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $cvs->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Modal -->
    <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryModalLabel">{{ __('CV Summary') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalSummaryContent"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('cvUploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = document.getElementById('uploadButton');
    const resultDiv = document.getElementById('analysisResult');
    const resultContent = document.getElementById('resultContent');

    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> {{ __("Analyzing...") }}';

    fetch('{{ route("cv.analyze") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultContent.innerHTML = `
                <p><strong>{{ __("Status") }}:</strong> ${data.data.status}</p>
                <p><strong>{{ __("Skills") }}:</strong> ${data.data.skills || '{{ __("Not detected") }}'}</p>
                <p><strong>{{ __("Education") }}:</strong> ${data.data.education || '{{ __("Not detected") }}'}</p>
                <p><strong>{{ __("Experience") }}:</strong> ${data.data.experience || '{{ __("Not detected") }}'}</p>
            `;
            resultDiv.style.display = 'block';
            if (data.reload) {
                setTimeout(() => location.reload(), 2000);
            }
        } else {
            throw new Error(data.message || '{{ __("Analysis failed") }}');
        }
    })
    .catch(error => {
        resultContent.innerHTML = `<div class="alert alert-danger">{{ __("Error") }}: ${error.message}</div>`;
        resultDiv.style.display = 'block';
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = '<i class="fa fa-upload"></i> {{ __("Upload and Analyze") }}';
    });
});

// Add modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const summaryButtons = document.querySelectorAll('.view-summary');
    summaryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const summary = this.getAttribute('data-summary');
            document.getElementById('modalSummaryContent').textContent = summary;
        });
    });
});
</script>
@endpush