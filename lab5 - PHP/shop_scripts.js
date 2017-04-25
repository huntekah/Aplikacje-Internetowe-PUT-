/**
 * Created by hunte on 24/04/2017.
 */
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

    showBasket = function () {
        $('#basketContent').load($(this).attr('href'));
        $('#basketContent').css("display", "block");
        return false;
    };

    hideBasket = function(){
        $('#basketContent').css("display", "none");
        return false;
    };

    $('.basketImage').mouseover(showBasket);
    $('#basketContent').mouseover(showBasket);


    $('.basketImage').mouseout(hideBasket);
    $('#basketContent').mouseout(hideBasket);

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
            alert(response);
          //  if('price' in response) alert(response['price']);
          //  if('phantom' in response){
          //      alert('you couldnt buy those products' + JSON.stringify(response['phantom']));
          //  }
            window.location.reload(true);
        });
    });

    $('.clearBasket').click(function () {
        var requestsUrl = 'requests.php',
            data = {'clearBasket': 1};
        $.post(requestsUrl, data, function (response) {
            window.location.reload(true);
        });
    });

    $('.moreProducts').click(function () {
        var requestsUrl = 'requests.php',
            data = {'moreProducts': 1};
        $.post(requestsUrl, data, function (response) {
            alert(response);
            window.location.reload(true);
        });
    });

});