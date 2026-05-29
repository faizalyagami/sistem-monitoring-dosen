<x-layouts.app title="Dashboard">
    <div class="container-fluid">
        <!-- Welcome Banner -->
        <div class="card bg-gradient-primary text-white mb-4 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="card-text opacity-75 mb-0">
                            Sistem Monitoring Kinerja Dosen - Periode Aktif:
                            <strong>{{ $currentPeriod->display_name ?? 'Belum ada periode aktif' }}</strong>
                        </p>
                    </div>
                    <div class="text-center">
                        <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <x-cards.stat-card title="Total Dosen" :value="$stats['total_dosen']" icon="people" color="primary" :trend="['type' => 'up', 'value' => '12']" />

            <x-cards.stat-card title="Total Mata Kuliah" :value="$stats['total_pengajaran']" icon="book" color="success"
                :trend="['type' => 'up', 'value' => '8']" />

            <x-cards.stat-card title="Total Penelitian" :value="$stats['total_riset']" icon="mortarboard" color="info"
                :trend="['type' => 'up', 'value' => '15']" />

            <x-cards.stat-card title="Total PKM" :value="$stats['total_pkm']" icon="people-fill" color="warning"
                :trend="['type' => 'down', 'value' => '3']" />
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-xl-6 col-lg-12 mb-4">
                <x-cards.chart-card title="Distribusi Pengajaran per Bidang Keilmuan" id="teachingChart">
                    @push('scripts')
                        <script>
                            const teachingCtx = document.getElementById('teachingChart').getContext('2d');
                            new Chart(teachingCtx, {
                                type: 'bar',
                                data: {
                                    labels: @json($teachingByField->pluck('bidang_keilmuan')),
                                    datasets: [{
                                        label: 'Jumlah Mata Kuliah',
                                        data: @json($teachingByField->pluck('total')),
                                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1,
                                        borderRadius: 8
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        legend: {
                                            position: 'top'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                drawBorder: false
                                            }
                                        },
                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    @endpush
                </x-cards.chart-card>
            </div>

            <div class="col-xl-6 col-lg-12 mb-4">
                <x-cards.chart-card title="Status Penelitian" id="researchChart">
                    @push('scripts')
                        <script>
                            const researchCtx = document.getElementById('researchChart').getContext('2d');
                            new Chart(researchCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: @json($researchByStatus->pluck('status')),
                                    datasets: [{
                                        data: @json($researchByStatus->pluck('total')),
                                        backgroundColor: ['#27ae60', '#e74c3c', '#3498db'],
                                        borderWidth: 0,
                                        hoverOffset: 10
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
                                        }
                                    },
                                    cutout: '60%'
                                }
                            });
                        </script>
                    @endpush
                </x-cards.chart-card>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row">
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-trophy me-2 text-warning"></i>
                                Top 5 Dosen dengan Beban Mengajar Tertinggi
                            </h5>
                            <a href="{{ route('admin.dosens.index') }}" class="btn btn-sm btn-link">
                                Lihat Semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Dosen</th>
                                        <th>Jumlah MK</th>
                                        <th>Total SKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topLecturers as $index => $dosen)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary rounded-circle px-2 py-1">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $dosen->photo_url }}" class="rounded-circle me-2"
                                                        width="35" height="35">
                                                    <div>
                                                        <strong>{{ $dosen->nama }}</strong><br>
                                                        <small
                                                            class="text-muted">{{ $dosen->jabatan_fungsional }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $dosen->pengajarans_count }} MK</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $dosen->pengajarans->sum('sks') }}
                                                    SKS</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-newspaper me-2 text-info"></i>
                                Penelitian Terbaru
                            </h5>
                            <a href="{{ route('admin.riset.index') }}" class="btn btn-sm btn-link">
                                Lihat Semua <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach ($recentRisets as $riset)
                                <div class="list-group-item list-group-item-action border-0">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-1">{{ $riset->judul_riset }}</h6>
                                            <p class="mb-1 small text-muted">
                                                <i class="bi bi-person"></i> {{ $riset->dosen->nama }}
                                            </p>
                                        </div>
                                        <small class="text-muted">{{ $riset->tahun }}</small>
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-cash"></i> {{ $riset->formatted_dana_attribute }}
                                        </span>
                                        <span class="badge bg-light text-dark ms-1">
                                            <i class="bi bi-tag"></i> {{ $riset->bidang_riset }}
                                        </span>
                                        {!! $riset->status_badge !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
