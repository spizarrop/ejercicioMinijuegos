CREATE TABLE minijuegos (
    idMinijuego INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL
);

INSERT INTO minijuegos (nombre, url) VALUES 
('Ajedrez Online', 'ajedrez'),
('Tetris Clásico', 'tetris'),
('Snake Retro', 'snake'),
('Pac-Man', 'pacman'),
('Buscaminas', 'buscaminas'),
('Sudoku Daily', 'sudoku'),
('2048 Puzzle', '2048'),
('Flappy Bird', 'flappy'),
('Sonic Runner', 'sonic'),
('Mario Bros HTML5', 'mario');