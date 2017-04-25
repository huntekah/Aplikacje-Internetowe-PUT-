<?php
/**
 * Created by PhpStorm.
 * User: hunte
 * Date: 06/04/2017
 * Time: 19:56
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL);
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

if (isset ($_POST['moreProducts'])){
    moreProducts();
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

function buyBasket()
{
    $totalCost = 0;
    $basket = &$_SESSION['basket'];
    $db = new mysqli("localhost", "root", "", "inf122546");
    if ($db->connect_errno) {
        printf("Connect failed: %s\n", $db->connect_error);
        exit();
    }
    $db->begin_transaction();

    if ($result = $db->query("select ID, name, price from product")) {
        while ($row = $result->fetch_row()) {

            $id = $row[0];
            $name = $row[1];
            $price = $row[2];

            if (in_array($id, $basket)) {
                //debug_to_console($basket);
                $query = "DELETE FROM product WHERE ID = " . $id ;
                if ($db->query($query) === true) {
                    if(($key = array_search($id, $basket)) !== false) {
                      //  debug_to_console($id);
                        unset($basket[$key]);
                    }
//                    array_splice($basket, array_search($id, $basket), 1);
                    $totalCost += $price;
                    echo "You bought \"".$name."\"\n";
                } else {
                    //echo "There was an unexpected error while deleting an object with id = " . $id;
                    echo "Someone bought \"".$name."\" already\n";
                }
            }

        }
        $phantom_items = array();
        if (sizeof($basket) > 0) {
            $phantom_items['phantom'] = array(); // wierd, i know.
            foreach($basket as $itemID){
                $phantom_items['phantom'][] = $itemID;
            }
        }
        echo "\n\n Price: ".$totalCost."\n";
        $db->commit();
        $db->close();
        return (array_merge($phantom_items,array('price' => $totalCost)));

    }
    echo "I couldn't query the database!";
    $db->commit();
    $db->close();
    return array('error' => 'something Went Wrong');
}

function clearBasket()
{
    $_SESSION['basket'] = array();
    exit;
}

function moreProducts(){
    $db = new mysqli("localhost", "root", "", "inf122546");
    if ($db->connect_errno) {
        printf("Connect failed: %s\n", $db->connect_error);
        exit();
    }
    $db->begin_transaction();

    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Lizak', '4.70', 'Truskawkowy Lizaczek', 'lizak.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Mak', '9001', 'Super MacBook', 'MacBook.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Dell XPS 13', '4990', 'Laptop for Business', 'XPS13.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'House', '300000', 'Luixurious house for a nice family', 'house.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Love', '0', 'There are things that have no price', 'love.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Hanger', '6,67', 'Its good for your jacket', 'hanger.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Choker', '69', 'Something you\'d look sexy in', 'choker.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Nothing', '9001', 'You will pay for nothing', 'nothing.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'Something', '13', 'Surprise for you!', 'surprise.jpg');";
    $queries[] = "INSERT INTO `product` (`name`, `price`, `desc`, `img`) VALUES ( 'You', '1', 'You should know best what to expect of this product', 'you.jpg');";

    foreach( $queries as $query) {
        if ($result = $db->query($query)) {

            echo $query . "\n";
        } else {
            echo "I couldn't query" . $query;

        }
    }
        $db->commit();
        $db->close();

    return true;

}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>