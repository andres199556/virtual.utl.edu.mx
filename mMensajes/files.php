<?php
print_r($_POST);
print_r($_FILES);
foreach($_FILES as $file){
    print_r($file);
}
?>