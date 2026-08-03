<?php
$conn = new mysqli("localhost", "root", "", "gestion_devoirs_primaires");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>