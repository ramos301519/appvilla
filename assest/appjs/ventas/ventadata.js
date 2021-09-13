// APPVILLA venta
$(document).ready(function() {
    //$(function() {

    //(function($) {
    $("#btnbuscar").click(function() {
        var btnbuscar = ($.trim($('#txtbuscarproducto').val()) === '') ? '' : $.trim($('#txtbuscarproducto').val());
        let producto = validaVacio(btnbuscar)
        if (producto === false) {
            get_productos(btnbuscar);
        } else {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Mensaje :' + 'Debe ingresar alguna palabra',
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }
    });

    $('#txtbuscarproducto').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == "13") {
            var btnbuscar = ($.trim($('#txtbuscarproducto').val()) === "") ? "" : $.trim($('#txtbuscarproducto').val());
            let producto = validaVacio(btnbuscar)
            if (producto === false) {
                get_productos(btnbuscar)
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Mensaje :' + 'Debe ingresar alguna palabra',
                    showConfirmButton: false,
                    timer: 2000
                });
                return false;
            }
            e.preventDefault();
            return false;
        }
    });

    $("#tblcar").on('click', 'a.edititem', function(e) {
        e.preventDefault();
        var pcode = $(this).attr("data-code");
        var pcante = $(this).attr("data-cante");
        var pdscsimb = $(this).attr("data-dscsimb");
        var pdscimpo = $(this).attr("data-dsctoimpo");
        var pnombre = $(this).attr("data-nombre");
        var bhtml = '';
        let dscsimb = pdscsimb == null || pdscsimb == "" ? '' : pdscsimb;
        let dscimpo = pdscimpo == null ? 0 : pdscimpo;
        if (dscsimb == "") {
            $('input:radio[name="dscsimb"]').attr('checked', false);
        } else {
            $('input:radio[name="dscsimb"]').attr('checked', true);
        }
        let editem = "primary";
        var element = document.getElementById('item' + pcode);
        element.classList.add(editem);

        bhtml += '<table class="table"><thead><tr><th colspan="2">' + pnombre + '</th></tr>';
        bhtml += '<tr><th>Cantidad</th><th>Descuento</th></tr></thead> <input type="hidden" value="' + pcode + '" id="productoide" name="productoide">';
        bhtml += '<tbody><tr><td style="width:30%"> <input type="number" class="form-control" id="cantproedi" name="cantproedi" placeholder="Cant" value="' + pcante + '"></td>';
        bhtml += '<td><div class="input-group"><input type="number" class="form-control" min="0" step="1" id="dscimpoe" name="dscimpoe" value="' + dscimpo + '" placeholder="Dscto">';
        bhtml += '<span class="input-group-btn"> <div class="btn-group" id="status" data-toggle="buttons"><label class="btn btn-default btn-on btn-xs active">';
        bhtml += '<input type="radio" value="I" name="dscsimb" id="descuento" checked="checked">S/</label>';
        bhtml += '<label class="btn btn-default btn-off btn-xs "><input type="radio" value="P" name="dscsimb" id="descuento">%</label>';
        bhtml += '</div><button class="btn btn-info" type="button" id="editarv"><i class="fa fa-check-square-o"></i></button></span></div>';
        bhtml += '</td></tr></tbody><tfoot></tfoot></table>';
        $('#edititemventa').html(bhtml);        

    });

    $("#editarv").on('click', 'a.edititem', function(e) {
        e.preventDefault();
        $('#edititemventa').html('');
    });

    var getDatacli = function(request, response) {
        $.getJSON(
            "Ventas/Ventas_control/buscarcliente?callback=?&q=" + request.term,
            function(data) {
                response(data);
            });
    };

    var selectItemcli = function(event, ui) {
        $("#buscarclientegv").val(ui.item.value);
        return false;
    }

    $("#buscarclientegv").autocomplete({
        source: getDatacli,
        select: selectItemcli,
        minLength: 4,
        change: function() {
            $("#buscarclientegv").val("").css("display", 2);
        }
    });

    /*
        $('#buscarclientegv').keyup(function() {
            var t = $('#buscarclientegv').val();
            $.ajax({
                type: "POST",
                url: "ventas/buscarcliente/",
                data: { clientedat: t },
                dataType: 'json',
                success: function(data) {
                    console.log(data);                    
                    data.map(data.datos, function(item) {
                        return {
                            label: item.info, //item.numero_identificacion + " " + item.razon_social,
                            value: item.info,
                            // desclie: item.numero_identificacion + " " + item.razon_social,
                            //codclie: item.id,
                        };
                    })
                }
            });
        });
        */

    /*
     $('#buscarclientegv').autocomplete({         
         
         minLength: 0,
         source: function(request, response) {
             $.ajax({
                 type: "POST",
                 contentType: "application/json; charset=utf-8",
                 url: './ventas/buscarcliente',
                 data: "{'description':'" + document.getElementById('buscarclientegv').value + "'}",
                 dataType: "json",
                 success: function(data) {
                     console.log(data);
                     var el = data.info;
                     response($.map(el,
                         function(el) {
                             return {
                                 label: el.Description,
                                 value: el.CheckRunID
                             }
                         }));
                 },
                 error: function(result) {
                     alert("Error");
                 }
             });
         },
         select: function(event, ui) {
             alert(ui.item.value);
             //$("#CheckRunDescription").val(ui.item.label);
             //$("#CheckRunID").val(ui.item.value);
             event.stopPropagation();
         }

     })
     */
    loaddatas();
});

