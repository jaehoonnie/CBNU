<?php
$host = "192.168.56.3";
$port = 4567;
$user = "root";
$password = "1234";
$database = "USEDCARSALE";
$con = mysqli_connect($host, $user, $password, $database, $port) or die("MySQL 접속 실패!!");

// 차량, 딜러, 딜러십 정보를 조합하는 SQL 쿼리
$sql = "SELECT Car.Brand, Car.Model, Dealer.Name AS DealerName, Dealership.Name AS DealershipName
        FROM Sells
        JOIN Car ON Sells.VehicleID = Car.VehicleID
        JOIN Dealer ON Sells.Dealernumber = Dealer.Dealernumber
        JOIN Dealership ON Dealer.Dealershipnumber = Dealership.Dealershipnumber";

$result = mysqli_query($con, $sql);

if ($result) {
    echo "<h1>차량 판매 정보</h1>";
    echo "<table border='1'>";
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
