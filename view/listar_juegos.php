<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Minijuegos</title>
    </head>
    <body>
        <h2>Historial de Juegos Recientes (Últimos 3)</h2>
        <ul>
            <?php
                if (!empty($datos['recientes'])){
                    foreach ($datos['recientes'] as $reciente){
                        echo "<li><strong>".$reciente['nombre']."</strong></li>";
                    }
                } else{
                    echo "<p>No has visitado juegos todavía.</p>";
                }
            ?>
        </ul>
        <hr>
        <h2>Todos los Minijuegos</h2>
        <?php
            foreach ($datos['todos'] as $fila) {
                echo "<label>".$fila['nombre']."</label>";
                echo " <a href='index.php?c=Minijuego&m=ver&idMinijuego=".$fila['idMinijuego']."'>Seleccionar</a>";
                echo "<br>";
            }
        ?>
    </body>
</html>