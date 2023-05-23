$(document).ready(function () {

	const token = localStorage.getItem('token');

	$('#responsive-datatable').DataTable({
		dom: 'rt<"bottom px-2 mb-1 mt-2 clearfix"<"row"<"col-6"i><"col-6"p>>>',
		columnDefs: [
			{ orderable: false, "targets": "_all", "visible": true }
		],
		"columns": [
			{
				className: "nk-tb-col text-center",
				data: "created_at",
				render: function (data, type, row) {
					return moment(data).format('DD/MM/YYYY');
				}
			},
			{
				className: "nk-tb-col text-center",
				data: "price"
			},
			{
				className: "nk-tb-col text-center",
				data: "status"
			}

		],
		scrollX: true,
		paging: true,
		order: [[0, "desc"]],
		fixedColumns: {
			left: 2,
		},
		ajax: {
			"url": 'http://localhost:8000/sales',
			"type": "GET",
			headers: {
				'authorization': 'Bearer ' + token
			},
			"data": function (d) {
			}
		},
		responsive: true,
		language: { url:"/inc/datatables/json/Portuguese-Brasil.json" }
	});
	

})