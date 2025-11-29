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

                        url: "<?= base_url("klog-list-table".$w) ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'ssid','full_name','ip','http_user_agent','user_id','description','title','status','date','status','action'],

                        },

                    },

                    "language":{

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        {data: 'ssid' },

                        {data: 'full_name'},

                        {data: 'title'},

                        {data: 'description'},

                        {data: 'date'},

                        {data: 'ip'},
                        {data: 'http_user_agent'},

                        {data: 'status'},

                    ],



                    order: [[ 4, "desc" ]],

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

                                if(row.user_id==0){

                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><a href="" /><i class="fas fa-users-slash" style="color:#3699FF; font-size:10pt;"></i>&nbsp Üye Yok</a></span>';

                                }else{

                                    if(row.full_name==""){

                                        return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.nick_name + '</a></span>';

                                    }else{

                                        return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.full_name + '</a></span>';

                                    }

                                }

                            }

                        },

                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:2,

                        },

                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:3,

                        }, {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:4,

                        },{

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

                                    return '<span style="height:auto;" class="label label-inline label-light-warning text-primary font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-cog text-primary "></i> İşlem</span>';

                                }else if(row.status==2){

                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-info-circle"></i> Hatalı İşlem</span>';

                                }else if(row.status==3){

                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-secret  text-danger"></i>Saldırı</span>';

                                }

                            }

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