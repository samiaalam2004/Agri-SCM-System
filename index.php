<?php
require 'db_config.php';

// Data fetch kora
$inventory = $pdo->query("SELECT * FROM inventory")->fetchAll();
$quality = $pdo->query("SELECT * FROM product_quality")->fetchAll();
$shipments = $pdo->query("SELECT * FROM shipment_tracking")->fetchAll();
$transport = $pdo->query("SELECT * FROM transport_schedule")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agriculture Management System</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h2 { color: #2c3e50; border-bottom: 2px solid #27ae60; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #27ae60; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-optimal { color: green; font-weight: bold; }
        .status-replenish { color: red; font-weight: bold; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; }
        .bg-passed { background: #d4edda; color: #155724; }
        .bg-failed { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h1>🚜 Agriculture DB Dashboard</h1>

    <h2>Current Inventory</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Batch ID</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Warehouse</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($inventory as $item): ?>
            <tr>
                <td><?= $item['product_name'] ?></td>
                <td><?= $item['batch_id'] ?></td>
                <td><?= $item['current_stock'] ?></td>
                <td class="<?= $item['status'] == 'REPLENISH' ? 'status-replenish' : 'status-optimal' ?>">
                    <?= $item['status'] ?>
                </td>
                <td><?= $item['warehouse'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Product Quality Control</h2>
    <table>
        <thead>
            <tr>
                <th>Batch</th>
                <th>Crop</th>
                <th>Moisture (%)</th>
                <th>Temp (°C)</th>
                <th>QA Score</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($quality as $q): ?>
            <tr>
                <td><?= $q['batch_id'] ?></td>
                <td><?= $q['crop_details'] ?></td>
                <td><?= $q['moisture'] ?>%</td>
                <td><?= $q['temperature'] ?>°C</td>
                <td><?= $q['qa_score'] ?></td>
                <td>
                    <span class="badge <?= $q['status'] == 'PASSED' ? 'bg-passed' : 'bg-failed' ?>">
                        <?= $q['status'] ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Active Shipments</h2>
    <table>
        <thead>
            <tr>
                <th>Shipment Code</th>
                <th>Current Location</th>
                <th>Destination</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($shipments as $ship): ?>
            <tr>
                <td><?= $ship['shipment_code'] ?></td>
                <td><?= $ship['current_location'] ?></td>
                <td><?= $ship['destination'] ?></td>
                <td>
                    <div style="background: #eee; width: 100px;">
                        <div style="background: #3498db; width: <?= $ship['progress'] ?>%; color: white; font-size: 10px; text-align: center;">
                            <?= $ship['progress'] ?>%
                        </div>
                    </div>
                </td>
                <td><?= $ship['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Transport Schedule</h2>
    <table>
        <thead>
            <tr>
                <th>Token</th>
                <th>Asset</th>
                <th>Priority</th>
                <th>Route</th>
                <th>Driver</th>
                <th>Departure</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transport as $t): ?>
            <tr>
                <td><?= $t['track_token'] ?></td>
                <td><?= $t['asset_unit'] ?></td>
                <td><strong><?= $t['priority'] ?></strong></td>
                <td><?= $t['destination_route'] ?></td>
                <td><?= $t['assigned_driver'] ?></td>
                <td><?= $t['est_departure'] == '0000-00-00 00:00:00' ? 'Immediate' : $t['est_departure'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>