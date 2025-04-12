<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('CV Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">File Information</h3>
                            <div class="space-y-3">
                                <p><span class="font-medium">File Name:</span> {{ $cv->file_name }}</p>
                                <p><span class="font-medium">Status:</span> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $cv->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($cv->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($cv->status) }}
                                    </span>
                                </p>
                                <p><span class="font-medium">Upload Date:</span> {{ $cv->created_at->format('Y-m-d H:i') }}</p>
                                <a href="{{ Storage::url($cv->file_path) }}" 
                                   class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                   target="_blank">
                                    View CV
                                </a>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Analysis Results</h3>
                            @if($cv->status === 'completed' && $cv->analysis_result)
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-medium mb-2">Skills</h4>
                                        <p class="text-gray-600">{{ $cv->skills ?? 'No skills detected' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium mb-2">Education</h4>
                                        <p class="text-gray-600">{{ $cv->education ?? 'No education details detected' }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium mb-2">Experience</h4>
                                        <p class="text-gray-600">{{ $cv->experience ?? 'No experience details detected' }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-600">Analysis {{ $cv->status }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('cv.index') }}" class="text-gray-600 hover:text-gray-900">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>