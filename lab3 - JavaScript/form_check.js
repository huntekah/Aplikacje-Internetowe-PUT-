// JavaScript source code
function isWhiteSpace(str) {
    var ws = "\t\n\r ";
    if (str == undefined) return true;
    for (var i = 0; i < str.length; i++) {
        var c = str.charAt(i);
        if (ws.indexOf(c) == -1) {
            return false;
        }
    }
    return true;
}

function isEmpty(text) {
    if (text == undefined) return true;
    return !text.length || isWhiteSpace(text);
}

function checkString(obj) {
    var str = obj.value;
    if (isWhiteSpace(str) || isEmpty(str)) {
        return false;
    }
    else {
        return true;
    }
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
    document.getElementById(e).style.display = 'table-row';
}
function hideElement(e) {
    document.getElementById(e).style.visibility = 'hidden';
    document.getElementById(e).style.display = 'none';
}


function checkStringAndFocus(obj, msg) {
    var str = obj.value;
    var errorFieldName = "e_" + obj.name.substr(2, obj.name.length);
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

function checkZIPCodeRegEx() {
    var ZipCode = /[0-9]{2}\-+[0-9]{3}/;
    var str = document.getElementsByName("f_kod")[0].value;
    var element = document.getElementById("kod");
    if (ZipCode.test(str)) {
        element.innerHTML = "OK";
        element.className = "green";
        return false;
    }
    else {
        element.innerHTML = "Źle";
        element.className = "red";
        if (str == undefined) {
            startTimer("kod");
            return true;
        }
        if (str.length == 0)
            startTimer("kod");
        return true;
    }
}


function validate(form) {
    alterRows(1, (document.getElementsByTagName("TR"))[0]);
    ret = true;
    //var elements = form.getElementById("dane_osobowe").elements;
    for (var element in form) {
        //console.log(form[element].name);
        if (form[element] != undefined){
            if (form[element].tagName == "INPUT" && form[element].type === "text" && checkString(form[element]) == false) {
              //  var msg = toString(checkString(form[element])) + form[element].value;
                //alert(msg);
                form[element].className = "wrong";
        }
        else form[element].className = "clear_wrong";}
    }

    ret = ret && checkStringAndFocus(form.elements["f_imie"], "Podaj Imie");

    ret = ret && !checkZIPCodeRegEx();

    //ret = checkString(form.elements["f_imie"].value, "Podaj imię");
    ret = ret && checkString(form.elements["f_nazwisko"].value, "Podaj nazwisko");
    ret = ret && checkString(form.elements["f_kod"].value, "Podaj kod");
    ret = ret && checkString(form.elements["f_ulica"].value, "Podaj ulicę");
    ret = ret && checkString(form.elements["f_miasto"].value, "Podaj miasto");

    ret = ret && checkEmailRegEx(form.elements["f_email"].value);

    return ret;
}

function alterRows(i, e) {
    if (e) {
        if (i % 2 == 1) {
            e.setAttribute("style", "background-color: Aqua;");
        }
        e = e.nextSibling;
        while (e && e.nodeType != 1) {
            e = e.nextSibling;
        }
        alterRows(++i, e);
    }
}

function nextNode(e) {
    while (e && e.nodeType != 1) {
        e = e.nextSibling;
    }
    return e;
}
function prevNode(e) {
    while (e && e.nodeType != 1) {
        e = e.previousSibling;
    }
    return e;
}

function swapRows(b) {
    var tab = prevNode(b.previousSibling);
    var tBody = nextNode(tab.firstChild);
    var lastNode = prevNode(tBody.lastChild);
    tBody.removeChild(lastNode);
    var firstNode = nextNode(tBody.firstChild);
    tBody.insertBefore(lastNode, firstNode);
    return false;
}

function zamien() {
    swapRows(document.querySelector("tbody tr"));
}

function cnt(form, msg, maxSize) {
    if (form.value.length > maxSize)
        form.value = form.value.substring(0, maxSize);
    else
        msg.innerHTML = maxSize - form.value.length;
}