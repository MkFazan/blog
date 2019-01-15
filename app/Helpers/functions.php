<?php

use App\User;

const STATUS_DISABLED = 0;
const STATUS_ACTIVE = 1;

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


function getNodesSelect($categories, $prefix = ' - ', $selected)
{
    foreach ($categories as $category) {
        if (in_array($category->id, $selected)){
            echo "<option value='$category->id' selected>";
        }else{
            echo "<option value='$category->id'>";
        }
        echo PHP_EOL . $prefix . ' ' . $category->name . '<br>';
        echo "</option>";

        getNodesSelect($category->children, $prefix . ' - ', $selected);
    }
}
