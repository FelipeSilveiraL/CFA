<?php
    if ($idade <= 3) {
        $etaria = "Baybs";
    } elseif ($idade >= 4 and $idade <= 9) {
        $etaria = "Kids";
    } elseif ($idade >= 10 and $idade <= 13) {
        $etaria = "Juvenis";
    } elseif($idade >= 14 AND $idade < 19){
        $etaria = "Jovem";
    }elseif($idade > 19 AND $idade <= 59){
        $etaria = "Adulto";
    }else{
        $etaria = "Idoso";
    }
?>