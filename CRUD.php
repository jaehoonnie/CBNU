<?php
// 데이터베이스 설정
$host = "192.168.56.3";
$port = 4567;
$user = "root";
$password = "1234";
$database = "USEDCARSALE";

// mysqli 연결
$con = mysqli_connect($host, $user, $password, $database, $port) or die("MySQL 접속 실패!!");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // VehicleID 받아오기
    $vehicleID = isset($_POST['vehicleID']) ? $_POST['vehicleID'] : '';

    // VehicleID 입력이 있을 경우만 처리
    if (!empty($vehicleID)) {
        // SQL 인젝션 방지를 위한 VehicleID 이스케이프
        $vehicleID = mysqli_real_escape_string($con, $vehicleID);

        // DELETE 쿼리 작성
        $sql = "DELETE FROM Car WHERE VehicleID = '$vehicleID'";

        // 쿼리 실행
        if (mysqli_query($con, $sql)) {
            echo "차량이 성공적으로 삭제되었습니다.";
        } else {
            echo "차량 삭제 에러: " . mysqli_error($con);
        }
    } else {
        echo "VehicleID를 입력해주세요.";
    }
}

// 연결 종료
mysqli_close($con);

// 삭제 후 메인 페이지로 리다이렉트
header("Location: index.php");
exit();
?>
