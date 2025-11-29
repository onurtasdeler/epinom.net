<?php

$w=0;



if($itemsSub){

    $w=$items->id;

}else{

    $w=0;

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

                        url: "<?= base_url("referans-kazanclari-list-table") ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'sipNo','uFullName','ruFullName',"amount",'status',"created_at",'action'],

                        },

                    },

                    "language":{

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        {data: 'sipNo' },

                        {data: 'uFullName'},

                        {data: 'ruFullName'},

                        {data: 'amount'},

                        {data: 'status'},

                        {data: 'created_at'},

                        {data: 'action', responsivePriority: -1,searchable:false},

                    ],



                    order: [[5, "desc" ]],

                    columnDefs: [

                        {

                            orderable:true,

                            searchable:false,

                            visible:true,

                            targets:0

                        },

                        {

                            orderable:false,

                            searchable:false,

                            targets:1,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.uId +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.uFullName + "</a></span>";

                            }

                        },

                        {

                            orderable:false,

                            searchable:false,

                            targets:2,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.ruId +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.ruFullName + "</a></span>";

                            }

                        },

                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:3,

                        }, 

                        {

                            orderable:false,

                            searchable:false,

                            targets:4,

                            "render": function (data, type, row) {

                                if(row.status==0){

                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-clock"></i> Reddedildi</span>';

                                }else if(row.status==1){

                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-close"></i> Onaylandı</span>';

                                }

                            }

                        },
                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:5,

                        },

                        {

                            targets: -1,

                            title: 'İşlemler',

                            orderable: false,

                            searchable:false,

                            render: function(data, type,row) {
                                
                                return '<a href="javascript:void(0)" onclick="updateRefOrderStatus('+ row.id +','+ (row.status == 0 ? 1:0) +')" class="btn btn-sm btn-primary" title="Durum Değiştir">' +
                                'Durum Değiştir</a>';

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
    function updateRefOrderStatus(id,status) {
        $.post("<?= base_url('referans-kazanclari-durum-guncelle') ?>/"+id+"/"+status,{},function(response){

        if(response){

            alertToggle(1,"Referans kazanç durumu güncellendi.","İşlem Başarılı");

            setTimeout(function(){ window.location.reload(); }, 400);

        }else{

            alertToggle(2,"Bir hata meydana geldi.","Hata");

        }

        });
    }
    //# sourceMappingURL=ajax-server-side.js.map

</script>