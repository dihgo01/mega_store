$('body').on('click', '.submit_register_product', function () {
    let valid = true;
	const price = $(".input_price").val();
	const decimal = price.replace(',', '.');
	const price_format = parseFloat(decimal.replace('R$ ', ''));

    $('.required').each(function () {
        if ($(this).val() == '') {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (valid) {
        $.ajax({
            url: 'http://localhost:8000/product',
            type: 'POST',
            dataType: "JSON",
            data: {
                'name_product': $(".input_name").val(),
                'price': price_format,
				'category_id': $("#category_id").val(),
            },
            success: function (retorno) {
                console.log(retorno);
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
    }else{
		Swal.fire({
			title: 'Por favor!',
			text: 'Preencha todos os campos',
			icon: 'error',
			allowEscapeKey: false,
			allowOutsideClick: false,
			showCancelButton: false,
			confirmButtonText: 'Continuar'
		}).then(function (result) {
		});
	}
});

$('body').on('click', '.btn_update_product', function () {
    let valid = true;
	const price = $(".input_price").val();
	const decimal = price.replace(',', '.');
	const price_format = parseFloat(decimal.replace('R$ ', ''));


    $('.required').each(function () {
        if ($(this).val() == '') {
            valid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    if (valid) {
        $.ajax({
            url: 'http://localhost:8000/product-update',
            type: 'POST',
            dataType: "JSON",
            data: {
                'id': $(".input_id").val(),
                'name_product': $(".input_name").val(),
                'price': price_format,
				'category_id': $("#category_id").val(),
            },
            success: function (retorno) {
                console.log(retorno);
                if (retorno.data) {
                    Swal.fire({
                        title: 'Tudo OK',
                        text: retorno.message,
                        icon: 'success',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showCancelButton: false,
                        confirmButtonText: 'Continuar'
                    }).then(function (result) {
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

        })
    }else{
		Swal.fire({
			title: 'Por favor!',
			text: 'Preencha todos os campos',
			icon: 'error',
			allowEscapeKey: false,
			allowOutsideClick: false,
			showCancelButton: false,
			confirmButtonText: 'Continuar'
		}).then(function (result) {
		});
	}
});

$('body').on('click', '.btn_delete_product', function () {
    const id = $(this).attr('data-id');
    Swal.fire({
        title: "Confirmação",
        text: 'Deseja realmente excluir esse produto?',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#0ab39c",
        cancelButtonColor: "#6e7881",
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: "Voltar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'http://localhost:8000/product-delete',
                type: 'POST',
                dataType: "JSON",
                data: {
                    'id': id,
                },
                success: function (retorno) {
                    if (retorno.data) {
                        Swal.fire({
                            title: 'Tudo OK',
                            text: retorno.message,
                            icon: 'success',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            confirmButtonText: 'Continuar'
                        }).then(function (result) {
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
        }
    });
});