function loaddatas() {
    get_productos_vendedor();
}

function get_productos(producto) {
    let a = producto.length;
    if ((a >= 3) || (a != "") || (a != "NaN")) {
        $.ajax({
            url: "Ventas/Ventas_control/buscarproducto",
            type: "POST",
            dataType: "json",
            data: { producto: producto },
            beforeSend: function() {
                loadshowmodal();
            },
            success: function(data) {
                loadhidenmodal();
                $('#txtbuscarproducto').val('');
                $('#showprocesload').html('');
                var html = "";
                var hay = "";
                if (data.status === true) {
                    let lista = data.info;
                    num = lista.length;
                    hay = " Se muestra resultado";
                    for (e = 0; e < num; e++) {
                        dat = lista[e];
                        var imgp = "";
                        if (dat.imagen === "" || dat.imagen === null) {
                            imgp = 'img/default.png';
                        } else {
                            imgp = filesmulti + dat.sku + "/" + dat.imagen;
                        }
                        var param = "'" + dat.nombre + "','" + dat.id + "'";
                        html += '<div class="col-md-4 col-sm-4  profile_details">';
                        html += '<div class="well profile_view"><div class="x_content">';
                        html += '<div class="thumbnail"><a href="javascript:void()" title="Detalle" onclick="set_view_detpro(' + dat.id + ');" >';
                        html += '<img src="assest/' + imgp + '" alt="Sin Imagen" style="width:100%"></a></div>';
                        html += '<form class="frmaddshop">';
                        html += '<input hidden value="' + dat.id + '" name="productoid" id="productoid">';
                        html += '<h2><strong>' + dat.nombre + ' </strong></h2><p>';
                        html += ' Marca: ' + dat.marca + ' Código: ' + dat.sku + ' Presentación: ' + dat.um + ' Descripción: ' + dat.descripcion + '';
                        html += '</p><p class="lead">' + dat.sigla + ' ' + dat.precio + '</p>';
                        html += '<a href="javascript:void()" title="Enviarfa"  onclick="set_add_carrito(' + param + ');" class="btn btn-success btn-lg btn-block"><i class="fa fa-shopping-cart"> </i> Agregar</a>';
                        html += '</div></div></div></form>';
                    }
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'error',
                        title: data.info
                    });
                    html += '<div class="col-md-4 col-sm-4  profile_details">';
                    html += '<div class="well profile_view"><div class="x_content">';
                    html += '<div class="thumbnail"><a href="#" data-toggle="modal" data-target="#detalleproduc">';
                    html += ' <img src="assest/img/default.png" alt="No hay Datos" style="width:100%"></a></div>';
                    html += '<h2><strong>' + data.info + ' </strong></h2><p>';
                    html += '</div></div></div>';
                }
                $('#resultsearch').html(html);
                $('#palabrasearch').html("Se busco como <strong>" + producto + "</strong>" + hay);
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#showprocesload').html('');
                $('#palabrasearch').html("Se busco como <strong>" + producto + "</strong>" + hay);
                loadhidenmodal();
                var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
                Swal.fire({
                    icon: 'error',
                    title: 'Error en proceso de eliminacion de dato',
                    text: 'Dato a Eliminar ... :' + textStatus,
                    html: msgerr,
                });
            }
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'error',
            title: 'dfdfdfdf'
        });

    }
}

