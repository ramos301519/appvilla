//cart options
/**
 * Carro de compra simple
 * @param {any} sessionName nombre del carro para almacenar
 * @param {any} items lista de elementos, necesita id, product, price, qty como minimo. Pero puedes almacenar todo lo que quieras
 */
function Cart(sessionName, items) {
    if (sessionName !== undefined && sessionName !== null) { this.sessionName = sessionName; } else { this.sessionName = 'carro'; }
    if (items !== undefined && items !== null) { this.items = items; } else {
        if (sessionName !== undefined && sessionName !== null) {
            try {
                this.items = JSON.parse(localStorage[sessionName]);
            } catch (e) {
                this.items = [];
            }
        } else { this.items = []; }
    }

    /**
     * Agregar un item al carro
     * @param {any} item Objeto con los datos del item. Minimo estas propiedades id, product, price, qty
     * @param {any} itemImg objeto contenedor o identificador ej. #miproducto de la imagen para hacer volar la imagen hacia el carro
     * @param {any} cart objeto contenedor del carro o identificador ej. #micarro
     */
    Cart.prototype.add = function(item, itemImg, cart) {
        var add = true;
        for (var i = 0; i < this.items.length; i++) {
            if ((item.id == this.items[i].id)) {
                this.items[i].qty = parseFloat(item.qty) + parseFloat(this.items[i].qty);
                this.items[i].price = parseFloat(item.price);
                add = false;
            }
        }
        if (add === true) this.items.push(item);
        localStorage.setItem(this.sessionName, JSON.stringify(this.items));

        //si envia la imagen y el carro vuela la imagen hacia el carro
        if (itemImg !== undefined && itemImg !== null &&
            cart !== undefined && cart !== null)
            flyToElement(itemImg, cart);

        return this.items;
    };

    /**
     * Recoge los datos del id consultado
     * @param {any} id identificador del item a eliminar
     */
    Cart.prototype.getItemById = function(id) {
        var miItem;
        for (var i = 0; i < this.items.length; i++) {
            id == this.items[i].id ? miItem = this.items[i] : false;
        }
        return miItem;
    };

    /**
     * Recoge los datos del item consultado
     * @param {any} product nombre dle producto a consulta
     */
    Cart.prototype.getItemByProduct = function(product) {
        var miItem;
        for (var i = 0; i < this.items.length; i++) {
            product == this.items[i].product ? miItem = this.items[i] : false;
        }
        return miItem;
    };

    /**
     * Elimina el item seleccionado del carro
     * @param {any} id identificador del item a eliminar
     */
    Cart.prototype.remove = function(id) {
        for (var i = 0; i < this.items.length; i++) {
            id == this.items[i].id ? this.items.splice(i, 1) : false;
        }
        localStorage.setItem(this.sessionName, JSON.stringify(this.items));
        return this.items;
    };

    /** Elimina el carro */
    Cart.prototype.clear = function() {
        this.items = [];
        localStorage.removeItem(this.sessionName);
        return true;
    };

    /** Devulve el contenido del carro */
    Cart.prototype.get = function() {
        return this.items;
    };

    /**
     * Enviar el objeto con los datos para el carro
     * @param {any} items Ojeto con al menos estas propiedades id, product, price, qty
     */
    Cart.prototype.set = function(items) {
        this.items = items;
        localStorage.setItem(this.sessionName, JSON.stringify(this.items));
    };

    /** Devuelve el total de lineas del carro */
    Cart.prototype.count = this.items.length;

    /** Devuelve el total del carro */
    Cart.prototype.getTotal = function() {
        var total = 0;
        $.each(this.items, function(key, value) {
            total += (value.price * value.qty);
        });
        return total;
    };

    /**
     * Imprimir en la ventana del carro
     * @param {any} div objeto contenedor del carro o identificador ej. #micarro
     */
    Cart.prototype.printHTMLEdit = function(div) {
        $(div).empty();
        var carrito = '< ul>'
        $.each(this.items, function(key, value) {
            carrito += '< li class="sbmincart-item sbmincart-item-changed">' +
                '   < div class="col-md-8 col-xs-8">' +
                '       < span class="sbmincart-name">' + value.product + '< /span>' +
                '   < /div>' +
                '   < div class="col-md-3 col-xs-3">' +
                '       < span class="sbmincart-price">' + value.price + '< /span>' +
                '   < /div>' +
                '   < div class="col-md-1 col-xs-1" style="padding:0;margin:0;text-align: right;">' +
                '       < button type="button" class="btn btn-link" onclick="DelItem(' + value.id + ')">< i class="fa fa-trash">< /button>' +
                '   < /div>' +
                '< /li>';
        });
        carrito += "< /ul>";
        $(div).append(carrito);
        var total = this.getTotal();
        $(div).append('< div class="sbmincart-footer">Total: ' + total + ' < /div>< /div > ');

    };

    /**
     * Hacer volar la imagen del articulo seleccionado hasta el carro de compra
     * @param {any} flyer objeto original o identificador ej. #miproducto
     * @param {any} flyingTo objeto hacia donde volar o identificador ej. #micarro
     */
    function flyToElement(flyer, flyingTo) {
        var $func = $(this);
        var divider = 3;
        var flyerClone = $(flyer).clone();
        $(flyerClone).css({ position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000 });
        $('body').append($(flyerClone));
        var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width() / divider) / 2;
        var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height() / divider) / 2;

        $(flyerClone).animate({
                opacity: 0.4,
                left: gotoX,
                top: gotoY,
                width: $(flyer).width() / divider,
                height: $(flyer).height() / divider
            }, 700,
            function() {
                $(flyingTo).fadeOut('fast', function() {
                    $(flyingTo).fadeIn('fast', function() {
                        $(flyerClone).fadeOut('fast', function() {
                            $(flyerClone).remove();
                        });
                    });
                });
            });
    }
}