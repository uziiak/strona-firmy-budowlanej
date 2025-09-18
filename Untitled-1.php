<?php
$host = "localhost";
$username = "root";
$password = "password";
$databse = "guwnno";

$conn = new mysqli ($host, $username, $password, $databse);

if ($conn->conect_error){
    die("blad polaczenia" .$conn->connect_error);
}

$sql = "SELECT * FROM uczen";
$Result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<table border='1' cellpaadding='10'>";
        echo "<tr>
                <th>Imie</th>
                <th>Nazwisko</th>
                <th>Wiek</th>
                <th>Klasa</th>
            </tr>";


while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>" . $row["imie"] . "</td>
            <td>" . $row["nazwisko"] . "</td>
            <td>" . $row["wiek"] . "</td>
            <td>" . $row["klasa"] . "</td>
        </tr>";
}

echo "</table>";
} else {
    echo "Brak danych do wyświetlenia.";
}

$conn->close();
?>