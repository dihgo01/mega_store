$('body').on('click', '.submit_register', function () {
	$.ajax({
		url: 'http://localhost:8000/product-category',
		type: 'POST',
		dataType: "JSON",
		data: {
			'name': $(".input_name").val(),
			'tax_id': $("#tax_id").val(),
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

$('body').on('click', '.btn_update_category', function () {
	$.ajax({
		url: 'http://localhost:8000/product-category-update',
		type: 'POST',
		dataType: "JSON",
		data: {
			'id': $(".input_id").val(),
			'name': $(".input_name").val(),
			'tax_id': $("#tax_id").val(),
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
});

$('body').on('click', '.btn_delete_category', function () {
	const id = $(this).attr('data-id');
	Swal.fire({
		title: "Confirmação",
		text: 'Deseja realmente excluir essa categoria?',
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#0ab39c",
		cancelButtonColor: "#6e7881",
		confirmButtonText: 'Sim, excluir!',
		cancelButtonText: "Voltar",
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: 'http://localhost:8000/product-category-delete',
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

