<?php

function echoOptions($arr){
    foreach ($arr as $i => $value) {
        echo "<option value='$value'>$value</option>";
    }
}