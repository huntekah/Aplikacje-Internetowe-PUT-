<?php
/**
 * Created by PhpStorm.
 * User: hunte
 * Date: 06/04/2017
 * Time: 19:56
 */

session_start();

if (isset($_POST['addProduct'])) {
    addToBasket((int)$_POST['addProduct']);
}

function addToBasket($id)
{
    //$name = substr($_POST['addProduct'], 0, 6);
    //$id = (int)substr($_POST['addProduct'], 6);
    // add to global array of products and prepare for deletion.
    $_SESSION['basket'][] = $id; // dodaje id do listy do listy
    exit;
}

function insert()
{
    echo "The insert function is called.";
    exit;
}

?>