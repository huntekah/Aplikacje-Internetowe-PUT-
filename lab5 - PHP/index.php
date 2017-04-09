<html>
<meta charset="utf-8"/>
<title>HunteShop</title>
<script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.buyProduct').click(function () {
            var clickBtnValue = $(this).val(),
                requestsUrl = 'requests.php',
                data = {'addProduct': clickBtnValue};
            $.post(requestsUrl, data, function (response) {
                window.location.reload(true);
                // alert("You clicked button" + clickBtnValue + " to buy sth");
            });
        });

        $('.removeProduct').click(function () {
            var clickBtnValue = $(this).val(),
                requestsUrl = 'requests.php',
                data = {'removeProduct': clickBtnValue};
            $.post(requestsUrl, data, function (response) {
                //alert(response);
                window.location.reload(true);
                //  alert("You clicked button" + clickBtnValue + " for removal");
            });
        });

        $('.buyBasket').click(function () {
            var requestsUrl = 'requests.php',
                data = {'buyBasket': 1};
            $.post(requestsUrl, data, function (response) {
                window.location.reload(true);
                if('price' in response) alert(response['price']);
                if('phantom' in response){
                    alert('you couldnt buy those products' + JSON.stringify(response['phantom']));
                }
            });
        });

        $('.clearBasket').click(function () {
            var requestsUrl = 'requests.php',
                data = {'clearBasket': 1};
            $.post(requestsUrl, data, function (response) {
                window.location.reload(true);
            });
        });

    });
</script>
<body>
<header>
    <img src=""/>
    <div class="title">HunteShop</div>
    <div class="menu menu-m menu-t">
        <a href="#"><img src="koszyk.png" width="40" height="40"></a>
    </div>
</header>
<button class="buyBasket">Kup</button>
<button class="clearBasket">wyfal</button>
<br>
<?php
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

    print_r($basket);
    echo "<br>";
    echo "<div class='productList'>";
    echo "<table>";
    echo "<tr>";
    echo "<td>nazwa</td>";
    echo "<td>opis</td>";
    echo "<td>cena</td></tr>";

    while ($row = $result->fetch_row()) {
        //output a row here

        $id = $row[0];
        $name = $row[1];
        $price = $row[2];
        $description = $row[3];
        $img = $row[$IMG];
        if (!in_array($id, $basket)) {
            echo "<tr class='active'><td>$name</td><td></td><td></td></tr>";
            echo "<tr class='active'>";
            echo "<td><img src=\"" . $img . "\" width=\"80\" height=\"80\"/></td>";
            echo "<td>$description</td>";
            echo "<td>$price</td>";
            echo "<td><button name='$name' value='$id' class='buyProduct'>Kup Teraz</button></td></tr>";
        } else {
            echo "<tr class='inactive'><td>$name</td><td></td><td></td></tr>";
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
?>

</body>
</html>