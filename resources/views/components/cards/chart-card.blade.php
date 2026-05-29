@props(['title', 'id', 'type' => 'bar'])

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0">
        <h5 class="card-title mb-0">
            <i class="bi bi-graph-up me-2 text-primary"></i>
            {{ $title }}
        </h5>
    </div>
    <div class="card-body">
        <canvas id="{{ $id }}" height="300"></canvas>
    </div>
</div>