function set_add_carrito(nomprod, idprod) {
    var productoid = parseInt(idprod, 10);
    var productoname = String(nomprod);
    var data = { productoid: productoid, productoname: productoname };
    $.ajax({
        url: "Ventas/Ventas_control/add_carrito",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            loadshowmodal();
        },
        success: function(json) {
            loadhidenmodal();
            $('#showprocesload').html('');
            if (json.status === true) {
                $("#view_venta").load(" #view_venta");
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: json.info
                });

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: json.info
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            loadhidenmodal();
            var msgerr = "<p>" + xhr + " :: " + textStatus + " :: " + errorThrown + ' ' + xhr + ' ' + xhr.statusText + ' ' + xhr.responseText + ' Codigohtp:' + xhr.status + "</p>";
            Swal.fire({
                icon: 'error',
                title: 'Error en procesar de datos',
                text: 'Los datos Ingresados ... :' + textStatus,
                html: msgerr,
            });
        }
    })
}

function set_view_detpro(idprod) {
    var productoid = parseInt(idprod, 10);
    var data = { productoid: productoid };

    $.ajax({
        url: "Ventas/Ventas_control/get_producto_id",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            // btnadd.html('<i class="fa fa-shopping-cart"> </i> Agregando..');
            $('#showprocesload').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
        },
        success: function(json) {

            $('#showprocesload').html('');
            if (json.validate === true) {
                var dat = json.info;

                var imgp = "";
                if (dat.imagen === "" || dat.imagen === null) {
                    imgp = 'img/default.png';
                } else {
                    imgp = filesmulti + dat.sku + "/" + dat.imagen;
                }
                var param = "'" + dat.nombre + "','" + dat.id + "'";
                var mdlhtml = '<div class="col-md-8 col-sm-12"><div><img src="assest/' + imgp + '" alt="Lights" style=" width: 150px; height: 250px; margin-right: 0;  margin-right: 10px';
                mdlhtml += 'margin-bottom: 10px; font-family: verdana;font-size: 300%;"></div>';
                mdlhtml +='<h3 class="prod_title">' + dat.nombre + '</h3>';
                mdlhtml += '<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">Es de marca  ' + dat.marca + ' con Código  ' + dat.sku + ' su Presentación es  ' + dat.um + ' como Descripción: ' + dat.descripcion + '</p></div>';
                mdlhtml += '<div class="col-md-4 col-sm-12" style="text-align: center;">';
                mdlhtml += '<div class="product_price"><span class="price-tax">Precio ' + dat.sigla + '.</span><h3 class="price">' + dat.precio + '</h3></div>';
                mdlhtml += '<div class="product_price"><span class="price-tax">Stock</span><h3 class="price">' + dat.stock + '</h3></div>';
                mdlhtml += '<div class="product_price"><span class="price-tax">Oferta ' + dat.sigla + '.</span><h3 class="price">' + dat.precio_oferta + '</h3></div>';
                var btnaddcar = '<a href="javascript:void()" title="ShowStorage"  onclick="get_show_storage(' + dat.id + ');" class="btn btn-link"><i class="fa fa-cube"> </i> Almacen</a>';
                btnaddcar += '<a href="javascript:void()" title="Enviarfa"  onclick="set_add_carrito(' + param + ');" class="btn btn-success"><i class="fa fa-shopping-cart"> </i> Agregar</a>';
                btnaddcar += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
                $(".modal-header").css("background-color", "#28A745");
                $(".modal-header").css("color", "white");
                $(".modal-title").text(dat.nombre);
                $('.modal-body').html(mdlhtml);
                $('.modal-footer').html(btnaddcar);
                $('#detalleproduc').modal('show');
            } else {
                let msg = json.info;
                $('.modal-footer').html('');
                $(".modal-header").css("background-color", "#FC180C");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Error!!");
                $('.modal-body').html(msg);
                $('#mdalmsg').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#showprocesload').html('');
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-footer').html('');
            $('.modal-body').html(msg);
            $('#mdalmsg').modal('show');
        }
    })
}

function get_show_storage(idprod) {
    var productoid = parseInt(idprod, 10);
    var data = { productoid: productoid };
    $.ajax({
        url: "Ventas/Ventas_control/get_producto_storage",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            // btnadd.html('<i class="fa fa-shopping-cart"> </i> Agregando..');
            $('#showprocesload').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
        },
        success: function(json) {
            $('#showprocesload').html('');

            var htmla = '<div class="table-responsive"><table class="table">';
            htmla += '<thead><tr><td>Almacen</td><td>Producto</td><td>Stock</td></tr></thead><tboody>';
            if (json.validate === true) {
                let lista = json.info;
                let num = lista.length;
                for (e = 0; e < num; e++) {
                    dat = lista[e];
                    htmla += '<tr><td>' + dat.almacen + '</td><td>' + dat.nombre + '</td><td>' + dat.stock + '</td></tr>';
                }
            } else {
                htmla += '<tr class="danger"><td colspan="3">' + json.info + '</td></tr>';
            }
            htmla += '</tboody></table></div>';
            $(".showstorage").html(htmla);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#showprocesload').html('');
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-footer').html('');
            $('.modal-body').html(msg);
            $('#mdalmsg').modal('show');
        }
    })
}


