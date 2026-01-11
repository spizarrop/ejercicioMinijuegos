<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?= $datos['nombre'] ?></title>
    </head>
    <body>
        <h1>Estás en: <?= $datos['nombre'] ?></h1>
        <p>URL del juego: /games/<?= $datos['url'] ?></p>
        <div style="margin-top: 20px;">
            <button onclick="alert('Iniciando juego...')">JUGAR</button>
            <a href="index.php?c=Minijuego&m=listarJuegos"><button>VOLVER</button></a>
        </div>
    </body>
</html>