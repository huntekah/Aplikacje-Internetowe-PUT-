<?php
/**
 * Created by PhpStorm.
 * User: hunte
 * Date: 24/04/2017
 * Time: 14:07
 */

session_start();
$IMG = 4;
$db = new mysqli("localhost", "root", "", "inf122546");

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

$db->begin_transaction();
if ($result = $db->query("select * from product")) {


    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = array();
    }
    $basket = &$_SESSION['basket'];

    echo "<br>";
    echo "<div class='productList'>";
    echo "<table>";
    echo "<tr class='tableDesc'>";
    echo "<td>name</td>";
    echo "<td>description</td>";
    echo "<td>price</td><td></td></tr>";

    while ($row = $result->fetch_row()) {
        //output a row here

        $id = $row[0];
        $name = $row[1];
        $price = $row[2];
        $description = $row[3];
        $img = $row[$IMG];
        if (!in_array($id, $basket)) {
            echo "<tr class='active'><td>$name</td><td></td><td></td><td></td></tr>";
            echo "<tr class='rowHover active'>";
            echo "<td><img src=\"" . $img . "\" width=\"80\" height=\"80\"/></td>";
            echo "<td>$description</td>";
            echo "<td>$price</td>";
            echo "<td><button name='$name' value='$id' class='buyProduct'>Kup Teraz</button></td></tr>";
        } else {
            echo "<tr class='inactive'><td>$name</td><td></td><td></td><td></td></tr>";
            echo "<tr class='inactive'>";
            echo "<td><img src=\"" . $img . "\" width=\"80\" height=\"80\"/></td>";
            echo "<td>$description</td>";
            echo "<td>$price</td>";
            echo "<td><button name='$name' value='$id' class='removeProduct'>Wyjmij <br>z koszyka</button></td></tr>";
        }

    }
    echo "</table>";
    echo "</div>";
}
$db->commit();
$db->close();