<script type="text/javascript">

function cambiarEmpresa(empresaId) {
    $.ajax({
        url: "<?= base_url('/cambiarEmpresa') ?>",
        type: "POST",
        data: { empresaId: empresaId },
        success: function(resp) {
            if (resp.ok) {
                location.reload();
            } else {
                alert(resp.msg || 'No se pudo cambiar la empresa');
            }
        },
        error: function() {
            alert('Error al cambiar la empresa');
        }
    });
}    
/* =========================
   UTILIDADES GENERALES
========================= */

function createXMLHttpRequest() {
    var xmlHttp = null;

    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }

    return xmlHttp;
}

function roundToTwo(num) {
    return +(Math.round(num + "e+2") + "e-2");
}

Number.prototype.round = function (places) {
    return +(Math.round(this + "e+" + places) + "e-" + places);
};

function limpia(id) {
    document.getElementById(id).innerHTML = "";
}

function bloquea(id) {
    document.getElementById(id).disabled = true;
}

function eliminar() {
    return confirm('Esta seguro de eliminar este registro?');
}

function numero(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function carga_usu(id) {
    var usu = document.getElementById(id);
    if (usu) {
        usu.value = 'Julio';
    }
}

function esMobil() {
    var details = navigator.userAgent;
    var regexp = /android|iphone|kindle|ipad/i;
    var isMobileDevice = regexp.test(details);

    if (isMobileDevice) {
        alert('es Mobil');
    } else {
        alert('es Desktop');
    }
}

/* =========================
   UI / PLUGINS
========================= */

function refreshUIPlugins() {
    try {
        $(".selectpicker").selectpicker('refresh');
    } catch (e) {
        try {
            $(".selectpicker").selectpicker();
        } catch (err) {}
    }

    $('.btn.dropdown-toggle.btn-light.bs-placeholder').addClass('w-100');
    $('.dropdown-toggle').addClass('w-100');
}

function initDraggable() {
    if ($("#drag").length) {
        $("#drag").draggable();
    }
    if ($("#modal_form").length) {
        $("#modal_form").draggable();
    }
}

function initFormArch() {
    $(document).off('submit', '#formarch').on('submit', '#formarch', function (event) {
        event.preventDefault();

        $.ajax({
            url: "<?= base_url(); ?>empresa/import",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                alert(data);
            }
        });
    });
}

function initDataTables() {
    console.log('initDataTables ejecutado');
    console.log('dt-main:', $('.dt-main').length);
    console.log('dt-detalle:', $('.dt-detalle').length);
    console.log('dt-boton:', $('.dt-boton').length);

    if ($('.dt-main').length) {
        if ($.fn.DataTable.isDataTable('.dt-main')) {
            $('.dt-main').DataTable().destroy();
        }

        $('.dt-main').DataTable({
            destroy: true,
            sPaginationType: "full_numbers",
            aaSorting: [[0, "desc"]],
            paging: true,
            pageLength: 10,
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                var intVal = function (i) {
                    return typeof i === 'string'
                        ? i.replace(/[\$,]/g, '') * 1
                        : typeof i === 'number'
                            ? i
                            : 0;
                };

                var nb_cols = api.columns().nodes().length;
                var j = 3;
                var title = '';
                var total = 0;
                var pageTotal = 0;

                while (j < nb_cols) {
                    title = api.column(j).header();

                    if ($(title).html() === 'COSTO' || $(title).html() === 'TOTAL') {
                        total = api.column(j).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                        pageTotal = api.column(j, { page: 'current' }).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                        $(api.column(j).footer()).html(
                            '$' + pageTotal.toFixed(2) + ' E ' + total.toFixed(2)
                        );
                    }
                    j++;
                }
            }
        });
    }


    if ($('.dt-boton').length) {
    $('.dt-boton').each(function () {
        if ($.fn.DataTable.isDataTable(this)) {
            $(this).DataTable().destroy();
        }

        $(this).DataTable({
            destroy: true,
            paging: true,
            pageLength: 5
        });
    });
    }
}

function load_tabla() {
    initDataTables();
    refreshUIPlugins();
}

function load_tabla_det() {
    //initDataTables();
    if ($('.dt-detalle').length) {
    $('.dt-detalle').each(function () {
        if ($.fn.DataTable.isDataTable(this)) {
            $(this).DataTable().destroy();
        }

        $(this).DataTable({
            destroy: true,
            paging: true,
            pageLength: 5
        });
    });
    }

}

/* =========================
   MODAL
========================= */

function add_person(btn_g, btn_c) {
    var btnSave = document.getElementById("btnSave");
    var btnClose = document.getElementById("btnclose");

    if (btnSave) {
        btnSave.style.display = (btn_g === 'S') ? '' : 'none';
    }

    if (btnClose) {
        btnClose.style.display = (btn_c === 'S') ? '' : 'none';
    }

    $('#modal_form').modal('show');
}

