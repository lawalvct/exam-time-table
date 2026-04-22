<?php
$pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
$pdo->exec('CREATE DATABASE IF NOT EXISTS `exam-time-db`');
echo "Database created successfully.\n";
