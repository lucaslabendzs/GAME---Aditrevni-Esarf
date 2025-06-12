<?php
require "db_functions.php";
require "authenticate.php";
require "db_credentials.php";

header('Content-Type: application/json');

if (!$login) {
    echo json_encode(['success' => false, 'msg' => 'Não autenticado']);
    exit;
}
date_default_timezone_set('America/Sao_Paulo');
$data = json_decode(file_get_contents('php://input'), true);
$tempo = $data['tempo'] ?? null;

// Converter tempo "hh:mm:ss:ms" para segundos com milissegundos
$tempo_segundos = null;
if ($tempo) {
    $partes = explode(':', $tempo);
    if (count($partes) === 4) {
        $hh = (int)$partes[0];
        $mm = (int)$partes[1];
        $ss = (int)$partes[2];
        $ms = (int)$partes[3];
        $tempo_segundos = $hh * 3600 + $mm * 60 + $ss + $ms / 100;
    }
}

if ($tempo_segundos !== null) {
    $conn = connect_db();
    $user_id = $_SESSION['user_id'];
    date_default_timezone_set('America/Sao_Paulo');
    $data_jogo = date('Y-m-d'); 

    $stmt = $conn->prepare("INSERT INTO $table_ranking_diario (user_id, tempo_segundos, data_jogo) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $user_id, $tempo_segundos, $data_jogo);
    $stmt->execute();
    $stmt->close();
    disconnect_db($conn);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'msg' => 'Tempo inválido']);
}
?>