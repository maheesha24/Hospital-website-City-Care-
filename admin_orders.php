<?php  
// Assuming you are using PDO for database connection
$dsn = "mysql:host=localhost;dbname=hospital_db";
$username = "root";
$password = "";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);

    // Check if order_id and status are set via POST
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $orderId = $_POST['order_id'];
        $status = $_POST['status'];

        // Update order status in the database
        $updateSql = "UPDATE orders SET status = :status WHERE id = :order_id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute(['status' => $status, 'order_id' => $orderId]);

      
        if ($status === 'Shipped') {
            header("Location: ship_order.php?order_id=" . $orderId);
        } elseif ($status === 'Canceled') {
            header("Location: cancel_order.php?order_id=" . $orderId);
        }
        exit();
        
    }

    // Get filtering parameters
    $filterStatus = isset($_GET['status']) ? $_GET['status'] : '';
    $filterStartDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $filterEndDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            margin-top: 30px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
        }
        .filter-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Manage Orders</h2>

    <!-- Filter Form -->
    <form method="GET" class="filter-form">
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Pending" <?php echo ($filterStatus === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Shipped" <?php echo ($filterStatus === 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                    <option value="Canceled" <?php echo ($filterStatus === 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($filterStartDate); ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($filterEndDate); ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <?php 
    try {
        // Build the SQL query with optional filters
        $sql = "
            SELECT o.id AS order_id, o.full_name, o.address, o.city, o.postal_code, o.country, o.phone, o.subtotal, 
                o.shipping, o.total AS order_total, o.created_at AS order_created_at, o.status AS order_status,
                oi.product_name, oi.quantity, oi.price, oi.total AS item_total, oi.created_at AS item_created_at
            FROM orders o
            LEFT JOIN order_items oi ON o.id = oi.order_id
            WHERE 1=1
        ";

        // Apply status filter if set
        if ($filterStatus) {
            $sql .= " AND o.status = :status";
        }

        // Apply date range filter if set
        if ($filterStartDate && $filterEndDate) {
            $sql .= " AND o.created_at BETWEEN :start_date AND :end_date";
        } elseif ($filterStartDate) {
            $sql .= " AND o.created_at >= :start_date";
        } elseif ($filterEndDate) {
            $sql .= " AND o.created_at <= :end_date";
        }

        $sql .= " ORDER BY o.created_at DESC";

        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);

        // Bind parameters for filtering
        if ($filterStatus) {
            $stmt->bindParam(':status', $filterStatus);
        }
        if ($filterStartDate) {
            $stmt->bindParam(':start_date', $filterStartDate);
        }
        if ($filterEndDate) {
            $stmt->bindParam(':end_date', $filterEndDate);
        }

        $stmt->execute();

        // Fetch all orders and order items
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if orders are fetched successfully
        if (!$orders) {
            throw new Exception("No orders found.");
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    ?>

    <?php if (!empty($orders)): ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Country</th>
                    <th>Phone</th>
                    <th>Subtotal</th>
                    <th>Shipping</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['full_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['city'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['postal_code'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['country'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?></td>
                        <td><?php echo isset($order['subtotal']) ? number_format($order['subtotal'], 2) : 'N/A'; ?></td>
                        <td><?php echo isset($order['shipping']) ? number_format($order['shipping'], 2) : 'N/A'; ?></td>
                        <td><?php echo isset($order['order_total']) ? number_format($order['order_total'], 2) : 'N/A'; ?></td>
                        <td><?php echo htmlspecialchars($order['order_created_at'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['product_name'] ?? 'N/A'); ?></td>
                        <td><?php echo isset($order['quantity']) ? $order['quantity'] : 'N/A'; ?></td>
                        <td><?php echo htmlspecialchars($order['order_status'] ?? 'N/A'); ?></td>
                        <td>
                            <!-- Status Form -->
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <select name="status" class="form-control">
                                    <option value="Shipped" <?php echo ($order['order_status'] === 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="Canceled" <?php echo ($order['order_status'] === 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found matching your criteria.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
