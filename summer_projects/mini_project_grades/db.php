<?php
$conn = new mysqli("localhost", "root", "", "mini_mroject_grades");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>