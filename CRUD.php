<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Used Car Sales Management System</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>중고차 판매 관리 시스템</h2>
    
    <!-- 차량 데이터 추가 폼 -->
    <h3>차량 데이터 추가</h3>
    <form method="post" action="add_car.php">
        <!-- 입력 필드들 (VehicleID, Brand 등) -->
        <!-- ... -->
        <input type="submit" value="차량 추가">
    </form>
    
    <!-- 차량 데이터 삭제 폼 -->
    <h3>차량 데이터 삭제</h3>
    <form method="post" action="delete_car.php">
        <label for="vehicleID">VehicleID:</label>
        <input type="text" id="vehicleID" name="vehicleID">
        <input type="submit" value="차량 삭제">
    </form>
    
    <!-- 차량 데이터 조회 폼 -->
    <h3>차량 데이터 검색</h3>
    <form method="post">
        <label for="searchBrand">브랜드:</label>
        <input type="text" id="searchBrand" name="searchBrand">
        <label for="searchModel">모델:</label>
        <input type="text" id="searchModel" name="searchModel">
        <input type="submit" value="검색">
    </form>

    <!-- PHP 코드: 차량 데이터 조회 및 필터링 -->
    <?php
    $host = "192.168.56.3";
    $port = 4567;
    $user = "root";
    $password = "1234";
    $database = "USEDCARSALE";
    
    // mysqli 연결
    $con = mysqli_connect($host, $user, $password, $database, $port) or die("MySQL 접속 실패!!");

    $searchBrand = isset($_POST['searchBrand']) ? $_POST['searchBrand'] : '';
    $searchModel = isset($_POST['searchModel']) ? $_POST['searchModel'] : '';

    // 기본 SQL 쿼리
    $sql = "SELECT Car.VehicleID, Car.Brand, Car.Model, Car.Model_Spec, Car.Year, Car.Mileage, Car.Price, Dealer.Dealernumber, Dealer.Name AS DealerName, Dealership.Name AS DealershipName
            FROM Car
            JOIN Dealer ON Car.Dealernumber = Dealer.Dealernumber
            JOIN Dealership ON Dealer.Dealershipnumber = Dealership.Dealershipnumber";

    // 필터링 조건 추가
    $conditions = [];
    if (!empty($searchBrand)) {
        $conditions[] = "Car.Brand LIKE '%" . mysqli_real_escape_string($con, $searchBrand) . "%'";
    }
    if (!empty($searchModel)) {
        $conditions[] = "Car.Model LIKE '%" . mysqli_real_escape_string($con, $searchModel) . "%'";
    }
    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // 쿼리 실행
    $result = mysqli_query($con, $sql);

    if ($result) {
        // 결과 표시
        echo "<h3>차량 목록</h3>";
        echo "<table>";
        echo "<tr><th>VehicleID</th><th>Brand</th><th>Model</th><th>Model Spec</th><th>Year</th><th>Mileage</th><th>Price</th><th>Dealer Number</th><th>Dealer Name</th><th>Dealership Name</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['VehicleID'] . "</td>";
            echo "<td>" . $row['Brand'] . "</td>";
            echo "<td>" . $row['Model'] . "</td>";
            echo "<td>" . $row['Model_Spec'] . "</td>";
            echo "<td>" . $row['Year'] . "</td>";
            echo "<td>" . $row['Mileage'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            echo "<td>" . $row['Dealernumber'] . "</td>";
            echo "<td>" . $row['DealerName'] . "</td>";
            echo "<td>" . $row['DealershipName'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>데이터 조회 실패: " . mysqli_error($con) . "</p>";
    }

    // 연결 종료
    mysqli_close($con);
    ?>
</body>
</html>
