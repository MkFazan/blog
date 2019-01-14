<?php

use App\User;

function getUserRoles(){
    return User::$userRoles;
}

function getNodes($categories, $prefix = ' - ')
{
    foreach ($categories as $category) {
        echo PHP_EOL . $prefix . ' ' . $category->name . '<br>';

        getNodes($category->children, $prefix . ' - ');
    }
}
