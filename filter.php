<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Used Car Sales Information</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>중고차 판매 정보 검색</h2>
    <form method="post">
        <label for="brand">브랜드:</label>
        <input type="text" id="brand" name="brand">
        <input type="submit" value="검색">
    </form>

    <?php
    $host = "192.168.56.3";
    $port = 4567;
    $user = "root";
    $password = "1234";
    $database = "USEDCARSALE";
    $con = mysqli_connect($host, $user, $password, $database, $port) or die("MySQL 접속 실패!!");

    $brand = isset($_POST['brand']) ? $_POST['brand'] : '';

    $sql = "SELECT Car.Brand, Car.Model, Dealer.Name AS DealerName, Dealership.Name AS DealershipName
            FROM Sells
            JOIN Car ON Sells.VehicleID = Car.VehicleID
            JOIN Dealer ON Sells.Dealernumber = Dealer.Dealernumber
            JOIN Dealership ON Dealer.Dealershipnumber = Dealership.Dealershipnumber";

    if (!empty($brand)) {
        $sql .= " WHERE Car.Brand LIKE '%" . mysqli_real_escape_string($con, $brand) . "%'";
    }

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<h1>차량 판매 정보</h1>";
        echo "<table>";
        echo "<tr><th>Brand</th><th>Model</th><th>Dealer Name</th><th>Dealership Name</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Brand'] . "</td>";
            echo "<td>" . $row['Model'] . "</td>";
            echo "<td>" . $row['DealerName'] . "</td>";
            echo "<td>" . $row['DealershipName'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "데이터 조회 실패!!!" . "<br>";
        echo "실패 원인: " . mysqli_error($con);
    }

    mysqli_close($con);
    ?>
</body>
</html>
