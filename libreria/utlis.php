<?php

function mostrarTabla($filas): void{

if (empty($filas)) {
    echo "No hay datos para ser mostrados";
} 
    echo "<table border='1'>";
    echo "<thead><tr>";
    $fila = $filas[0];
    foreach ($fila as $columna => $valor) {
        echo "<th>$columna</th>";
    }
    echo "</tr></thead>";
    echo "</tbody>";
    foreach ($filas as $fila) {
        echo "<tr>";
        foreach ($fila as $columna => $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
