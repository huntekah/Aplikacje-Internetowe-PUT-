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

if (isset($_POST['removeProduct'])) {
    removeFromBasket((int)$_POST['removeProduct']);
}

if (isset($_POST['buyBasket'])) {
    buyBasket();
}

if (isset($_POST['clearBasket'])) {
    clearBasket();
}


function addToBasket($id)
{
    $_SESSION['basket'][] = $id;
    exit;
}

function removeFromBasket($id)
{
    $array = &$_SESSION['basket'];
    array_splice($array, array_search($id, $array), 1);
    //$_SESSION['basket'] = array_diff($_SERVER['basket'],array($id));
    exit;
}

//function buyBasket()
//{
//    $totalCost = 0;
//    $basket = &$_SESSION['basket'];
//    $db = new mysqli("localhost", "root", "", "inf122546");
//    if ($db->connect_errno) {
//        printf("Connect failed: %s\n", $db->connect_error);
//        exit();
//    }
//    $db->begin_transaction();
//
//    if ($result = $db->query("select ID, name, price from product")) {
//        while ($row = $result->fetch_row()) {
//
//            $id = $row[0];
//            $price = $row[2];
//
//            if (array_search($id, $basket)) {
//                if ($db->query("DELETE FROM product WHERE ID = " . $id)) {
//                    array_splice($basket, array_search($id, $basket), 1);
//                    $totalCost += $price;
//                } else {
//                    echo "There was an unexpected error while deleting an object with id = " . $id;
//                }
//            }
//
//        }
//        $phantom_items = array();
//        if (sizeof($basket) > 0) {
//            $phantom_items['phantom'] = array(); // wierd, i know.
//            foreach($basket as $itemID){
//                $phantom_items['phantom'][] = $itemID;
//            }
//        }
//        return (array_merge($phantom_items,array('price' => $totalCost));
//
//    }
//
//    exit;
//}

function clearBasket()
{
    $_SESSION['basket'] = array();
    exit;
}


?>