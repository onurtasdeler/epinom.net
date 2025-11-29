<?php
$w="";

if($this->input->get("u")){
    $w="?u=".$this->input->get("u");
}else{
    $w="";
}

?>
<script>
    /******/ (() => { // webpackBootstrap
        /******/ 	"use strict";
        var __webpack_exports__ = {};
        /*!******************************************************************************!*\
          !*** ../demo1/src/js/pages/crud/datatables/data-sources/ajax-server-side.js ***!
          \******************************************************************************/

        var KTDatatablesDataSourceAjaxServer = function() {

            var initTable1 = function() {

                var table = $('#kt_datatable');


                // begin first table
                table.DataTable({

                    responsive: true,
                    searchDelay: 100,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url("odeme-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','nick_name','advert_id',"adet",'user_id',"qty","order_id",'description','quantity','status','cdate','status','type','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'nick_name'},
                        {data: 'type'},
                        {data: 'qty'},
                        {data: 'quantity'},
                        {data: 'description'},
                        {data: 'cdate'},
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 6, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0,
                            type: "num"
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:1,
                            "render": function (data, type, row) {
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.nick_name + "</a></span>";
                            }
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:2,
                            "render": function (data, type, row) {
                                if(row.type==0){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-primary fa-arrow-down"></i>Girdi</span>';
                                }else{
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-arrow-up"></i>Çıktı</span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                            "render": function (data, type, row) {
                                return row.quantity + " TL";
                            }
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:5,
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:6,
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:7,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning text-primary font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-primary fa-clock"></i> Previzyonda</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-success fa-check"></i> Bakiyeden Düşüldü</span>';
                                }else if(row.status==3){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-reply-all"></i>İade Edildi</span>';
                                }
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                if(row.advert_id!=0){
                                    return '<a href="<?= base_url('ilan-siparis-guncelle/') ?>'+ row.order_id +'" class="btn btn-sm btn-clean btn-icon" title="Siparişe Git">'+
                                        '<i class="la la-arrow-right text-info"></i></a>'+
                                        '';
                                }else{
                                    return "-";
                                }

                            },
                        },
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
</script>