<?php
header('Content-Type: application/json');
include 'db_config.php';

$action = $_GET['action'] ?? '';

// --- ১. FETCH ALL DATA ---
if ($action == 'fetch') {
    $res = mysqli_query($conn, "SELECT * FROM inventory ORDER BY id DESC");
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($data);
}

// --- ২. ADD OR UPDATE PRODUCT ---
elseif ($action == 'save') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['product_name'];
    $warehouse = $_POST['warehouse'];
    $stock = $_POST['current_stock'];
    $quality = $_POST['quality'];
    $status = ($stock < 50) ? 'REPLENISH' : 'OPTIMAL';

    if ($id) {
        // Update
        $query = "UPDATE inventory SET product_name='$name', warehouse='$warehouse', current_stock='$stock', quality='$quality', status='$status' WHERE id=$id";
    } else {
        // Add New (Batch ID auto generate)
        $batch = "BATCH-" . rand(100, 999);
        $query = "INSERT INTO inventory (product_name, batch_id, quality, current_stock, status, warehouse) 
                  VALUES ('$name', '$batch', '$quality', '$stock', '$status', '$warehouse')";
    }

    if (mysqli_query($conn, $query)) echo json_encode(['status' => 'success']);
}

// --- ৩. PLUS / MINUS BUTTON (Stock Adjust) ---
elseif ($action == 'adjust_stock') {
    $id = $_POST['id'];
    $amount = $_POST['amount']; // e.g. 50 or -50
    
    // Age check korchi stock minus-e jachhe kina
    $check = mysqli_query($conn, "SELECT current_stock FROM inventory WHERE id=$id");
    $row = mysqli_fetch_assoc($check);
    $newStock = $row['current_stock'] + $amount;
    
    if($newStock < 0) {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient Stock']);
    } else {
        $status = ($newStock < 50) ? 'REPLENISH' : 'OPTIMAL';
        mysqli_query($conn, "UPDATE inventory SET current_stock=$newStock, status='$status' WHERE id=$id");
        echo json_encode(['status' => 'success']);
    }
}

// --- ৪. DELETE BUTTON ---
elseif ($action == 'delete') {
    $id = $_POST['id'];
    if (mysqli_query($conn, "DELETE FROM inventory WHERE id=$id")) {
        echo json_encode(['status' => 'success']);
    }
}
?>