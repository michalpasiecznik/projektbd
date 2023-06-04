<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projektbd";

// Tworzenie połączenia z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzanie połączenia
if ($conn->connect_error) {
    die("Nieudane połączenie: " . $conn->connect_error);
}

// Funkcja do aktualizacji statusu zamówienia
function updateOrderStatus($conn, $orderId, $newStatus) {
    // Zabezpieczenie przed atakami SQL Injection
    $orderId = $conn->real_escape_string($orderId);
    $newStatus = $conn->real_escape_string($newStatus);

    // Wywołanie procedury MySQL
    $query = "CALL UpdateOrderStatus($orderId, '$newStatus')";
    $result = $conn->query($query);
    
    if ($result === TRUE) {
        echo "Status zamówienia został zaktualizowany.";
    } else {
        echo "Błąd podczas aktualizacji statusu zamówienia: " . $conn->error;
    }
}

// Sprawdzanie czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdzanie czy pola order_id i new_status zostały przesłane
    if (isset($_POST["order_id"]) && isset($_POST["new_status"])) {
        $orderId = $_POST["order_id"];
        $newStatus = $_POST["new_status"];
        
        // Wywołanie funkcji aktualizującej status zamówienia
        updateOrderStatus($conn, $orderId, $newStatus);
    }
}

// Zamykanie połączenia z bazą danych
$conn->close();
?>

