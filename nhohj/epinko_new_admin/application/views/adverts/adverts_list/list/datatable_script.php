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
                        url: "<?= base_url("ads-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','ad_name','magaza_name','type','is_updated','end','cat_name','price','user_id','status','cdate','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'full_name'  },
                        {data: 'ad_name'   },
                        {data: 'cat_name'  },
                        {data: 'price'  },
                        {data: 'cdate'  },
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 5, "asc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:0,
                            "render": function (data, type, row) {
                                return '<span class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("magaza-basvurulari-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.magaza_name + "</a></span>";
                            }
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:1,
                            "render": function (data, type, row) {
                                if(row.type==1){
                                    if(row.is_doping==1){
                                        return row.ad_name + '<br><small class="text-primary">Stoklu İlan</small> <br> <small><i class="fa fa-star text-warning"></i> Vitrin İlanı -  Bitiş Tarihi: ' + row.end + '</small>';

                                    }else{
                                        return row.ad_name + '<br><small class="text-primary">Stoklu İlan</small> <br>';

                                    }
                                }else{
                                    if(row.is_doping==1){
                                        return row.ad_name + '<br><small class="text-info">Stoksuz İlan</small> <br>  <small><i class="fa fa-star text-warning"></i> Vitrin İlanı -  Bitiş Tarihi: ' + row.end + '</small>';

                                    }else{
                                        return row.ad_name + '<br><small class="text-info">Stoksuz İlan</small>';

                                    }
                                }
                            }
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2
                        },
                        /*{
                            orderable:false,
                            searchable:false,
                            targets:2,
                            "render": function (data, type, row) {
                                if(row.simage){
                                    return '<img src="../upload/product/' + row.simage + '" height="75" width="75"/>';
                                }else{
                                    return "Resim Eklenmemiş";
                                }
                            }
                        },*/
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                            "render": function (data, type, row) {
                                return row.price + " <?= getcur() ?>";
                            }
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:5,
                            "render": function (data, type, row) {
                                if(row.status==0){
                                    if(row.is_updated==1){
                                        return '<span class="label label-inline label-light-warning font-weight-bold"><i class="fa fa-clock" style="color:#FFA800; font-size:8pt;"></i>&nbsp  Güncellendi -  Onay Bekleniyor</span>';
                                    }else{
                                        return '<span class="label label-inline label-light-warning font-weight-bold"><i class="fa fa-clock" style="color:#FFA800; font-size:8pt;"></i>&nbsp  Beklemede</span>';

                                    }
                                }else if(row.status==1){
                                    return '<span class="label label-inline label-light-success font-weight-bold"> <i class="text-success fa fa-check" style="color:#FFA800; font-size:8pt;"></i>&nbsp  Onaylandı</span>';
                                }else if(row.status==2){
                                    return '<span class="label label-inline label-light-danger font-weight-bold"> <i class="text-danger fa fa-window-close" style="color:#FFA800; font-size:8pt;"></i>&nbsp  Reddedildi</span>';
                                }else if(row.status==4){
                                    if(row.type==1){
                                        return '<span class="label label-inline label-light-primary font-weight-bold"><i class=" text-info fa fa-shopping-basket" style="color:#FFA800; font-size:8pt;"></i>&nbsp Kısmen Satıldı</span>';
                                    }else{
                                        return '<span class="label label-inline label-light-info font-weight-bold"><i class=" text-info fa fa-shopping-basket" style="color:#FFA800; font-size:8pt;"></i>&nbsp Satıldı</span>';
                                    }
                                }else if(row.status==6){
                                    return '<span class="label label-inline label-light-info font-weight-bold"><i class=" text-info fa fa-shopping-basket" style="color:#FFA800; font-size:8pt;"></i>&nbsp Satıldı</span>';
                                }else if(row.status==8){
                                    return '<span class="label label-inline label-light-danger font-weight-bold"><i class=" text-danger fa fa-trash" style="color:#FFA800;font-size:8pt;"></i>&nbsp Silindi</span>';
                                }
                            }
                        },

                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return  '<a href="<?= base_url('ilan-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                                    '<i class="la la-edit text-warning"></i></a>'+
                                    '<a href="<?= base_url('ilan-sohbetler/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Sohbetler">'+
                                    '<i class="fa fa-comments text-info"></i></a>'+
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