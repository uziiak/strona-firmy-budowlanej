<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "ąąą"; 


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}

// Sprawdzamy, czy formularz został wysłany metodą POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieramy dane z formularza i konwertujemy na int
    $godziny = (int)$_POST['godziny'];
    $kilometry = (int)$_POST['kilometry'];
    $pracownik = isset($_POST['pracownik']) ? true : false; // checkbox
    $liczba_uslug = isset($_POST['liczba_uslug']) ? (int)$_POST['liczba_uslug'] : 0;

    // Stałe ceny
    $cena_za_godzine = 100;
    $cena_za_km = 5;
    $cena_pracownika = 50;

    // Podstawowy koszt (czas + dojazd)
    $koszt = $godziny * $cena_za_godzine + $kilometry * $cena_za_km;

    // Jeśli wybrano pracownika, doliczamy koszt jego pracy
    if ($pracownik) {
        $koszt += $godziny * $cena_pracownika;
    }

    // Rabat 10% jeśli klient korzystał wcześniej więcej niż 3 razy
    if ($liczba_uslug > 3) {
        $koszt *= 0.9;
    }

    // Zaokrąglenie do dwóch miejsc po przecinku
    $koszt = round($koszt, 2);

    // Przygotowanie i wykonanie zapytania INSERT do bazy
    $stmt = $conn->prepare("INSERT INTO uslugi (godziny, kilometry, pracownik, liczba_uslug, koszt, data_zamowienia) VALUES (?, ?, ?, ?, ?, NOW())");
    $pracownik_int = $pracownik ? 1 : 0; // zamieniamy bool na 0/1 do bazy
    $stmt->bind_param("iiiid", $godziny, $kilometry, $pracownik_int, $liczba_uslug, $koszt); //i=integer (liczba całkowita), d=double (liczba zmiennoprzecinkowa)
    $stmt->execute();
    $stmt->close(); // zamykamy zapytanie
}

// Zamknięcie połączenia z bazą
$conn->close();

// Przekierowanie z powrotem do formularza z przekazaniem kosztu w URL
header("Location: kalkulator.html?koszt=" . urlencode($koszt));
exit();
?>
