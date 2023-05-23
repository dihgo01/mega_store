$(document).ready(function () {
    const storage_cart = localStorage.getItem('cart');

    if (storage_cart) {
        const cart_memory_checkout = JSON.parse(storage_cart);

        if (cart_memory_checkout) {
            let subtotal = 0;
            let imposto = 0;

            $(cart_memory_checkout).each(function (index, value) {
                const total = value.price - value.tax;
                subtotal += value.price;
                imposto += value.tax;

                $('#recebeProdutosVenda').append(
                    '<tr class="row-vertical-align linhaProdutos table_line_sale_' + value.id + '" >' +
                    '<td class="p-3">' + index + '</td>' +
                    '<td class="p-3">' + value.name + '</td>' +
                    '<td class="text-center p-3">R$ ' + value.price.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</td>' +
                    '<td class="text-center p-3">' +
                    '<div class="form-control-wrap number-spinner-wrap">' +
                    value.quantity +
                    '</div>' +
                    '</td>' +
                    '<td class="text-center p-3">R$ '
                    + value.tax.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) +
                    '</td>' +
                    '<td class="text-center p-3">R$ '
                    + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) +
                    '</td>' +
                    '</tr>'
                );
            });
            let total = subtotal - imposto;
            $('.price_subtotal').text("R$ " + subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('.price_tax').text("R$ " + imposto.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('.price_total').text("R$ " + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
    }

    $('body').on('click', '.btn_save_sales', function () {
        let validate = true;
        const token = localStorage.getItem('token');
        const storage = localStorage.getItem('cart')
        const array_products = [];
        let subtotal_price = 0;
        let tax_price = 0;
        let message = '';

        if (storage) {
            const products = JSON.parse(storage)
            $(products).each(function (index, value) {
                const total = value.price - value.tax;
                subtotal_price += value.price;
                tax_price += value.tax;
                array_products.push({
                    product_id: value.id,
                    amount: value.quantity,
                    price: value.price,
                });
            });
        } else {
            validate = false;
            message = 'Você precisa de produtos no carrinho para realizar a compra';
        }

        if (!token) {
            validate = false;
            message = 'Você precisa estar logado para realizar a compra';
        }

        if (array_products.length == 0) {
            validate = false;
            message = 'Você precisa de produtos no carrinho para realizar a compra';
        }

        if (validate) {
            $.ajax({
                url: 'http://localhost:8000/sales',
                type: 'POST',
                dataType: "JSON",
                headers: {
                    'authorization': 'Bearer ' + token
                },
                data: {
                    'price': subtotal_price - tax_price,
                    'status': "Pendente",
                    'products': array_products,
                },
                success: function (retorno) {
                    if (retorno.data.id) {
                        Swal.fire({
                            title: 'Tudo OK',
                            text: retorno.message,
                            icon: 'success',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            confirmButtonText: 'Continuar'
                        }).then(function (result) {

                            localStorage.removeItem('cart')
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Algo deu Errado!',
                            text: retorno.message,
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
        } else {
            Swal.fire({
                title: 'Por favor!',
                text: message,
                icon: 'error',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showCancelButton: false,
                confirmButtonText: 'Continuar'
            }).then(function (result) {
            });
        }
    });
})