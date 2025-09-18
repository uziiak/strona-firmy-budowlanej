<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db = "ąąą";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $conn->real_escape_string($_POST['imie']);
    $email = $conn->real_escape_string($_POST['email']);
    $wiadomosc = $conn->real_escape_string($_POST['wiadomosc']); // Używamy real_escape_string, aby zabezpieczyć przed SQL Injection

    $sql = "INSERT INTO wiadomosci (imie, email, wiadomosc)
            VALUES ('$imie', '$email', '$wiadomosc')";

    if ($conn->query($sql) === TRUE) {
        echo "Wiadomość została zapisana.";
    } else {
        echo "Błąd: " . $conn->error;
    }

    $conn->close();
}
?>