function get_stock_categoria() {

    var vctv = $('#cat_view').val();
    if(vctv===""){
    var productoid = 0;
    var data = { productoid: productoid };
    $.ajax({
        url: "Ventas/Ventas_control/get_stock_categoria",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            // btnadd.html('<i class="fa fa-shopping-cart"> </i> Agregando..');
            $('#showprocesload').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
        },
        success: function(json) {
            $('#showprocesload').html('');
            $('#palabrasearch').html('');
            if (json.validate === true) {
                var htmla = '<div class="table-responsive"><table class="table">';
                htmla += '<thead><tr><td colspan="2" style="text-align: center; vertical-align: middle;">Lista de Categorias</td></tr></thead><tboody>';

                let lista = json.info;
                let num = lista.length;
                hay = " Se muestra resultado";
                for (e = 0; e < num; e++) {
                    dat = lista[e];
                    htmla += '<tr><td><strong style="background-color:' + dat.color + ';">&nbsp;&nbsp;&nbsp;</strong>' + dat.categoria + '</td><td>' + dat.stock + ' Productos</td></tr>';
                }
                htmla += '</tboody></table></div>';
                $('#cat_view').val('a');
                $("#resultsearch").html(htmla);

            } else {
                let msg = json.info;
                $(".modal-header").css("background-color", "#28A745");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Error!!");
                $('.modal-footer').html('');
                $('.modal-body').html(msg);
                $('#mdalmsg').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#showprocesload').html('');
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-body').html(msg);
            $('.modal-footer').html('');
            $('#mdalmsg').modal('show');
        }
    })
}else{
    $('#cat_view').val('');
    $("#resultsearch").html('');
}
}

function set_delete_carrito(idprod) {
    var productoid = parseInt(idprod, 10);
    var data = { productoid: productoid };
    $.ajax({
        url: "Ventas/Ventas_control/delete_carrito",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            $('#showp').html('<p><img src="assest/img/loadimage.gif" /></p><strong>..</strong>');
        },
        success: function(json) {
            $('#showp').html('');
            if (json.validate === true) {
                let msg = '<p>' + json.info + '</p>';
                $("#view_venta").load("#view_venta");
                $('#showp').html(msg);
                setTimeout(function() {
                    $('#showp').html('');
                }, 5000);
            } else {
                let msg = json.info;
                $(".modal-header").css("background-color", "#28A745");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Error!!");
                $('.modal-footer').html('');
                $('.modal-body').html(msg);
                $('#mdalmsg').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#showp').html('');
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-footer').html('');
            $('.modal-body').html(msg);
            $('#mdalmsg').modal('show');
        }
    })
}

function get_productos_vendedor() {
    $.ajax({
        url: "Ventas/Ventas_control/get_productovendedor",
        type: "GET",
        datatype: "json",
        beforeSend: function() {
            $('#accesodirecto').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
        },
        success: function(data) {
            var maxpv = 20;
            var maxlis = 0;
            $('#accesodirecto').html('');
            var htmlpv = '';
            if (data.validate === true) {
                let lista = data.info;
                num = lista.length;
                hay = " Se muestra resultado";
                for (e = 0; e < num; e++) {
                    dat = lista[e];
                    maxlis = maxlis + 1;
                    let desh = dat.stock === "0" || dat.stock === null ? "disabled" : '';
                    var param = "'" + dat.nombre + "','" + dat.producto_id + "'";
                    htmlpv += '<a class="btn btn-app ' + desh + '" href="javascript:void()" title="Enviarfa"  onclick="set_add_carrito(' + param + ');" ><span class="badge bg-blue">' + dat.stock + '</span><i class="fa fa-cube"></i> ' + dat.nombre + '</a>';
                }
            } else {
                htmlpv += '<a class="btn btn-app disabled"><span class="badge bg-blue">_</span><i class="fa fa-cube"></i> ' + data.info + '</a>';
            }
            let addhtml = '<a class="btn btn-app" onclick="add_producto_acceso()"><i class="fa fa-plus"></i> Agregar</a>';
            htmlpv += maxpv === maxlis ? '' : addhtml;
            $('#accesodirecto').html(htmlpv);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#accesodirecto').html('');
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            let alr = '<div class="alert alert-danger" role="alert">' + msg + '</div>';
            $('#accesodirecto').html(msg);
        }
    });
}

