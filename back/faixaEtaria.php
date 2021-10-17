<?php

if($idade <= 12){
    $etaria = "Criança";
}elseif($idade >= 13 AND $idade < 19){
    $etaria = "Jovem";
}elseif($idade > 19 AND $idade <= 59){
    $etaria = "Adulto";
}else{
    $etaria = "Idoso";
}

?>