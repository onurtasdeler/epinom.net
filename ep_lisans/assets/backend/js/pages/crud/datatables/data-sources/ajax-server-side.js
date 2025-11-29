/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!******************************************************************************!*\
  !*** ../demo1/src/js/pages/crud/datatables/data-sources/ajax-server-side.js ***!
  \******************************************************************************/

var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {

		var table = $('#kt_datatable');
		$('#kt_datatable thead th').each( function (i) {
			var sayac=1;
			var title = $(this).text();
			if(title!="İşlemler" && title!="Durum" && title!="Kayıt Tarihi"){
				$(this).html( '<input class="form-control" id="arama_input_' + i + '" type="text" placeholder=" '+ title+'" />' );
			}
		});

		// begin first table
		table.DataTable({
			sDom:'lrtip',
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: {
				url: HOST_URL + 'uye-liste-table',
				type: 'POST',
				data: {
					// parameters for custom backend script demo
					columnsDef: [

						'ssid','user_m_ad',
						'user_m_kad', 'user_m_mail', 'user_m_onay_date_time',
						'user_m_email_onay',,'action'],
				},
			},
			"language":{
				"url":"assets/backend/js/dil.json"
			},
			columns: [
				{data: 'ssid'},
				{data: 'user_m_ad'},
				{data: 'user_m_kad'},
				{data: 'user_m_mail'},
				{data: 'user_m_onay_date_time'},
				{data: 'user_m_email_onay'},
				{data: 'action', responsivePriority: -1,searchable:false},
			],

			columnDefs: [
				{
					orderable:false,
					searchable:false,
					visible:false,
					targets:0
				},
				{
					orderable:false,
					searchable:true,
					targets:1
				},
				{
					orderable:true,
					searchable:false,
					targets:4
				},
				{
					orderable:false,
					searchable:true,
					targets:2
				},
				{
					targets: -1,
					title: 'İşlemler',
					orderable: false,
					searchable:false,
					render: function(data, type, full, meta) {
						return '\
							<div class="dropdown dropdown-inline">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
	                                <i class="la la-cog"></i>\
	                            </a>\
							  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
									<ul class="nav nav-hoverable flex-column">\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li>\
									</ul>\
							  	</div>\
							</div>\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						';
					},
				},
				{
					width: '75px',
					targets: -2,
					orderable:false,
					render: function(data, type, full, meta) {
						var status = {
							0: {'title': 'Onaylanmadı', 'class': ' label-light-danger'},
							1: {'title': 'Onaylandı', 'class': ' label-light-success'},
							2: {'title': 'Delivered', 'class': ' label-light-danger'},
							3: {'title': 'Canceled', 'class': ' label-light-primary'},
							4: {'title': 'Success', 'class': ' label-light-success'},
							5: {'title': 'Info', 'class': ' label-light-info'},
							6: {'title': 'Danger', 'class': ' label-light-danger'},
							7: {'title': 'Warning', 'class': ' label-light-warning'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
					},
				}

			],
			"initComplete": function () {
				// Apply the search
				this.api().columns().every( function () {
					var that = this;
					var searchText=$(this.header()).find('input');
					searchText.on( 'keyup change clear', function () {
						if ( that.search() !== this.value ) {
							that.search( this.value).draw();
						}
					});
					searchText.on("click", function (e) {
						e.stopPropagation();
					});
				});
			}
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
	$("#kt_datatable_filter").hide();
});

/******/ })()
;
//# sourceMappingURL=ajax-server-side.js.map