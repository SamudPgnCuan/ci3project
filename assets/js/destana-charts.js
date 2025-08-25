document.addEventListener('DOMContentLoaded', function() {
    const ctxBar = document.getElementById('chartBar').getContext('2d');
    const ctxDoughnut = document.getElementById('chartDoughnut').getContext('2d');

    // Chart Destana per Kecamatan (existing code)
    fetch(base_url + 'destana/stats_per_kecamatan')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.kecamatan);
            const sudah = data.map(d => Number(d.sudah) || 0);
            const belum = data.map(d => Number(d.belum) || 0);
            const persen = data.map(d => ((d.sudah / (d.sudah + d.belum)) * 100).toFixed(1));

            // Stacked Bar Chart
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Sudah Destana',
                            data: sudah,
                            backgroundColor: '#36A2EB'
                        },
                        {
                            label: 'Belum Destana',
                            data: belum,
                            backgroundColor: '#FF6384'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const total = sudah[context.dataIndex] + belum[context.dataIndex];
                                    const pct = ((context.raw / total) * 100).toFixed(1);
                                    return `(${pct}%)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Chart Destana per Kecamatan error', err));

    // Donut Chart untuk Total Destana (new code)
    fetch(base_url + 'destana/stats')
        .then(res => res.json())
        .then(d => {
          // pastikan angka
          const sudah = Number(d.sudah) || 0;
          const belum = Number(d.belum) || 0;
          const dataset = [sudah, belum];
            // Doughnut Chart
            new Chart(ctxDoughnut, {
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

            // Menambahkan text di tengah donut
            ctxDoughnut.canvas.parentNode.style.position = 'relative';
            if (ctxDoughnut.chart) {
                ctxDoughnut.chart.options.elements = {
                    ...ctxDoughnut.chart.options.elements,
                    center: {
                        text: total.toString(),
                        color: '#333',
                        fontStyle: 'Arial',
                        sidePadding: 20,
                        maxFontSize: 30
                    }
                };
            }
        })
        .catch(err => console.error('Chart Total Destana error', err));
});