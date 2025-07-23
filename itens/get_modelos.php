<?php
include '../includes/init.php';

$marca_id = intval($_GET['marca_id'] ?? 0);
$modelos = [];

if ($marca_id > 0) {
  $stmt = $conn->prepare("SELECT id, nome FROM modelos WHERE marca_id = ? ORDER BY nome");
  $stmt->bind_param("i", $marca_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $modelos = $result->fetch_all(MYSQLI_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($modelos);
