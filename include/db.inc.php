<?php

/* try */
/* { */
  /* $pdo = new PDO('mysql:host=localhost;dbname=songs', 'pma', '123456'); */
  /* $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); */
  /* $pdo->exec('SET NAMES "utf8"'); */
/* } */
/* catch (PDOException $e) */
/* { */
/*   $error = 'Unable to connect to the database server.'; */
  /* header("Location: error.html"); */
  /* exit(); */
/* } */

$host = '127.0.0.1';
$db   = 'songs';
$user = 'pma';
$pass = '123456';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