/* =========================
   CATALOGO DINAMICO
========================= */

function cambioss(param, ind) {
    var camp = param.split('@');

    for (var i = 0; i < camp.length; i++) {
        var cm = camp[i].split('|');
        var dt = cm[1].split(',');
        var p = cm[0] + '|';
        var campo = '#' + cm[0];

        for (var j = 0; j < dt.length; j++) {
            var cmp = dt[j].split('-');
            var dto = document.getElementById(cmp[0]);
            var value = dto.options[dto.selectedIndex].value;
            p = p + cmp[1] + '-' + value + ";";
        }

        opcionfill(campo, p, ind);
    }
}

function opcionfill(campo, p, ind) {
    $.post("<?php echo base_url(); ?>empresa/fill/" + ind, {
        id: p
    }, function (data) {
        console.log("data:" + data);
        console.log("c:" + campo);
        $(campo).html(data);
        refreshUIPlugins();
    });
}

/* =========================
   CONSULTA / FILTRO
========================= */

function consultar(evt, acc, ind) {
    var raccc = 'consfiltro';

    $.ajax({
        type: 'post',
        url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind,
        cache: false,
        data: $('#formf').serialize(),
        beforeSend: function () {
            $(".contenido").css("display", "");
            $(".contenido").html("<img src='../HCbpms/public/images/espera.gif'>");
        },
        success: function (response) {
            $(".contenido").css("display", "none");
            document.getElementById('filtro').innerHTML = response;
            load_tabla();
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            console.log("termino");
        }
    });
}

/* =========================
   GRABAR
========================= */

function graba(evt, acc, ind, det = 'A', deti = '0', item = '', item_det = '', indexc = '') {
    console.log('graba =>', acc, ind, det, deti, item, item_det, indexc);

    var raccc = (acc === 'mod') ? 'Modificardatos' : 'recibirdatos';
    var formData = $('#form').serialize();

    $.ajax({
        type: 'post',
        url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind + '/0/' + indexc + '/' + det + '/' + deti,
        cache: false,
        data: formData,
        success: function (response) {
            console.log("success:", response);

            var mensaje = '';
            var resp;

            try {
                resp = JSON.parse(response);
            } catch (e) {
                document.getElementById("mensajefin").innerHTML = response;
                return;
            }

            if (resp.errCodigo == '0') {
                if (acc === 'nue') {
                    var grbBtn = document.getElementById("grb_btn");
                    if (grbBtn) {
                        grbBtn.style.display = "none";
                    }
                }

                mensaje = "<div class='alert alert-success'>TRANSACCION EXITOSA</div>";

                if (det === 'D') {
                    var arritem = item_det.split('|');
                    var ii = (parseInt(arritem[1], 10) - 1);

                    cargadet(
                        '<?= base_url() ?>empresa/detalle/' + ind + '/' + arritem[1] + '/' + arritem[2],
                        'contenido',
                        ii
                    );
                } else {
                    var arritemc = item.split('|');
                    carga('<?= base_url() ?>empresa/index/' + arritemc[0], 'filtro');
                }
            } else {
                mensaje = "<div class='alert alert-danger'>Error: " + resp.errCodigo + " - " + resp.errMenssa + "</div>";
            }

            document.getElementById("mensajefin").innerHTML = mensaje;
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
            document.getElementById("mensajefin").innerHTML =
                "Error en la solicitud: " + textStatus + " - " + errorThrown;
        },
        complete: function () {
            console.log("termino la solicitud");
        }
    });
}

/* =========================
   CARGAS AJAX
========================= */

function carga(url, id) {
    console.log('carga =>', url);

    document.getElementById(id).innerHTML = '';

    var pagecnx = createXMLHttpRequest();

    pagecnx.onreadystatechange = function () {
        if (pagecnx.readyState === 4 &&
            (pagecnx.status === 200 || window.location.href.indexOf("http") === -1)) {

            document.getElementById(id).innerHTML = pagecnx.responseText;
            console.log(pagecnx.responseText);

            load_tabla();
            actualizarTransaccion();
            $(".contenido").css("display", "none");
        }
    };

    pagecnx.open('POST', url, false);
    $(".contenido").css("display", "");
    $(".contenido").html("<img src='../HCbpms/public/images/espera.gif'>");
    pagecnx.send(null);
}

