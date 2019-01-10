<?php

use App\User;

function getUserRoles(){
    return User::$userRoles;
}
