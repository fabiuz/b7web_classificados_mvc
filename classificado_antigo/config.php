<?php
  session_start();
  global $pdo;
  try{
    $pdo = new PDO("mysql:dbname=classificados;host=127.0.0.1", "root", "root");
  }catch(PDOException $e){
    echo "Falhou: ". $e->getMessage();
  }
 ?>
