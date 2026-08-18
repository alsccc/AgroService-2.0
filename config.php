<?php

$servername = "192.168.56.102"; //Conexão com banco de dados. Ela se conecta ao endereço IP 192.168.56.102,//
$username = "root";
$password = "";
$dbname = "agroserviceBD";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

?>