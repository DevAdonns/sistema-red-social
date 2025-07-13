<?php

$conn= new mysqli("localhost","platzilla","software","prueba_platzilla");
if(mysqli_connect_error()){
    echo "conection failed";
}else{
    return $conn;
}

?>