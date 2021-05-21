
function findCliente() {
    let q = document.getElementById("busClien").value;
    $.ajax({
        url: '../includes/controladorVentas.php',
        type: 'POST',
        data: {
            "action": 'findCliente',
            "q": q,
        },
        dataType: 'html',
        success: function (clienList) {
            $("#myDiv").html(clienList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}
function findClientePedido() {
    let q = document.getElementById("busClien").value;
    $.ajax({
        url: '../includes/controladorVentas.php',
        type: 'POST',
        data: {
            "action": 'findClientePedido',
            "q": q,
        },
        dataType: 'html',
        success: function (clienList) {
            $("#myDiv").html(clienList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}
function findClienteParaFacturar() {
    let q = document.getElementById("busClien").value;
    $.ajax({
        url: '../includes/controladorVentas.php',
        type: 'POST',
        data: {
            "action": 'findClienteParaFacturar',
            "q": q,
        },
        dataType: 'html',
        success: function (clienList) {
            $("#myDiv").html(clienList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}
function findClienteCotizacion() {
    let q = document.getElementById("busClien").value;
    $.ajax({
        url: '../includes/controladorVentas.php',
        type: 'POST',
        data: {
            "action": 'findClienteCotizacion',
            "q": q,
        },
        dataType: 'html',
        success: function (clienList) {
            $("#myDiv").html(clienList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}

function findClienteNotaCr() {
    let q = document.getElementById("busClien").value;
    $.ajax({
        url: '../includes/controladorVentas.php',
        type: 'POST',
        data: {
            "action": 'findClienteNotaC',
            "q": q,
        },
        dataType: 'html',
        success: function (clienList) {
            $("#myDiv").html(clienList);
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}