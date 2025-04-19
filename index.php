<?php
$nordpool_data = file_get_contents('https://lax.lv/nordpool.json');
$data = json_decode($nordpool_data, true);

$prices = $data['priceFromNow']['hours'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmic Graphy</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Cosmic bg (the epic stars) -->
    <div class="cosmic-bg" id="cosmic-bg"></div>
    <!-- Header -->
    <header>
        <div class="header-content">
            <div class="logo">cosmic <span>Graphy</span></div>
            <div class="sub-title">nord data</div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">

        <!-- Chart -->
        <div class="chart-container c-hover">
            <div class="icon">
                <svg viewBox="0 0 24 24">
                    <path d="M21 21H4a1 1 0 0 1-1-1V4m17 11l-5-5-4 4-4-4-4 4" /> 
                </svg>
            </div>
            <canvas id="sigmaChart"></canvas>
        </div>

        <!-- Flex container for table and circle chart -->
        <div class="flex-container">
            <!-- Table -->
            <div class="table-container">
                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 6h16M4 10h16M4 14h16M4 18h16" /> 
                    </svg>
                </div>
                <div class="div-t">
                    <div class="t-header">
                        <div class="t-cell">Time</div>
                        <div class="t-cell">Price per KWh</div>
                        <div class="t-cell">Economy</div>
                        <div class="t-cell">Action</div>
                    </div>
                    <?php foreach ($prices as $datetime  => $price) : ?>
                        <div class="t-row">
                            <div class="t-cell">
                                
                                <?php  //this was a pain in the ass took me a while to make it work
                                    $time = date('H:i', strtotime($datetime));
                                    echo htmlspecialchars($time); 
                                ?>
                            </div>
                            <div class="t-cell">
                                <?php 
                                    echo number_format($price ?? 0, 2); 
                                ?> EUR
                            </div>
                            <div class="t-cell">
                                <?php
                                    if ($price < 0.30) {
                                        echo '<div class="color good"></div>';
                                    } elseif ($price >= 0.30 && $price <= 0.50) {
                                        echo '<div class="color medium"></div>';
                                    } else {
                                        echo '<div class="color bad"></div>';
                                    }
                                ?>
                            </div>
                            <div class="t-cell">
                                <?php
                                    if ($price < 0.30) {
                                        echo "good";
                                    } elseif ($price >= 0.30 && $price <= 0.50) {
                                        echo "50/50";
                                    } else {
                                        echo "bad";
                                    }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Circle Chart -->
            <div class="chart-container-circle c-hover">
                <div class="icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                        <path d="M12 6.5c-3.03 0-5.5 2.47-5.5 5.5s2.47 5.5 5.5 5.5 5.5-2.47 5.5-5.5-2.47-5.5-5.5-5.5zm0 8c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                </div>
                <canvas id="sigmaChart-circle"></canvas>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    
</body>
</html>
