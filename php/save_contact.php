<?php
// CORS 허용 헤더
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// JSON 파일 경로
$filePath = 'contacts.json';

// 1) GET 등 다른 요청이라면, 현재는 단순 JSON 출력 (원하시면 로직 조정 가능)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // 파일이 존재하면 내용 출력
    if (file_exists($filePath)) {
        $json_data = file_get_contents($filePath);
        echo $json_data;
    } else {
        echo json_encode([]);
    }
    exit;
}

// 2) POST 요청 처리
// 폼 데이터 가져오기
$userName      = trim($_POST['userName'] ?? '');
$userEmail     = filter_var(trim($_POST['userEmail'] ?? ''), FILTER_SANITIZE_EMAIL);
$userPhone     = trim($_POST['userPhone'] ?? '');

// 체크박스 배열
$childAge      = $_POST['childAge']      ?? [];
$childGender   = $_POST['childGender']   ?? [];
$growthConcern = $_POST['growthConcern'] ?? [];
$growthAttempt = $_POST['growthAttempt'] ?? [];
$growthPriority= $_POST['growthPriority']?? [];
$isDifficult   = $_POST['isDifficult']   ?? [];
$growthClose   = $_POST['growthClose']   ?? [];
$consentContent= $_POST['consentContent']?? [];
$contentType   = $_POST['contentType']   ?? [];

// 텍스트 영역
$customContent = trim($_POST['customContent'] ?? '');
$userMessage   = trim($_POST['userMessage']   ?? '');

// 개인정보 동의(checkbox)
$privacy       = $_POST['privacy']       ?? null;

// 3) 간단한 유효성 검사
// (필요 시 privacy 체크 등 추가)
if (empty($userName) || empty($userEmail) || empty($userMessage)) {
    http_response_code(400);
    echo json_encode(["message" => "필수 입력란이 비어 있습니다."]);
    exit;
}

// privacy 필드가 체크 안 되었다면(옵션)
// if ($privacy !== 'on') {
//     http_response_code(400);
//     echo json_encode(["message" => "개인정보 취급방침에 동의해 주세요."]);
//     exit;
// }

// 4) 현재 시간 (KST)
date_default_timezone_set('Asia/Seoul');
$timestamp = date('Y-m-d H:i:s');

// 5) 저장할 데이터 구조
$data = [
    'userName'      => $userName,
    'userEmail'     => $userEmail,
    'userPhone'     => $userPhone,
    'childAge'      => $childAge,
    'childGender'   => $childGender,
    'growthConcern' => $growthConcern,
    'growthAttempt' => $growthAttempt,
    'growthPriority'=> $growthPriority,
    'isDifficult'   => $isDifficult,
    'growthClose'   => $growthClose,
    'consentContent'=> $consentContent,
    'contentType'   => $contentType,
    'customContent' => $customContent,
    'userMessage'   => $userMessage,
    'privacy'       => $privacy,  // "on" 등으로 넘어옴
    'timestamp'     => $timestamp
];

// 6) 기존 데이터 가져오기
if (file_exists($filePath)) {
    $jsonData = file_get_contents($filePath);
    $contacts = json_decode($jsonData, true);
    if (!is_array($contacts)) {
        // 파일 형식이 깨졌다면, 새로 생성
        $contacts = [];
    }
} else {
    $contacts = [];
}

// 7) 새로운 데이터 추가
$contacts[] = $data;

// 8) JSON으로 저장
if (file_put_contents($filePath, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    http_response_code(500);
    echo json_encode(["message" => "데이터 저장 중 오류가 발생했습니다."]);
    exit;
}

// 9) 성공 응답
echo json_encode(["message" => "문의가 성공적으로 전송되었습니다."]);
exit;
?>
