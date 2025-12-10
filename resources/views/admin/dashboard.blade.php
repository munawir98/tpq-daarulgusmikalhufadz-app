@extends('layouts.admin')

@section('title', 'Dashboard Presensi')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Dashboard Presensi Super Admin</h2>

    <!-- EXPORT PDF & EXCEL -->
    <div class="row mb-4">
        <div class="col-md-2">
            <a href="/api/admin/export/pdf/{{ date('Y-m') }}" class="btn btn-danger w-100">
                Export PDF
            </a>
        </div>
        <div class="col-md-2">
            <a href="/api/admin/export/excel/{{ date('Y-m') }}" class="btn btn-success w-100">
                Export Excel
            </a>
        </div>
    </div>

    <!-- FILTER DATE RANGE -->
    <div class="row mb-4">

        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" id="startDate" class="form-control">
        </div>

        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" id="endDate" class="form-control">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100" onclick="loadRange()">Filter Tanggal</button>
        </div>

    </div>

    <!-- FILTER KELAS / USTADZ / SANTRI -->
    <div class="row mb-4">

        <div class="col-md-3">
            <label>Filter Berdasarkan</label>
            <select id="filterType" class="form-control">
                <option value="kelas">Kelas</option>
                <option value="ustadz">Ustadz</option>
                <option value="santri">Santri</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Masukkan ID</label>
            <input type="text" id="filterValue" class="form-control" placeholder="Mis: 1, 2, 3">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-secondary w-100" onclick="loadFilter()">Filter Data</button>
        </div>

    </div>

    <!-- ROW 1 — SUMMARY -->
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="statHadir">0</h3>
                    <p>Total Hadir</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="statTerlambat">0</h3>
                    <p>Total Terlambat</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="statIzin">0</h3>
                    <p>Total Izin</p>
                </div>
                <div class="icon"><i class="fas fa-user-check"></i></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="statAlfa">0</h3>
                    <p>Total Alfa</p>
                </div>
                <div class="icon"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
    </div>

    <!-- ROW 2 — CHART BULANAN + PIE -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Presensi Bulanan</h5>
                </div>
                <div class="card-body"><canvas id="chartBulanan" height="120"></canvas></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Persentase Kehadiran</h5>
                </div>
                <div class="card-body"><canvas id="chartPie" height="220"></canvas></div>
            </div>
        </div>
    </div>

    <!-- ROW 3 — TAHUNAN -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Presensi Tahunan</h5>
                </div>
                <div class="card-body"><canvas id="chartTahunan" height="100"></canvas></div>
            </div>
        </div>
    </div>

    <!-- ROW 4 — HARIAN REALTIME -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Presensi Harian (Realtime)</h5>
                </div>
                <div class="card-body"><canvas id="chartHarian" height="100"></canvas></div>
            </div>
        </div>
    </div>

    <!-- ROW 5 — PER KELAS & PER USTADZ -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Presensi Per-Kelas</h5>
                </div>
                <div class="card-body"><canvas id="chartKelas" height="100"></canvas></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Grafik Presensi Per-Ustadz</h5>
                </div>
                <div class="card-body"><canvas id="chartUstadz" height="100"></canvas></div>
            </div>
        </div>

    </div>

</div>

@endsection



@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    let bulan = "{{ date('Y-m') }}";


    /* INIT DAILY CHART */
    let dailyChart = new Chart(document.getElementById("chartHarian"), {
        type: "bar",
        data: {
            labels: [],
            datasets: [{
                label: "Presensi Per Jam",
                data: [],
                backgroundColor: "#28a745"
            }]
        }
    });


    /* LOAD BULANAN */
    fetch(`/api/admin/presensi/chart/${bulan}`)
        .then(res => res.json())
        .then(data => {

            let hari = data.map(d => d.hari);
            let hadir = data.map(d => d.hadir);
            let terlambat = data.map(d => d.terlambat);
            let izin = data.map(d => d.izin);
            let alfa = data.map(d => d.alfa);

            statHadir.innerText = hadir.reduce((a, b) => a + b, 0);
            statTerlambat.innerText = terlambat.reduce((a, b) => a + b, 0);
            statIzin.innerText = izin.reduce((a, b) => a + b, 0);
            statAlfa.innerText = alfa.reduce((a, b) => a + b, 0);

            new Chart(chartBulanan, {
                type: "line",
                data: {
                    labels: hari,
                    datasets: [
                        { label: "Hadir", borderColor: "green", data: hadir },
                        { label: "Terlambat", borderColor: "orange", data: terlambat },
                        { label: "Izin", borderColor: "blue", data: izin },
                        { label: "Alfa", borderColor: "red", data: alfa },
                    ]
                }
            });

            new Chart(chartPie, {
                type: "pie",
                data: {
                    labels: ["Hadir", "Terlambat", "Izin", "Alfa"],
                    datasets: [{
                        backgroundColor: ["green", "orange", "blue", "red"],
                        data: [
                            hadir.reduce((a, b) => a + b, 0),
                            terlambat.reduce((a, b) => a + b, 0),
                            izin.reduce((a, b) => a + b, 0),
                            alfa.reduce((a, b) => a + b, 0)
                        ]
                    }]
                }
            });

        });


    /* LOAD TAHUNAN */
    fetch(`/api/admin/presensi/chart-tahunan/{{ date('Y') }}`)
        .then(res => res.json())
        .then(data => {

            new Chart(chartTahunan, {
                type: "bar",
                data: {
                    labels: data.map(d => d.bulan),
                    datasets: [{
                        label: "Total Presensi",
                        backgroundColor: "#007bff",
                        data: data.map(d => d.total)
                    }]
                }
            });

        });


    /* FILTER TANGGAL */
    function loadRange() {
        let start = startDate.value;
        let end = endDate.value;

        fetch(`/api/admin/presensi/range?start=${start}&end=${end}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                alert("Filter tanggal berhasil!");
            });
    }


    /* FILTER KELAS / USTADZ / SANTRI */
    function loadFilter() {

        let type = filterType.value;
        let value = filterValue.value;

        if (!value) return alert("Harus mengisi ID!");

        fetch(`/api/admin/presensi/filter?type=${type}&value=${value}`)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                alert("Filter berhasil!");
            });
    }


    /* REALTIME HARIAN */
    setInterval(() => {
        fetch('/api/admin/presensi/chart-today')
            .then(res => res.json())
            .then(data => {

                dailyChart.data.labels = data.map(d => d.hour);
                dailyChart.data.datasets[0].data = data.map(d => d.total);
                dailyChart.update();

            });
    }, 5000);

</script>

@endsection
