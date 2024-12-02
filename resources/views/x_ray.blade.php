@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center">X-ray Details</h1>

    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5>X-ray Record</h5>
        </div>
        <div class="card-body">
            @forelse ($user->xrays as $xray)
                <div class="mb-4">
                    <div class="row mb-2">
                        <div class="col-3 font-weight-bold">Date:</div>
                        <div class="col-9">{{ $xray->created_at->format('Y-m-d') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 font-weight-bold">Findings:</div>
                        <div class="col-9">{{ $xray->findings ?: 'No findings available.' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3 font-weight-bold">Image:</div>
                        <div class="col-9">
                            <img src="{{ asset('storage/' . $xray->image) }}" alt="X-ray Image" class="img-fluid mt-2" style="max-height: 400px;">
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ asset('storage/' . $xray->image) }}" download class="btn btn-primary">Download</a>
                    </div>
                    <hr>
                </div>
            @empty
                <div class="alert alert-secondary text-center">No X-ray Records Available</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
