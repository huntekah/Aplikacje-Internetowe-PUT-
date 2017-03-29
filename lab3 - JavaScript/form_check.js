// JavaScript source code
function isWhiteSpace(str) {
    var ws = "\t\n\r ";
    for (var i = 0; i < str.length; i++) {
        var c = str.charAt(i);
        if (ws.indexOf(c) == -1) {
            return false;
        }
    }
    return true;
}

function isEmpty(text) {
    return !text.length || isWhiteSpace(text);
}

function checkString(text, message) {

    //if (typeof checkString.ret == 'undefined') {
    //    // It has not... perform the initialization
    //    checkString.ret = true;
    //}
    //alert(checkString.ret);
    if (isEmpty(text) && checkString.ret) {
        alert(message);
        checkString.ret = false;
        return false;
    }
    return true;
}

function checkEmail(str) {
    if (isWhiteSpace(str)) {
        alert("Podaj właściwy e-mail");
        return false;
    }
    else {
        var at = str.indexOf("@");
        if (at < 1) {
            alert("Nieprawidłowy e-mail");
            return false;
        }
        else {
            var l = -1;
            for (var i = 0; i < str.length; i++) {
                var c = str.charAt(i);
                if (c == ".") {
                    l = i;
                }
            }
            if ((l < (at + 2)) || (l == str.length - 1)) {
                alert("Nieprawidłowy e-mail");
                return false;
            }
        }
        return true;
    }
}

var errorField = "";

function startTimer(fName) {
    errorField = fName;
    window.setTimeout("clearError(errorField)", 5000);
}
function clearError(objName) {
    document.getElementById(objName).innerHTML = "";
}

function showElement(e) {
    document.getElementById(e).style.visibility = 'visible';
}
function hideElement(e) {
    document.getElementById(e).style.visibility = 'hidden';
}

function checkStringAndFocus(obj, msg) {
    var str = obj.value;
    var errorFieldName = "e_" + obj.name.substr(2, obj.name.length);
    alert(errorFieldName);
    if (isWhiteSpace(str) || isEmpty(str)) {
        document.getElementById(errorFieldName).innerHTML = msg;
        obj.focus();
        startTimer(errorFieldName);
        return false;
    }
    else {
        return true;
    }
}
function checkEmailRegEx(str) {
    var email = /[a-zA-Z_0-9\.]+@[a-zA-Z_0-9\.]+\.[a-zA-Z][a-zA-Z]+/;
    if (email.test(str))
        return true;
    else {
        alert("Podaj właściwy e-mail");
        return false;
    }
}

function validate(form) {
    //checkString.ret = true;
    ret = ret && checkStringAndFocus(form.elements["f_imie"], "Podaj Imie");
    //ret = checkString(form.elements["f_imie"].value, "Podaj imię");
    //ret = ret && checkString(form.elements["f_nazwisko"].value, "Podaj nazwisko");
    //ret = ret && checkString(form.elements["f_kod"].value, "Podaj kod");
    //ret = ret && checkString(form.elements["f_ulica"].value, "Podaj ulicę");
    //ret = ret && checkString(form.elements["f_miasto"].value, "Podaj miasto");

    ret = ret && checkEmailRegEx(form.elements["f_email"].value);

    return ret;
}