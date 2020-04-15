
function loadXMLDoc()
{
var xmlhttp;

var n=document.getElementById('bus').value;

if(n==''){
document.getElementById("myDiv").innerHTML="";
return;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","proc1.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}

function findProveedor(idCatProd) {
    let q = document.getElementById("busProv").value;
    $.ajax({
        url: '../includes/controladorCompras.php',
        type: 'POST',
        data: {
            "action": 'findProveedor',
            "q": q,
        },
        dataType: 'html',
        success: function (provList) {
            $("#myDiv").val(nitValid);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}