function add_producto_acceso() {
    $.ajax({
        url: "Ventas/Ventas_control/get_productovendedor_addlist",
        type: "GET",
        datatype: "json",
        success: function(json) {
            var htmla = "";
            var htmlb = "";
            if (json.validate === true) {
                let lista = json.info;
                let num = lista.length;
                hay = " Se muestra resultado";
                var btna = "";
                var nrocnt = 0;
                for (e = 0; e < num; e++) {
                    dat = lista[e];
                    nrocnt = nrocnt + 1;
                    let favorito = dat.favorito;
                    if (favorito === "A") {
                        btna = '<button type="button" class="btn btn-link" href="javascript:void()" title="Agregar Favorito" onclick="add_producto_acceso_save(' + dat.producto_id + ');" role="button"><span class="label label-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span></button>';
                    } else {
                        btna = '<button type="button" class="btn btn-link" href="javascript:void()" title="Eliminar Favorito" onclick="delete_producto_acceso(' + dat.id + ');" role="button"><span class="label label-success"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></span></button>';
                    }
                    htmlb += '<tr><td>' + nrocnt + '</td><td>' + dat.nombre.toLowerCase() + '</td><td>' + dat.stock + ' </td><td>' + btna + '</td></tr>';
                }

            } else {
                htmlb += '<tr><td colspan="3"><strong style="background-color:' + json.info + ' </td></tr>';
            }
            htmla += '<div class="input-group"><span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span><input type="text" class="form-control" placeholder="Producto a Buscar" id="productovendedor_search" onkeyup="buscar_productovendedor()" aria-describedby="basic-addon1" autofocus=""></div>';
            htmla += '<div class="table-responsive"><table class="table" id="tablapvs">';
            htmla += '<thead><tr><th>#</th><th>Descripcion</th><th>Stock</th><th>Favorito</th></tr></thead><tboody>';
            htmla += htmlb;
            htmla += '</tboody></table></div>';
            $(".modal-header").css("background-color", "#28A745");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Lista Productos");
            $('.modal-body').html(htmla);
            $('#mdalproductoVendedor').modal('show');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-body').html(msg);
            $('#mdalmsg').modal('show');
        }
    });
}

function add_producto_acceso_save(id) {
    var data = { productoid: id };
    $.ajax({
        url: "Ventas/Ventas_control/save_productovendedor",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function() {
            $('#mdalproductoVendedor #msg').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
        },
        success: function(json) {
            $('#mdalproductoVendedor #msg').html('');
            if (json.validate === true) {
                add_producto_acceso();
                get_productos_vendedor();
                let dat = '<div class="alert alert-success" role="alert">Se agrego un producto a favoritos</div>';
                $('#mdalproductoVendedor #msg').html(dat);
                setTimeout(function() {
                    $('#mdalproductoVendedor #msg').html('');
                }, 9000);

            } else {
                $('#mdalproductoVendedor #msg').html(json.info);
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
            $(".modal-header").css("background-color", "#FC180C");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Error!!");
            $('.modal-body').html(msg);
            $('#mdalmsg').modal('show');
        }
    });
}

function buscar_productovendedor() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("productovendedor_search");
    filter = input.value.toLowerCase();
    table = document.getElementById("tablapvs");
    tr = table.getElementsByTagName("tr");
    console.log(input);
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function delete_producto_acceso(id) {
    if (confirm('Esta Seguro de Eliminar Este Producto del su favorito? ' + id)) {
        var data = { productovendedorid: id };
        $.ajax({
            url: "Ventas/Ventas_control/delete_productovendedor",
            type: "POST",
            dataType: "JSON",
            data: data,
            beforeSend: function() {
                $('#mdalproductoVendedor #msg').html('<p><img src="assest/img/loadimage.gif" /></p><strong>Procesando..</strong>');
            },
            success: function(json) {
                $('#mdalproductoVendedor #msg').html('');
                if (json.validate === true) {
                    add_producto_acceso();
                    get_productos_vendedor();
                    let dat = '<div class="alert alert-success" role="alert">' + json.info + '</div>';
                    $('#mdalproductoVendedor #msg').html(dat);
                    setTimeout(function() {
                        $('#mdalproductoVendedor #msg').html('');
                    }, 9000);

                } else {
                    $('#mdalproductoVendedor #msg').html(json.info);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                let msg = '<p>Error en :' + jqXHR + ' ' + textStatus + ' ' + errorThrown + '</p>';
                $(".modal-header").css("background-color", "#FC180C");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Error!!");
                $('.modal-body').html(msg);
                $('#mdalmsg').modal('show');
            }
        });

    }
}

function addventacliente() {

}

function listventacliente() {

}

function updateventacliente() {

}

function deleteventacliente() {


}