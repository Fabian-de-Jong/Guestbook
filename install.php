<?php 
$configs = include('config.php');

// Create connection
$conn = new mysqli($configs['host'], $configs['username'], $configs['password']);
// Check connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS " . $configs['database'];
if (!$conn->query($sql) === TRUE) {
  echo 'Error creating database: ' . $conn->error;
}
$conn->close();

// Create connection
$conn = new mysqli(configs['host'], $configs['username'], $configs['password'], $configs['database']);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table

$sql = "CREATE TABLE guestbook (
  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  text varchar(256) NOT NULL,
  date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)";


if ($conn->query($sql) === TRUE) {
  echo "Table guestbook created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}