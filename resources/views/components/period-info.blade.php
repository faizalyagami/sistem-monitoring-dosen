<div class="alert alert-info mb-3 border-0 shadow-sm d-flex align-items-center">
    <i class="bi bi-calendar-range fs-5 me-2"></i>
    <div>
        Menampilkan data untuk:
        <strong>
            @if (session('selected_period_id') === 'all')
                Semua Periode
            @elseif(session('selected_period_id'))
                {{ \App\Models\AcademicPeriod::find(session('selected_period_id'))?->nama_periode }}
            @else
                {{ \App\Models\AcademicPeriod::where('is_active', true)->first()?->nama_periode ?? 'Periode Aktif' }}
            @endif
        </strong>
    </div>
</div>
