<?php
set_time_limit(0); // per tenerlo attivo senza timeout
require_once 'database/connessione.php';

$id_percorso = 1; // oppure $_GET['id_percorso']

// Prendi le fermate del percorso in ordine
$sql = "SELECT f.lat, f.lon 
        FROM fermate f
        JOIN fermate_percorso fp ON f.id_fermata = fp.id_fermata
        WHERE fp.id_percorso = $id_percorso
        ORDER BY fp.ordine";
$result = $connessione->query($sql);

$fermate = [];
while ($row = $result->fetch_assoc()) {
    $fermate[] = ['lat' => $row['lat'], 'lon' => $row['lon']];
}

// Se non ci sono abbastanza fermate, blocca tutto
if (count($fermate) < 2) {
    die("Errore: percorso con meno di 2 fermate.");
}

// Funzione per generare punti intermedi tra due coordinate
function interpolate($start, $end, $steps) {
    $points = [];
    for ($i = 0; $i <= $steps; $i++) {
        $lat = $start['lat'] + ($end['lat'] - $start['lat']) * ($i / $steps);
        $lon = $start['lon'] + ($end['lon'] - $start['lon']) * ($i / $steps);
        $points[] = ['lat' => $lat, 'lon' => $lon];
    }
    return $points;
}

// Crea la lista completa del percorso con interpolazioni
$percorso_completo = [];
$steps_per_segment = 20; // Più alto = più fluido, ma più lento

for ($i = 0; $i < count($fermate) - 1; $i++) {
    $segment = interpolate($fermate[$i], $fermate[$i + 1], $steps_per_segment);
    array_pop($segment); // evita duplicati tra segmenti
    $percorso_completo = array_merge($percorso_completo, $segment);
}

// aggiungi l'ultima fermata
$percorso_completo[] = end($fermate);

// Loop infinito: il bus gira in ciclo
while (true) {
    foreach ($percorso_completo as $punto) {
        $lat = $punto['lat'];
        $lon = $punto['lon'];

        // Cancella vecchie posizioni per questo percorso (facoltativo)
        $connessione->query("DELETE FROM posizione_bus WHERE id_percorso = $id_percorso");

        // Inserisci nuova posizione
        $stmt = $connessione->prepare("INSERT INTO posizione_bus (id_percorso, lat, lon) VALUES (?, ?, ?)");
        $stmt->bind_param("idd", $id_percorso, $lat, $lon);
        $stmt->execute();
        $stmt->close();

        echo "<script> console.log('salvatoooo') </script>";

        // Aspetta 1.5 secondi prima del prossimo passo
        usleep(1500000);
    }

    echo "🔁 Restarting route...\n";
}
?>
