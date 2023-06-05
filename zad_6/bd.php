<?php
    function db() {
        $user='u52886';
        $pass='2557509';
        return new PDO ("mysql:host=localhost;dbname=u52886", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
?>
