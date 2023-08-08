<?php
require_once('../general_functions/connection.php');
$conn = get_connection();

$t = $_GET['t'];

$colnames = array();

$sql = "SHOW COLUMNS FROM $t";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
    array_push($colnames, $row['Field']);
}

$sql = "SELECT * FROM $t";
$result = $conn->query($sql);
echo "<h3>$t table</h3>";
echo "<table border = '1'><tr>";
foreach ($colnames as $c) {
    echo "<th>$c</th>";
}
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($colnames as $c) {
        echo "<td>";
        echo $row[$c];
        echo "</td>";
    }
    echo "</tr>";
}
echo "</tr>";
echo "</table>";
?>