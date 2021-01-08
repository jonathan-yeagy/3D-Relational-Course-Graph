<?php

include("../includes/dbConnect.php");

$query = $_GET["term"];

$sql = "SELECT * FROM Course WHERE courseTitle LIKE '%$query%' OR courseCode LIKE '%$query%'";
$results = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($results)) {
    $data[] = array($row["courseCode"] . " - " . $row["courseTitle"], $row["idCourse"]);
}

echo json_encode($data);
?>