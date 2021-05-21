function regresarMensajeBorrado() {
    return confirm("Esta seguro que desea eliminar el registro");
}

function regresarMensajeActualizar() {
    return confirm("Esta seguro que desea actualizar los datos");
}

function agregarTooltips() {
    $(function() {
        $(document).tooltip();
    });
}

function acercade() {
    $.alert({
        title: 'Acerca De',
        content: 'Elaborado por Rico Gómez Eduardo Daniel para la materia de Programación WEB, Semestre ENE-JUN 2020',
    });
}

function autocompletarBuscador() {
    $.ajax({
        type: "GET",
        method: "GET",
        url: "classHome.php?OPT=1",
        success: function(response) {
            var result = response.split("|");
            var array = new Array();
            for (let i = 0; i < result.length / 3; i++) {
                labell = result[i * 4 + 1] + result[i * 4 + 2];
                array.push({
                    value: result[i * 4],
                    label: labell,
                    titulo: result[i * 4 + 1],
                    autor: result[i * 4 + 2],
                    icon: result[i * 4 + 3]
                });
            }

            $("#txtbuscador").autocomplete({
                    minLength: 0,
                    source: array,
                    select: function(event, ui) {
                        $("#txtbuscador").val(ui.item.titulo);
                        console.log(ui.item);
                        libro(ui.item.value);
                        return false;
                    }
                })
                .autocomplete("instance")._renderItem = function(ul, item) {
                    return $("<li>")
                        .append("<div>" + ' <img width="40" height="60" src = "../src/portadas/' + item.icon + '"/>' + item.titulo + " " + item.autor + "</div>")
                        .appendTo(ul);
                };
        }
    });
}

function libro(id) {
    window.location = "libro.php?id=" + id;
}

function activar(idLibro, idUsuario) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: "classLibro.php?OPT=1",
        data: {
            idLibro,
            idUsuario
        },
        success: function(response) {
            console.log(response);
            $("#botonesLibro").html(response);
        }
    });
}

function desactivar(id, idLibro, idUsuario) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: "classLibro.php?OPT=2",
        data: {
            id,
            idLibro,
            idUsuario
        },
        success: function(response) {
            console.log(response);
            $("#botonesLibro").html(response);
        }
    });
}

function extender(id, idLibro, idUsuario) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: "classLibro.php?OPT=3",
        data: {
            id,
            idLibro,
            idUsuario
        },
        success: function(response) {
            console.log(response);
            $("#botonesLibro").html(response);
        }
    });
}

function cambiaPagina(numero, parece, categoria) {
    $.ajax({
        type: "POST",
        method: "POST",
        url: "classHome.php?OPT=2",
        data: {
            numero,
            parece,
            categoria
        },
        success: function(response) {
            console.log(response);
            $("#vistaLibros").html(response);
        }
    });
}

function buscadorLiBo() {
    parece = $("#txtbuscador").val();
    cambiaPagina(0, parece);
}