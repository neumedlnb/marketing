<?php
// get_data.php
header('Content-Type: application/json; charset=utf-8');

// DB 연결 정보 – 환경에 맞게 수정하세요.
$db_host = 'localhost';
$db_name = 'your_database_name';
$db_user = 'your_username';
$db_pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // submissions 테이블에서 데이터 조회
    $stmt = $pdo->query("SELECT * FROM submissions ORDER BY id DESC");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
