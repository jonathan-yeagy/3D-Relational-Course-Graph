<?php

include("../includes/dbConnect.php");

$query = $_GET["term"];

$sql = "SELECT * FROM Major WHERE majorTitle LIKE '%$query%' OR majorCode LIKE '%$query%'";
$results = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($results)) {
    $data[] = array($row["majorCode"] . " - " . $row["majorTitle"], $row["idMajor"]);
}

echo json_encode($data);
?>