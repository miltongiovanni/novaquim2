
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
            $("#myDiv").html(provList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}