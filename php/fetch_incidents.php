<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require 'db.php';

try {
    $db     = getDB();
    $filter = $_GET['filter'] ?? 'all';
    $sev    = $_GET['severity'] ?? '';

    $sql   = "SELECT * FROM incidents";
    $where = [];
    if ($filter === 'active')   $where[] = "status = 'active'";
    if ($filter === 'resolved') $where[] = "status = 'resolved'";
    if ($filter === 'pending')  $where[] = "status = 'pending'";
    if ($sev    === 'critical') $where[] = "severity = 'critical'";
    if (!empty($where)) $sql .= " WHERE " . implode(" AND ", $where);
    $sql .= " ORDER BY reported_at DESC LIMIT 50";

    $incidents = $db->query($sql)->fetchAll();

    // Stats for today
    $stats = $db->query("
        SELECT
            COUNT(*)                            AS total,
            SUM(status = 'active')              AS active,
            SUM(status = 'resolved')            AS resolved,
            ROUND(AVG(TIMESTAMPDIFF(MINUTE, reported_at, resolved_at)), 0) AS avg_response
        FROM incidents
        WHERE DATE(reported_at) = CURDATE()
    ")->fetch();

    echo json_encode([
        'success'   => true,
        'incidents' => $incidents,
        'stats'     => [
            'total'        => (int)($stats['total']    ?? 0),
            'active'       => (int)($stats['active']   ?? 0),
            'resolved'     => (int)($stats['resolved'] ?? 0),
            'avg_response' => $stats['avg_response']   ?? null,
        ]
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
