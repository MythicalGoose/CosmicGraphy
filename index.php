<?php
$nordpool_data = file_get_contents('https://lax.lv/nordpool.json');
$data = json_decode($nordpool_data, true);

$prices = $data['priceFromNow']['hours'];
$last30 = $data['last30Days']['days'];
$happyHours = $data['overall']['happyHoursByPrice'];

$categoriesCount = ['good' => 0, 'medium' => 0, 'bad' => 0];

$pricesData = [];
foreach ($prices as $datetime => $price) {
    $time = date('H:i', strtotime($datetime));
    $times[] = $time;
    $pricesList[] = $price;

    $pricesData[] = [
        'datetime' => $datetime,
        'time' => $time,
        'price' => $price,
        'category' => $price < 0.30 ? 'good' : ($price <= 0.50 ? 'medium' : 'bad'),
        'categoryText' => $price < 0.30 ? "good" : ($price <= 0.50 ? "50/50" : "bad")
    ];

    if ($price < 0.30) {
        $categoriesCount['good']++;
    } elseif ($price <= 0.50) {
        $categoriesCount['medium']++;
    } else {
        $categoriesCount['bad']++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cosmic Graphy</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="cosmic-bg" id="cosmic-bg"></div>
    <header>
        <div class="header-content">
            <div class="logo">cosmic <span>Graphy</span></div>
            <div class="sub-title">nord data</div>
        </div>
    </header>

    <div class="container">
        <div class="chart-container c-hover">
            <div class="icon">
                <svg viewBox="0 0 24 24">
                    <path d="M21 21H4a1 1 0 0 1-1-1V4m17 11l-5-5-4 4-4-4-4 4" />
                </svg>
            </div>
            <canvas id="sigmaChart"></canvas>
        </div>

        <div class="flex-container">
            <div class="table-container">
                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div class="sort-controls">
                    <select id="sort-select" class="select">
                        <option value="time-asc">Time (High to Low)</option>
                        <option value="time-desc">Time (Low to High)</option>
                        <option value="price-asc">Price (Low to High)</option>
                        <option value="price-desc">Price (High to Low)</option>
                    </select>
                </div>
                <div class="div-t">
                    <div class="t-header">
                        <div class="t-cell">Time</div>
                        <div class="t-cell">Price per KWh</div>
                        <div class="t-cell">Economy</div>
                        <div class="t-cell">Price</div>
                    </div>
                    <div id="table-body">
                        <?php foreach ($pricesData as $item): ?>
                            <div class="t-row" data-time="<?= htmlspecialchars($item['time']) ?>" data-price="<?= $item['price'] ?>" data-category="<?= $item['category'] ?>">
                                <div class="t-cell"><?= htmlspecialchars($item['time']) ?></div>
                                <div class="t-cell"><?= number_format($item['price'] ?? 0, 2) ?> EUR</div>
                                <div class="t-cell">
                                    <div class="color <?= $item['category'] ?>"></div>
                                </div>
                                <div class="t-cell">
                                    <?= $item['categoryText'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="chart-container-circle">
                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                        <path d="M12 6.5c-3.03 0-5.5 2.47-5.5 5.5s2.47 5.5 5.5 5.5 5.5-2.47 5.5-5.5-2.47-5.5-5.5-5.5zm0 8c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                    </svg>
                </div>
                <canvas id="sigmaChart-circle"></canvas>
            </div>
        </div>
    </div>

    <!-- main js -->
    <script src="cool.js"></script>

    <!--Chart js -->
    <script>
        // prolly couldve made this code better, but im NOT botherd i spent wayy to long on this 🙏🙏
        document.addEventListener('DOMContentLoaded', () => {

            const times = <?= json_encode($times) ?>;
            const prices = <?= json_encode(array_map(fn($p) => round($p, 3), $pricesList)) ?>;
            const categories = <?= json_encode($categoriesCount) ?>;

            const happyHourLabels = <?= json_encode(array_map(fn($t) => date('H:i', strtotime($t)), array_keys($happyHours))) ?>;
            const happyHourPrices = <?= json_encode(array_values(array_map(fn($p) => round($p, 3), $happyHours))) ?>;

            const last30Labels = <?= json_encode(array_keys($last30)) ?>;
            const last30Prices = <?= json_encode(array_values(array_map(fn($p) => round($p, 3), $last30))) ?>;

            Chart.defaults.color = 'rgba(226, 209, 249, 0.8)';
            Chart.defaults.font.family = '"Segoe UI", Tahoma, Geneva, Verdana, sans-serif';

            const sigmaCtx = document.getElementById('sigmaChart').getContext('2d');
            const gradient = sigmaCtx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(157, 78, 221, 0.7)');
            gradient.addColorStop(1, 'rgba(157, 78, 221, 0.1)');
            document.querySelector('.chart-container').style.height = '400px';

            new Chart(sigmaCtx, {
                type: 'line',
                data: {
                    labels: times,
                    datasets: [{
                            label: 'Current Prices',
                            data: prices,
                            borderColor: 'rgba(199, 125, 255, 1)',

                            tension: 0.4,
                            pointBackgroundColor: 'rgba(224, 170, 255, 1)',
                            pointBorderColor: '#10002b',
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBorderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Happy Hour',
                            data: happyHourPrices,
                            borderColor: 'rgb(70, 77, 50)',
                            backgroundColor: 'rgb(58, 235, 42)',
                            borderWidth: 3,
                            tension: 0.4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBorderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Last 30 Days',
                            data: last30Prices,
                            borderColor: 'rgb(64, 182, 0)',
                            backgroundColor: 'rgb(73, 209, 0)',
                            borderWidth: 3,
                            tension: 0.4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBorderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: 20
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(90, 24, 154, 0.2)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: v => v.toFixed(2) + ' EUR'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(90, 24, 154, 0.2)',
                                drawBorder: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'rgba(226, 209, 249, 0.9)'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Price per KWh',
                            color: 'rgba(224, 170, 255, 1)',
                            font: {
                                size: 18,
                                weight: 'bold'
                            }
                        }
                    }
                }
            });

            const doughnutCtx = document.getElementById('sigmaChart-circle').getContext('2d');
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Good Price', 'Medium Price', 'Bad Price'],
                    datasets: [{
                        data: [categories.good, categories.medium, categories.bad],
                        backgroundColor: ['rgba(46, 204, 113, 0.8)', 'rgba(243, 156, 18, 0.8)', 'rgba(231, 76, 60, 0.8)'],
                        borderColor: ['rgba(39, 174, 96, 1)', 'rgba(230, 126, 34, 1)', 'rgba(192, 57, 43, 1)'],
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    layout: {
                        padding: 20
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(226, 209, 249, 0.9)',
                                font: {
                                    size: 14
                                },
                                padding: 20
                            }
                        },
                        title: {
                            display: true,
                            text: 'Price',
                            color: 'rgba(224, 170, 255, 1)',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(16, 0, 43, 0.9)',
                            titleColor: 'rgba(224, 170, 255, 1)',
                            bodyColor: 'rgba(226, 209, 249, 1)',
                            borderColor: 'rgba(157, 78, 221, 0.5)',
                            borderWidth: 1,
                            padding: 15,
                            displayColors: false,
                            callbacks: {
                                label: ctx => {
                                    const value = ctx.parsed || 0;
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    return `${Math.round((value / total) * 100)}% (${value} hours)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>

    <!-- Table Sorting (also a pain, thank god stackoverflow and reddit exist)-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sort-select');
            const tableBody = document.getElementById('table-body');
            
            sortSelect.addEventListener('change', function() {
                const [sortBy, sortDirection] = this.value.split('-');
                sortTable(sortBy, sortDirection);
            });
            
            function sortTable(sortBy, direction) {
                const rows = Array.from(tableBody.querySelectorAll('.t-row'));
                
                rows.sort((a, b) => {
                    let valueA, valueB;
                    
                    switch(sortBy) {
                        case 'time':
                            valueA = a.dataset.time;
                            valueB = b.dataset.time;
                            break;
                        case 'price':
                            valueA = parseFloat(a.dataset.price);
                            valueB = parseFloat(b.dataset.price);
                            break;
                    }
                    
                    if (direction === 'asc') {
                        return valueA > valueB ? 1 : -1;
                    } else {
                        return valueA < valueB ? 1 : -1;
                    }
                });
                rows.forEach(row => tableBody.appendChild(row));
            }
            
            sortTable('time', 'asc');
        });
    </script>
</body>

</html>