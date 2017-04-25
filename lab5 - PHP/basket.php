<html>
<meta charset="utf-8"/>
<script type="text/javascript" src="shop_scripts.js"></script>
</html>

<?php
session_start();
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

    echo "<table>";
        echo "<tr>";

$overall_price = 0;
        while ($row = $result->fetch_row()) {
        //output a row here
        $id = $row[0];
        $name = $row[1];
        $price = $row[2];
        if (in_array($id, $basket)) {
            echo "<tr ><td>$name</td><td align = \"right\">$price</td></tr>";
            $overall_price += $price;
        }

        }
    echo "<tr class='lastRow' ><td>Overall price </td><td align = \"right\">$overall_price</td></tr>";
        echo "</table>";
        echo "<button class=\"buyBasket\">Kup</button>";
        echo "<button class=\"clearBasket\">Wyrzuc</button>";
//    echo "</div>";
}
$db->commit();
$db->close();
