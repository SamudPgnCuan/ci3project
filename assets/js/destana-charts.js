document.addEventListener('DOMContentLoaded', function() {
    const ctxBar = document.getElementById('chartBar').getContext('2d');
    const ctxDoughnut = document.getElementById('chartDoughnut').getContext('2d');

    // Chart Destana per Kecamatan (existing code)
    fetch(base_url + 'destana/stats_per_kecamatan')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.kecamatan);
            const sudah = data.map(d => d.sudah);
            const belum = data.map(d => d.belum);
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
        .then(data => {
            const total = data.total;
            const sudah = data.sudah;
            const belum = data.belum;
            const persentaseSudah = ((sudah / total) * 100).toFixed(1);
            const persentaseBelum = ((belum / total) * 100).toFixed(1);

            // Doughnut Chart
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Sudah Destana', 'Belum Destana'],
                    datasets: [{
                        data: [sudah, belum],
                        backgroundColor: ['#36A2EB', '#FF6384'],
                        borderColor: ['#36A2EB', '#FF6384'],
                        borderWidth: 2,
                        hoverBackgroundColor: ['#4BC0C0', '#FF9F40'],
                        hoverBorderColor: ['#4BC0C0', '#FF9F40']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw;
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} desa (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%', // Membuat hole di tengah donut
                    elements: {
                        arc: {
                            borderWidth: 2
                        }
                    }
                },
                plugins: [{
                    // Plugin untuk menampilkan text di tengah donut
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        if (chart.config.options.elements.center) {
                            const ctx = chart.ctx;
                            const centerConfig = chart.config.options.elements.center;
                            const fontStyle = centerConfig.fontStyle || 'Arial';
                            const txt = centerConfig.text;
                            const color = centerConfig.color || '#000';
                            const maxFontSize = centerConfig.maxFontSize || 75;
                            const sidePadding = centerConfig.sidePadding || 20;
                            const sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2);

                            ctx.font = "30px " + fontStyle;
                            const stringWidth = ctx.measureText(txt).width;
                            const elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                            const widthRatio = elementWidth / stringWidth;
                            const newFontSize = Math.floor(30 * widthRatio);
                            const finalFontSize = newFontSize > maxFontSize ? maxFontSize : newFontSize;

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            const centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                            const centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                            ctx.font = finalFontSize + "px " + fontStyle;
                            ctx.fillStyle = color;

                            if (txt) {
                                ctx.fillText(txt, centerX, centerY - 10);
                                ctx.font = (finalFontSize * 0.6) + "px " + fontStyle;
                                ctx.fillText('Total Desa', centerX, centerY + 15);
                            }
                        }
                    }
                }]
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