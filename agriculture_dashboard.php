<?php
include 'db_config.php';

// Stats logic (Database theke count ana)
$total_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$total_data = mysqli_fetch_assoc($total_res);

$shelf_res = mysqli_query($conn, "SELECT MAX(quantity) as max_shelf FROM products");
$shelf_data = mysqli_fetch_assoc($shelf_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Dashboard | Premium Agri-SCM</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
<body>

<nav>
    <strong>👑 AGRI-SCM</strong>
    <div class="nav-links">
        <a href="agriculture_dashboard.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="add_product.html"><i class="fa-solid fa-plus-circle"></i> Add Crop</a>
        <a href="home.html" style="color:#ff7675;"><i class="fa-solid fa-power-off"></i> Logout</a>
    </div>
</nav>

<div class="container">
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Crop Varieties</h3>
            <p><?php echo $total_data['total']; ?></p>
        </div>
        <div class="stat-card">
            <h3>Peak Shelf Life</h3>
            <p><?php echo ($shelf_data['max_shelf'] ?? 0) . " Days"; ?></p>
        </div>
        <div class="stat-card">
            <h3>Active Batches</h3>
            <p>Live</p>
        </div>
    </div>

    <div class="card">
        <div class="header-actions">
            <h2>My Produced Crops</h2>
            <div style="display:flex; gap:15px; flex-wrap: wrap;">
                <a href="add_product.html" class="add-btn"><i class="fa-solid fa-plus"></i> New Batch</a>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Crop Name</th>
                        <th>Planting Date</th>
                        <th>Harvest Date</th>
                        <th>Shelf Life</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    if(mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>
                                    <td><strong>{$row['product_name']}</strong></td>
                                    <td><i class='fa-solid fa-calendar-day' style='color:#27ae60; margin-right:8px;'></i>{$row['start_date']}</td>
                                    <td><i class='fa-solid fa-calendar-check' style='color:#f39c12; margin-right:8px;'></i>{$row['end_date']}</td>
                                    <td><i class='fa-solid fa-hourglass-half' style='color:#3498db; margin-right:8px;'></i>{$row['quantity']} Days</td>
                                    <td><span class='status-badge'>Ready for Transport</span></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>No crops found in database.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>