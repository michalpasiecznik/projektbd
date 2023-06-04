<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektbd";

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie czy udało się połączyć
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie wybranej kategorii
$category = $_POST["category"];

// Zabezpieczenie przed SQL Injection
$category = $conn->real_escape_string($category);

// Wywołanie funkcji MySQL
$sql = "SELECT GetProductCountInCategory('$category') AS productCount";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $productCount = $row["productCount"];
    header("Location: index.html?productCount=" . urlencode($productCount));
} else {
    header("Location: index.html?productCount=0");
}

$conn->close();
?>

