@forelse ($user->treatments as $treatment)
    <div class="mb-4">
        <div class="row mb-2">
            <div class="col-3 font-weight-bold">Date:</div>
            <div class="col-9">{{ $treatment->created_at->format('Y-m-d') }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-3 font-weight-bold">Type:</div>
            <div class="col-9">
                {{ is_array(json_decode($treatment->type)) ? implode(', ', json_decode($treatment->type)) : $treatment->type }}
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-3 font-weight-bold">Description:</div>
            <div class="col-9">{{ $treatment->description ?: 'No description available.' }}</div>
        </div>
        <hr>
    </div>
@empty
    <div class="alert alert-secondary text-center">No Treatment History Available</div>
@endforelse

