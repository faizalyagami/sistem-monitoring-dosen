{{-- resources/views/components/cards/stat-card.blade.php --}}
@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null])

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card card-stats shadow-sm border-0 h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-8">
                    <p class="text-muted text-uppercase small fw-bold mb-1">{{ $title }}</p>
                    <h3 class="fw-bold mb-0">{{ $value }}</h3>
                    @if ($trend)
                        <small class="text-{{ $trend['type'] == 'up' ? 'success' : 'danger' }} mt-2 d-block">
                            <i class="bi bi-arrow-{{ $trend['type'] }}-short"></i> {{ $trend['value'] }}%
                        </small>
                    @endif
                </div>
                <div class="col-4 text-end">
                    <div class="stats-icon bg-{{ $color }} bg-opacity-10 text-{{ $color }}">
                        <i class="bi bi-{{ $icon }} fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .card-stats {
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }
    </style>
@endpush
