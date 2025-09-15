<?php
include('config.php');
include('function.php');

if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}
?>
