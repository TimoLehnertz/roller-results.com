<?php

include_once "api/userAPI.php";

if(!isLoggedIn()){
    tryRememberMeLogin();
}