document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('chartDestana').getContext('2d');

  fetch(base_url + 'destana/stats', { credentials: 'same-origin' })
    .then(res => res.json())
    .then(d => {
      // pastikan angka
      const sudah = Number(d.sudah) || 0;
      const belum = Number(d.belum) || 0;
      const dataset = [sudah, belum];

      new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sudah Destana', 'Belum Destana'],
            datasets: [{
            data: dataset,
            backgroundColor: ['#36A2EB', '#FF6384'],
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: { position: 'bottom' },
            datalabels: {
                formatter: (value, context) => {
                const values = context.chart.data.datasets[0].data;
                const total = values.reduce((a, b) => a + b, 0);
                const pct = total ? ((value / total) * 100).toFixed(1) : 0;
                return `${value} (${pct}%)`; // tampil jumlah + persen
                },
                color: '#fff',
                font: {
                weight: 'bold',
                size: 14
                }
            }
            }
        },
        plugins: [ChartDataLabels] // aktifkan plugin
      });
    })
    .catch(err => console.error('Chart Destana error', err));
});
