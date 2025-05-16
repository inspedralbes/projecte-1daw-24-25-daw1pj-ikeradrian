<?php
function rellenarMongo($collection, $name, $hora, $ip,$pages) {
    $collection->insertOne([
    'Usuari' => $name,
    'Data' => $hora,
    'ip_origen' => $ip,
    'pagina visitada' => $pages
]);  
}
?>