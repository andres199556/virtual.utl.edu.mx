<?php
session_name("session_sicoin");
session_start();
if($_SESSION["sesion_activa"] == "SI"){
    //la sesión esta creada, por lo tanto la destruyo
    session_destroy();
}
else{
    
}
header("Location:../mlogin/index.php");
?>