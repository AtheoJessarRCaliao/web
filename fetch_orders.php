<?php
require_once 'Database/db.php'; // Include database connection

header('Content-Type: application/json');

// Get optional date range from query parameters
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$query = "SELECT DATE(created_at) AS date, COUNT(*) AS orders, SUM(total_price) AS total_sales FROM daily_orders";
$params = [];

if ($startDate && $endDate) {
    $query .= " WHERE DATE(created_at) BETWEEN ? AND ?";
    $params[] = $startDate;
    $params[] = $endDate;
}

$query .= " GROUP BY DATE(created_at) ORDER BY date ASC";

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['date'],
            'orders' => $row['orders'],
            'total_sales' => $row['total_sales']
        ];
    }
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Failed to fetch data']);
}
?>
