<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Date range filter
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '2000-01-01';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Query for order status
$query = "
    SELECT status, COUNT(*) AS count 
    FROM orders 
    WHERE created_at BETWEEN ? AND ?
    GROUP BY status";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$order_status_result = $stmt->get_result();

$order_status = [];
while ($row = $order_status_result->fetch_assoc()) {
    $order_status[] = $row;
}

// Query for product sales
$query = "
    SELECT product_name, SUM(quantity) AS total_quantity
    FROM order_items 
    JOIN orders ON order_items.order_id = orders.id
    WHERE orders.created_at BETWEEN ? AND ?
    GROUP BY product_name";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$product_sales_result = $stmt->get_result();

$product_sales = [];
while ($row = $product_sales_result->fetch_assoc()) {
    $product_sales[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Charts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            flex: 1;
            min-width: 45%; /* Ensure side-by-side layout */
            margin: 10px;
        }
        .container {
            max-width: 900px;
        }
        .chart-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Order and Product Analysis</h2>

    <!-- Date filter form -->
    <form method="GET" class="mb-4">
        <div class="d-flex">
            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>" />
            <input type="date" name="end_date" class="form-control mx-2" value="<?= htmlspecialchars($endDate) ?>" />
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Row for Pie Chart and Bar Chart -->
    <div class="chart-wrapper">
        <?php if (!empty($order_status)): ?>
            <div class="chart-container">
                <canvas id="orderStatusPieChart"></canvas>
            </div>
        <?php endif; ?>

        <?php if (!empty($product_sales)): ?>
            <div class="chart-container">
                <canvas id="productSalesBarChart"></canvas>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Pie Chart for Order Status
<?php if (!empty($order_status)): ?>
    const orderStatusLabels = <?php echo json_encode(array_column($order_status, 'status')); ?>;
    const orderStatusCounts = <?php echo json_encode(array_column($order_status, 'count')); ?>;
    const totalOrders = orderStatusCounts.reduce((a, b) => a + b, 0);

    const pieCtx = document.getElementById('orderStatusPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: orderStatusLabels,
            datasets: [{
                data: orderStatusCounts,
                backgroundColor: ['#FF9999', '#66B3FF', '#99FF99'],
                borderColor: ['#FF0000', '#0000FF', '#00FF00'],
                borderWidth: 3 // Hard borders
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            const percentage = Math.round((tooltipItem.raw / totalOrders) * 100);
                            return `${tooltipItem.label}: ${tooltipItem.raw} (${percentage}%)`;
                        }
                    }
                },
                legend: {
                    labels: {
                        font: {
                            size: 14 // Larger legend text
                        }
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
<?php endif; ?>

// Bar Chart for Product Sales
<?php if (!empty($product_sales)): ?>
    const productNames = <?php echo json_encode(array_column($product_sales, 'product_name')); ?>;
    const productQuantities = <?php echo json_encode(array_column($product_sales, 'total_quantity')); ?>;

    const barCtx = document.getElementById('productSalesBarChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Total Quantity Sold',
                data: productQuantities,
                backgroundColor: '#FFB6C1',
                borderColor: '#FF69B4',
                borderWidth: 3 // Hard borders
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14 // Larger tick font
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 14 // Larger tick font
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14 // Larger legend text
                        }
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
<?php endif; ?>
</script>
</body>
</html>
