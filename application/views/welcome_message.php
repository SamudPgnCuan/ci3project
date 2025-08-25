
<section class="content-header">
  <div class="container-fluid">
    <h1 class="m-0">Dashboard</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <!-- Chart: Yearly trend -->
    <div class="card mb-3">
      <div class="card-body">
        <h5>Tren Bencana per Tahun (2010 - sekarang)</h5>
        <canvas id="chartYearly" height="120"></canvas>
      </div>
    </div>

    <!-- Chart: Monthly for selected year -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <h5 class="mb-0">Bencana per Bulan</h5>
          <select id="selectYear" class="form-control" style="width:120px; margin-left:12px;"></select>
          <button id="btnRefreshCharts" class="btn btn-sm btn-light ml-2">Refresh</button>
        </div>
        <canvas id="chartMonthly" height="120"></canvas>
      </div>
    </div>

    <!-- chart Persentase Desa Destana -->
    <div class="card">
      <div class="card-header">
        <h5>Persentase Desa Destana</h5>
      </div>
      <div class="card-body">
        <div style="height:350px;">
          <canvas id="chartDestana"></canvas>
        </div>
      </div>
    </div>

    <!-- Chart Donut -->
    <div class="card mt-4">
      <div class="card-header"><h3 class="card-title">Chart Total</h3></div>
      <div class="card-body">
        <canvas id="chartDoughnut"></canvas>
      </div>
    </div>

    <!-- Chart Bar -->
    <div class="card mt-4">
      <div class="card-header"><h3 class="card-title">Stacked Bar Chart Per Kecamatan</h3></div>
      <div class="card-body">
        <canvas id="chartBar"></canvas>
      </div>
    </div>

  </div>
</section>

<!-- it's just this one script surely it's alright like this right? -->
<script>const base_url = '<?= base_url() ?>';</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="<?= base_url('assets/js/bencana-charts.js') ?>"></script>
<script src="<?= base_url('assets/js/destana-charts.js') ?>"></script>
