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

                        url: "<?= base_url("ads-order-list-table".$w) ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'ssid','uyeadi','tt','sl','saticiadi','mname','tss','kullanici_iptal','selluserid',"sipNo","ad_name","advert_id",'userid','quantity','price','price_total','status','invoice_id','invoice_date','cdate','action'],

                        },

                    },

                    "language":{

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        {data: 'sipNo'  },

                        {data: 'uyeadi'  },

                        {data: 'saticiadi'  },

                        {data: 'ad_name'   },

                        {data: 'price'  },

                        {data: 'quantity'  },

                        {data: 'price_total'  },

                        {data: 'cdate' },

                        {data: 'status'},

                        {data: 'invoice_id'},
                        
                        {data: 'invoice_date'},

                        {data: 'action', responsivePriority: -1,searchable:false},

                    ],



                    order: [[ 7, "asc" ],[6,"asc"]],

                    columnDefs: [

                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:0,



                        },{

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:1,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a target="blank"  href="<?= base_url("uye-guncelle/") ?>' + row.userid +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.uyeadi + "</a></span>";

                            }

                        },{

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:2,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><a target="blank" href="<?= base_url("magaza-basvurulari-guncelle/") ?>' + row.tss +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.mname + "</a></span>";

                            }

                        },{

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:3,

                            "render": function (data, type, row) {

                                return '<a target="_blank" style="" href="<?= base_url("ilan-guncelle/") ?>' + row.advert_id +'" />' + row.ad_name + '</a>';

                            }

                        },

                        {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:4,

                            "render": function (data, type, row) {

                                return row.price + " <?= getcur() ?>";

                            }

                        }, {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:5,

                        }, {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:6,

                            "render": function (data, type, row) {

                                return row.price_total + " <?= getcur() ?>";

                            }

                        }, {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:7,

                        },

                        {

                            orderable:true,

                            searchable:false,

                            targets:8,

                            "render": function (data, type, row) {

                                if(row.status==0){

                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-user" style="color:#FFA800"></i>&nbsp  Satıcı Bekleniyor</span>';

                                }else if(row.status==1){

                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i class="fas fa-user" style="font-size:9pt; margin-right:2px;color:#FFA800"></i> &nbsp; Alıcı Bekleniyor</span>';

                                }else if(row.status==2){

                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-clock" style="font-size:9pt; margin-right:2px;"></i> &nbsp; Yönetici Onayı Bekliyor</span>';

                                }else if(row.status==3){

                                    if(row.tt==1){

                                        return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i class="fas fa-check" style="font-size:9pt; margin-right:2px;"></i> &nbsp;Tamamlandı</span> <br> <small class="text-info">Otomatik Teslimat <br><b>'+ row.sl +  '</b></small>';

                                    }else{

                                        return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i class="fas fa-check" style="font-size:9pt; margin-right:2px;"></i> &nbsp;Tamamlandı</span>';



                                    }

                                }else if(row.status==4){

                                    if(row.kullanici_iptal==1){

                                        return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i class="fas fa-window-close" style="font-size:9pt; margin-right:2px;"></i> &nbsp; Kullanıcı Tarafından Edildi</span>';



                                    }else{

                                        return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i class="fas fa-window-close" style="font-size:9pt; margin-right:2px;"></i> &nbsp; İptal Edildi</span>';



                                    }

                                }

                            }

                        },{

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:9,

                            "render": function (data, type, row) {

                                if(row.invoice_id==""){

                                    return '<a href="<?= base_url("siparis-komisyon-faturalandir/") ?>' + row.ssid +'" class="btn btn-sm btn-danger" />Faturala</a>';

                                }else{

                                    return '<a target="_blank" class="btn btn-sm btn-success" style="" href="<?= base_url("fatura-komisyon-goruntule/") ?>' + row.invoice_id +'" />Faturalandı</a>';
                                }

                            }

                        }, {

                            orderable:true,

                            searchable:true,

                            visible:true,

                            targets:10,
                            "render": function (data, type, row) {

                                if(row.invoice_id==""){

                                    return '<span class="badge badge-warning">Fatura Oluşturulmamış</span>';

                                }else{

                                    return data;
                                }

                            }

                        },

                        {

                            targets: -1,

                            title: 'İşlemler',

                            orderable: false,

                            searchable:false,

                            render: function(data, type,row) {

                                return  '<a href="<?= base_url('ilan-siparis-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+

                                    '<i class="la la-edit text-warning"></i></a>'+

                                    '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';

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

                                    that.search( jQuery.fn.DataTable.ext.type.search.string(this.value)).draw();

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