function cargaRpt(url, id) {
    var details = navigator.userAgent;
    var regexp = /android|iphone|kindle|ipad/i;
    var isMobileDevice = regexp.test(details);

    if (isMobileDevice) {
        url = url + '/M';
    } else {
        url = url + '/D';
    }

    var pagecnx = createXMLHttpRequest();

    pagecnx.onreadystatechange = function () {
        if (pagecnx.readyState === 4 &&
            (pagecnx.status === 200 || window.location.href.indexOf("http") === -1)) {

            document.getElementById(id).innerHTML = pagecnx.responseText;
            load_tabla();
            $(".contenido").css("display", "none");
        }
    };

    pagecnx.open('POST', url, false);
    $(".contenido").css("display", "");
    $(".contenido").html("<img src='../HCbpms/public/images/espera.gif'>");
    pagecnx.send(null);
}

function cargadet(url, id, ind) {
    refreshUIPlugins();

    if (!$('.dt-main').length || !$.fn.DataTable.isDataTable('.dt-main')) {
        console.error('La tabla principal no está inicializada');
        return;
    }

    var table = $('.dt-main').DataTable();
    var row = table.row(':eq(' + ind + ')');

    if (!row.node()) {
        console.error('No se encontró la fila: ' + ind);
        return;
    }

    if (row.child.isShown()) {
        row.child.hide();
        $(row.node()).removeClass('shown');
        return;
    }

    $(".contenido").css("display", "");
    $(".contenido").html("<img src='../HCbpms/public/images/espera.gif'>");

    $.ajax({
        url: url,
        type: 'POST',
        cache: false,
        success: function (resp) {
            console.log('RESP DETALLE:', resp);

            if (!resp || $.trim(resp) === '') {
                console.error('El detalle llegó vacío');
                $(row.node()).removeClass('shown');
                $(".contenido").css("display", "none");
                return;
            }

            row.child(
                '<div class="detalle-child" style="padding:10px; background:#fff;">' + resp + '</div>'
            ).show();

            $(row.node()).addClass('shown');

            load_tabla_det();
            refreshUIPlugins();
            $(".contenido").css("display", "none");
        },
        error: function (xhr, status, error) {
            console.error('Error cargando detalle:', status, error);
            console.log(xhr.responseText);
            $(row.node()).removeClass('shown');
            $(".contenido").css("display", "none");
        }
    });
}

function cargan(url) {
    var pagecnx = createXMLHttpRequest();

    pagecnx.onreadystatechange = function () {
        if (pagecnx.readyState === 4 &&
            (pagecnx.status === 200 || window.location.href.indexOf("http") === -1)) {

            var dato = pagecnx.responseText;
            var arr = dato.length;

            if (arr === 0) {
                alert("Transaccion Exitosa");
            } else {
                alert(dato);
            }
        }
    };

    pagecnx.open('POST', url, false);
    pagecnx.send(null);
}

function carga_model(url, id) {
    var pagecnx = createXMLHttpRequest();

    pagecnx.onreadystatechange = function () {
        if (pagecnx.readyState === 4 &&
            (pagecnx.status === 200 || window.location.href.indexOf("http") === -1)) {
            $('#modal-body').text(pagecnx.responseText);
        }
    };

    pagecnx.open('POST', url, false);
    pagecnx.onload = function () {
        load_tabla();
    };
    pagecnx.send(null);
}

/* =========================
   OTRAS
========================= */

function grab(accion) {
    alert('aaaa' + accion);
}

function nuevo() {
    alert('nuevo');
    $('#form').reset();
}

function hola() {
    alert('hola');
}

function enviaCorreoGuia(doc) {
    cargan('http://192.168.100.14/mensajeria/envioCorreoGuia.php?id=' + doc);
}

function importar(evt, acc, ind, nfile) {
    alert('hooooola' + acc + ind + nfile);

    var raccc = 'import';
    var data = new FormData();

    jQuery.each($('input[type=file]')[0].files, function (i, file) {
        data.append('file-' + i, file);
    });

    var other_data = $('#formarch').serializeArray();
    $.each(other_data, function (key, input) {
        data.append(input.name, input.value);
    });

    $.ajax({
        type: 'post',
        url: '<?= base_url();?>' + 'empresa/' + raccc + '/' + ind,
        cache: false,
        data: data,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".contenido").css("display", "");
            $(".contenido").html("<img src='../HCbpms/public/images/espera.gif'>");
        },
        success: function (response) {
            alert(response);
            $(".contenido").css("display", "none");
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        },
        complete: function () {
            console.log("termino");
        }
    });
}

function actualizarTransaccion() {
    $.ajax({
        url: '<?= base_url('empresa/obtenerNuevoContenido') ?>',
        type: 'GET',
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                document.getElementById('productoName').innerHTML = data.productoName + ' - ' + data.transaccionName;
                document.getElementById('transaccionName').innerHTML = data.transaccionName;
            }
        },
        error: function () {
            alert('Error al cargar la transacción.');
        }
    });
}

/* =========================
   INICIALIZACION
========================= */

$(function () {
    console.log('script.php cargado');

    initDraggable();
    initFormArch();
    refreshUIPlugins();
    initDataTables();
});
</script>