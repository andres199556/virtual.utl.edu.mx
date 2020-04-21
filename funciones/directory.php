<?php
 function delete_dir($carpeta)
    {
      foreach(glob($carpeta . "/*") as $archivos_carpeta){
        if (is_dir($archivos_carpeta)){
          delete_dir($archivos_carpeta);
        } else {
        unlink($archivos_carpeta);
        }
      }
      rmdir($carpeta);
     }
?>