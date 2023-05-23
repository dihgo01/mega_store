$(document).ready(function () {
    const cart_memory_init = JSON.parse(localStorage.getItem('cart'));

    if (cart_memory_init) {
        $(cart_memory_init).each(function (index, value) {
            const total_price_cart = parseFloat($('#shopCartSales').text().replace(',', '.'));
            const total = parseFloat(total_price_cart) + parseFloat(value.price);
            $('#shopCartSales').html(total.toFixed(2));
            $('#shopCart_Sales').append(
                '<li class="list-group-item list_item_grid_' + value.id + '" data-id="' + value.id + '">' +
                '<div class="row p-0 align-items-center">' +
                '<div class="col-2 p-0 mb-1">' +
                '<img class="icon me-1 img-fluid rounded-circle" src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt="">' +
                '</div>' +
                '<div class="col-8 px-1 py-0 mb-1">' +
                '<p class="fs-12px mb-0">' + value.name + '</p>' +
                '</div>' +
                '<div class="col-2 p-0 mb-1">' +
                '<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btnRemoverCart" data-id="' + value.id + '" ><i class="fas fa-trash"></i></a>' +
                '</div>' +
                '<div class="col-6">' +
                '<h5 class="display-11 text-center">Quantidade</h5>' +
                '<div class="form-control-wrap number-spinner-wrap">' +
                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-minus remove_cart_item" data-id="' + value.id + '" data-number="minus-qv"><em class="icon ni ni-minus"></em></button>' +
                '<input type="number" class="form-control number-spinner input_qtd_' + value.id + '" value="1" min="1" readonly="">' +
                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-plus add_cart_item" data-id="' + value.id + '" ><em class="icon ni ni-plus"></em></button>' +
                '</div>' +
                '</div>' +
                '<div class="col-6">' +
                '<h5 class="display-11 text-center">Preço</h5>' +
                '<div class="form-control-wrap">' +
                '<input type="text" class="form-control price_input_' + value.id + '" value="' + value.price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '" readonly="">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</li>'
            );
        });
    }

    // REMOVE CART
    $('body').on('click', '.remove_cart_item', function () {
        const id = $(this).attr('data-id');

        $.ajax({
            url: 'http://localhost:8000/product-only?id=' + id,
            type: 'GET',
            dataType: "JSON",
            data: {},
            success: function (retorno) {
                if (retorno.id) {
                    const decimal = retorno.price.replace(',', '.');
                    const price = decimal.replace('R$', '');
                    const imposto = (parseFloat(price) * retorno.percentage / 100);

                    const cart_memory = localStorage.getItem('cart');

                    if (cart_memory) {
                        const cart_memory_json = JSON.parse(cart_memory);
                        const product_exist = cart_memory_json.find(product => product.id === retorno.id);

                        if (product_exist) {

                            const quantity = product_exist.quantity - 1;

                            if (quantity == 0) {

                                const productIndex = cart_memory_json.filter(product => product.id !== retorno.id);

                                localStorage.setItem('cart', JSON.stringify(productIndex));

                                const total_price_cart = parseFloat($('#shopCartSales').text());
                                const total = total_price_cart - parseFloat(price);
                                $('#shopCartSales').html(total.toFixed(2));
                                $('.list_item_grid_' + retorno.id).remove();
                            } else {

                                const total_price = parseFloat(price) * quantity;

                                const productIndex = cart_memory_json.filter(product => product.id !== retorno.id);

                                productIndex.push({
                                    id: retorno.id,
                                    name: retorno.name,
                                    price: total_price,
                                    quantity: quantity,
                                    tax: imposto * quantity
                                });

                                localStorage.setItem('cart', JSON.stringify(productIndex));

                                const total_price_cart = parseFloat($('#shopCartSales').text());
                                const total = total_price_cart - parseFloat(price);
                                $('#shopCartSales').html(total.toFixed(2));

                                $('.input_qtd_' + retorno.id).val(quantity);
                                $('.price_input_' + retorno.id).val(total_price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                            }
                        }
                    }

                } else {
                    Swal.fire({
                        title: 'Algo deu Errado!',
                        text: "Produto não encontrado.",
                        icon: 'error',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonText: 'Continuar'
                    }).then(function (result) {
                    });
                }
            },

        });

    });

    // ADD CART
    $('body').on('click', '.add_cart', function () {
        const id = $(this).attr('data-id');

        $.ajax({
            url: 'http://localhost:8000/product-only?id=' + id,
            type: 'GET',
            dataType: "JSON",
            data: {},
            success: function (retorno) {
                if (retorno.id) {
                    const decimal = retorno.price.replace(',', '.');
                    const price = decimal.replace('R$', '');
                    const imposto = (parseFloat(price) * retorno.percentage / 100);

                    const cart_memory = localStorage.getItem('cart');

                    if (cart_memory) {
                        const cart_memory_json = JSON.parse(cart_memory);
                        const product_exist = cart_memory_json.find(product => product.id === retorno.id);

                        if (product_exist) {
                            const quantity = product_exist.quantity + 1;
                            const total_price = parseFloat(price) * quantity;

                            const productIndex = cart_memory_json.filter(product => product.id !== retorno.id);

                            productIndex.push({
                                id: retorno.id,
                                name: retorno.name,
                                price: total_price,
                                quantity: quantity,
                                tax: imposto * quantity
                            });

                            localStorage.setItem('cart', JSON.stringify(productIndex));

                            const total_price_cart = parseFloat($('#shopCartSales').text());
                            const total = total_price_cart + parseFloat(price);
                            $('#shopCartSales').html(total.toFixed(2));

                            $('.input_qtd_' + retorno.id).val(quantity);
                            $('.price_input_' + retorno.id).val(total_price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                            $('#btnCartButton').trigger('click');

                        } else {
                            const total_price_cart = parseFloat($('#shopCartSales').text());
                            const total = total_price_cart + parseFloat(price);
                            $('#shopCartSales').html(total.toFixed(2));

                            const new_product_array = {
                                id: retorno.id,
                                name: retorno.name,
                                price: price,
                                quantity: 1,
                                tax: imposto
                            }
                            cart_memory_json.push(new_product_array);
                            localStorage.setItem('cart', JSON.stringify(cart_memory_json));

                            $('#shopCart_Sales').append(
                                '<li class="list-group-item list_item_grid_' + retorno.id + '" data-id="' + retorno.id + '">' +
                                '<div class="row p-0 align-items-center">' +
                                '<div class="col-2 p-0 mb-1">' +
                                '<img class="icon me-1 img-fluid rounded-circle" src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt="">' +
                                '</div>' +
                                '<div class="col-8 px-1 py-0 mb-1">' +
                                '<p class="fs-12px mb-0">' + retorno.name + '</p>' +
                                '</div>' +
                                '<div class="col-2 p-0 mb-1">' +
                                '<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btnRemoverCart" data-id="' + retorno.id + '" ><i class="fas fa-trash"></i></a>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<h5 class="display-11 text-center">Quantidade</h5>' +
                                '<div class="form-control-wrap number-spinner-wrap">' +
                                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-minus remove_cart_item" data-id="' + retorno.id + '" data-number="minus-qv"><em class="icon ni ni-minus"></em></button>' +
                                '<input type="number" class="form-control number-spinner input_qtd_' + retorno.id + '" value="1" min="1" readonly="">' +
                                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-plus add_cart_item" data-id="' + retorno.id + '" data-number="plus-qv"><em class="icon ni ni-plus"></em></button>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<h5 class="display-11 text-center">Preço</h5>' +
                                '<div class="form-control-wrap">' +
                                '<input type="text" class="form-control price_input_' + retorno.id + '" value="' + retorno.price + '" readonly="">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</li>'
                            );

                            $('#btnCartButton').trigger('click');
                        }

                    } else {
                        const total_price_cart = parseFloat($('#shopCartSales').text());
                        const total = total_price_cart + parseFloat(price);
                        $('#shopCartSales').html(total.toFixed(2));

                        localStorage.setItem('cart', JSON.stringify([{
                            id: retorno.id,
                            name: retorno.name,
                            price: parseFloat(price),
                            quantity: 1,
                            tax: imposto
                        }]));

                        $('#shopCart_Sales').append(
                            '<li class="list-group-item list_item_grid_' + retorno.id + '" data-id="' + retorno.id + '">' +
                            '<div class="row p-0 align-items-center">' +
                            '<div class="col-2 p-0 mb-1">' +
                            '<img class="icon me-1 img-fluid rounded-circle" src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt="">' +
                            '</div>' +
                            '<div class="col-8 px-1 py-0 mb-1">' +
                            '<p class="fs-12px mb-0">' + retorno.name + '</p>' +
                            '</div>' +
                            '<div class="col-2 p-0 mb-1">' +
                            '<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btnRemoverCart" data-id="' + retorno.id + '" ><i class="fas fa-trash"></i></a>' +
                            '</div>' +
                            '<div class="col-6">' +
                            '<h5 class="display-11 text-center">Quantidade</h5>' +
                            '<div class="form-control-wrap number-spinner-wrap">' +
                            '<button class="btn btn-icon btn-outline-light number-spinner-btn number-minus remove_cart_item" data-id="' + retorno.id + '" data-number="minus-qv"><em class="icon ni ni-minus"></em></button>' +
                            '<input type="number" class="form-control number-spinner input_qtd_' + retorno.id + '" value="1" min="1" readonly="">' +
                            '<button class="btn btn-icon btn-outline-light number-spinner-btn number-plus add_cart_item" data-id="' + retorno.id + '" data-number="plus-qv"><em class="icon ni ni-plus"></em></button>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-6">' +
                            '<h5 class="display-11 text-center">Preço</h5>' +
                            '<div class="form-control-wrap">' +
                            '<input type="text" class="form-control price_input_' + retorno.id + '" value="' + retorno.price + '" readonly="">' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</li>'
                        );

                        $('#btnCartButton').trigger('click');
                    }

                } else {
                    Swal.fire({
                        title: 'Algo deu Errado!',
                        text: "Produto não encontrado.",
                        icon: 'error',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonText: 'Continuar'
                    }).then(function (result) {
                    });
                }
            },

        });

    });

    // ADD CART ITEM
    $('body').on('click', '.add_cart_item', function () {
        const id = $(this).attr('data-id');

        $.ajax({
            url: 'http://localhost:8000/product-only?id=' + id,
            type: 'GET',
            dataType: "JSON",
            data: {},
            success: function (retorno) {
                if (retorno.id) {
                    const decimal = retorno.price.replace(',', '.');
                    const price = decimal.replace('R$', '');
                    const imposto = (parseFloat(price) * retorno.percentage / 100);

                    const cart_memory = localStorage.getItem('cart');

                    if (cart_memory) {
                        const cart_memory_json = JSON.parse(cart_memory);
                        const product_exist = cart_memory_json.find(product => product.id === retorno.id);

                        if (product_exist) {
                            const quantity = product_exist.quantity + 1;
                            const total_price = parseFloat(price) * quantity;

                            const productIndex = cart_memory_json.filter(product => product.id !== retorno.id);

                            productIndex.push({
                                id: retorno.id,
                                name: retorno.name,
                                price: total_price,
                                quantity: quantity,
                                tax: imposto * quantity
                            });

                            localStorage.setItem('cart', JSON.stringify(productIndex));

                            const total_price_cart = parseFloat($('#shopCartSales').text());
                            const total = total_price_cart + parseFloat(price);
                            $('#shopCartSales').html(total.toFixed(2));

                            $('.input_qtd_' + retorno.id).val(quantity);
                            $('.price_input_' + retorno.id).val(total_price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                        } else {
                            const total_price_cart = parseFloat($('#shopCartSales').text());
                            const total = total_price_cart + parseFloat(price);
                            $('#shopCartSales').html(total.toFixed(2));

                            const new_product_array = {
                                id: retorno.id,
                                name: retorno.name,
                                price: price,
                                quantity: 1,
                                tax: imposto
                            }
                            cart_memory_json.push(new_product_array);
                            localStorage.setItem('cart', JSON.stringify(cart_memory_json));

                            $('#shopCart_Sales').append(
                                '<li class="list-group-item list_item_grid_' + retorno.id + '" data-id="' + retorno.id + '">' +
                                '<div class="row p-0 align-items-center">' +
                                '<div class="col-2 p-0 mb-1">' +
                                '<img class="icon me-1 img-fluid rounded-circle" src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt="">' +
                                '</div>' +
                                '<div class="col-8 px-1 py-0 mb-1">' +
                                '<p class="fs-12px mb-0">' + retorno.name + '</p>' +
                                '</div>' +
                                '<div class="col-2 p-0 mb-1">' +
                                '<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btnRemoverCart" data-id="' + retorno.id + '" ><i class="fas fa-trash"></i></a>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<h5 class="display-11 text-center">Quantidade</h5>' +
                                '<div class="form-control-wrap number-spinner-wrap">' +
                                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-minus remove_cart_item" data-id="' + retorno.id + '" data-number="minus-qv"><em class="icon ni ni-minus"></em></button>' +
                                '<input type="number" class="form-control number-spinner input_qtd_' + retorno.id + '" value="1" min="1" readonly="">' +
                                '<button class="btn btn-icon btn-outline-light number-spinner-btn number-plus add_cart_item" data-id="' + retorno.id + '" data-number="plus-qv"><em class="icon ni ni-plus"></em></button>' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<h5 class="display-11 text-center">Preço</h5>' +
                                '<div class="form-control-wrap">' +
                                '<input type="text" class="form-control price_input_' + retorno.id + '" value="' + retorno.price + '" readonly="">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</li>'
                            );

                        }

                    } else {
                        const total_price_cart = parseFloat($('#shopCartSales').text());
                        const total = total_price_cart + parseFloat(price);
                        $('#shopCartSales').html(total.toFixed(2));

                        localStorage.setItem('cart', JSON.stringify([{
                            id: retorno.id,
                            name: retorno.name,
                            price: parseFloat(price),
                            quantity: 1,
                            tax: imposto
                        }]));

                        $('#shopCart_Sales').append(
                            '<li class="list-group-item list_item_grid_' + retorno.id + '" data-id="' + retorno.id + '">' +
                            '<div class="row p-0 align-items-center">' +
                            '<div class="col-2 p-0 mb-1">' +
                            '<img class="icon me-1 img-fluid rounded-circle" src="https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg" alt="">' +
                            '</div>' +
                            '<div class="col-8 px-1 py-0 mb-1">' +
                            '<p class="fs-12px mb-0">' + retorno.name + '</p>' +
                            '</div>' +
                            '<div class="col-2 p-0 mb-1">' +
                            '<a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btnRemoverCart" data-id="' + retorno.id + '" ><i class="fas fa-trash"></i></a>' +
                            '</div>' +
                            '<div class="col-6">' +
                            '<h5 class="display-11 text-center">Quantidade</h5>' +
                            '<div class="form-control-wrap number-spinner-wrap">' +
                            '<button class="btn btn-icon btn-outline-light number-spinner-btn number-minus remove_cart_item" data-id="' + retorno.id + '" data-number="minus-qv"><em class="icon ni ni-minus"></em></button>' +
                            '<input type="number" class="form-control number-spinner input_qtd_' + retorno.id + '" value="1" min="1" readonly="">' +
                            '<button class="btn btn-icon btn-outline-light number-spinner-btn number-plus add_cart_item" data-id="' + retorno.id + '" data-number="plus-qv"><em class="icon ni ni-plus"></em></button>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-6">' +
                            '<h5 class="display-11 text-center">Preço</h5>' +
                            '<div class="form-control-wrap">' +
                            '<input type="text" class="form-control price_input_' + retorno.id + '" value="' + retorno.price + '" readonly="">' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</li>'
                        );
                    }

                } else {
                    Swal.fire({
                        title: 'Algo deu Errado!',
                        text: "Produto não encontrado.",
                        icon: 'error',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonText: 'Continuar'
                    }).then(function (result) {
                    });
                }
            },

        });

    });

    // REMOVE CART TOTAL
    $('body').on('click', '.btnRemoverCart', function () {
        const id = $(this).attr('data-id');
        $.ajax({
            url: 'http://localhost:8000/product-only?id=' + id,
            type: 'GET',
            dataType: "JSON",
            data: {},
            success: function (retorno) {
                if (retorno.id) {
                    const decimal = retorno.price.replace(',', '.');
                    const price = decimal.replace('R$', '');

                    const cart_memory = localStorage.getItem('cart');

                    if (cart_memory) {
                        const cart_memory_json = JSON.parse(cart_memory);
                        const product_exist = cart_memory_json.find(product => product.id === retorno.id);

                        if (product_exist) {
                            const productIndex = cart_memory_json.filter(product => product.id !== retorno.id);
                            localStorage.setItem('cart', JSON.stringify(productIndex));

                            const total_price_cart = parseFloat($('#shopCartSales').text());
                            const total = total_price_cart - parseFloat(price);
                            $('#shopCartSales').html(total.toFixed(2));
                            $('.list_item_grid_' + retorno.id).remove();
                        }
                    }

                } else {
                    Swal.fire({
                        title: 'Algo deu Errado!',
                        text: "Produto não encontrado.",
                        icon: 'error',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonText: 'Continuar'
                    }).then(function (result) {
                    });
                }
            },

        });

    });

});