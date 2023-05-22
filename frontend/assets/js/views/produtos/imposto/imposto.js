
$('body').on('click', '.submit_register_tax', function () {
    $.ajax({
        url: 'http://localhost:8000/tax',
        type: 'POST',
        dataType: "JSON",
        data: {
            'name': $(".input_name").val(),
            'percentage': $(".input_percentage").val(),
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
});

$('body').on('click', '.btn_update_tax', function () {
    $.ajax({
        url: 'http://localhost:8000/tax-update',
        type: 'POST',
        dataType: "JSON",
        data: {
            'id': $(".input_tax_id").val(),
            'name': $(".input_name").val(),
            'percentage': $(".input_percentage").val(),
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

    });
});

$('body').on('click', '.btn_delete_tax', function () {
	const id = $(this).attr('data-id');
	Swal.fire({
		title: "Confirmação",
		text: 'Deseja realmente excluir esse imposto?',
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#0ab39c",
		cancelButtonColor: "#6e7881",
		confirmButtonText: 'Sim, excluir!',
		cancelButtonText: "Voltar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: 'http://localhost:8000/tax-delete',
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
