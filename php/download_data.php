<?php
// download_data.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 데이터베이스 연결 정보 (환경에 맞게 수정하세요)
$db_host = 'localhost';
$db_name = 'newmed_db';
$db_user = 'newmed_user';
$db_pass = 'password123';

try {
    // PDO 객체 생성 및 연결
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // submissions 테이블에서 데이터 조회
    $stmt = $pdo->query("SELECT * FROM submissions ORDER BY id DESC");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // CSV 파일 다운로드 헤더 설정
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="data_download.csv"');

    $output = fopen('php://output', 'w');

    if (!empty($results)) {
        // 첫 줄에 컬럼명 추가
        fputcsv($output, array_keys($results[0]));
        foreach ($results as $row) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
