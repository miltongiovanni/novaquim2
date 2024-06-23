
function findMateriaPrima() {
    let q = document.getElementById("busMPrima").value;
    $.ajax({
        url: '../../../../../includes/controladorProduccion.php',
        type: 'POST',
        data: {
            "action": 'findMateriaPrimaCalidad',
            "q": q,
        },
        dataType: 'html',
        success: function (mPrimasList) {
            $("#mPrimaSelect").html(mPrimasList);
            $("#materia_prima").removeClass('d-none');
            $("#lote_info").removeClass('d-none');
        },
        fail: function () {
            alert("Vous avez un GROS problème");
        }
    });
}
function findLoteMPrima(codMPrima) {
    console.log(codMPrima);
    $.ajax({
        url: '../../../../../includes/controladorProduccion.php',
        type: 'POST',
        data: {
            "action": 'findLoteByMPrima',
            "codMPrima": codMPrima
        },
        dataType: 'html',
        success: function (lotesList) {
            $("#id_cal_mp").html(lotesList);
        },
        error: function () {
            alert("Vous avez un GROS problème");
        }
    });
}