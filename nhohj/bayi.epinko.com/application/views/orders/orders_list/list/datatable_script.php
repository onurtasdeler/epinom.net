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
                        url: "<?= base_url("order-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','full_name',"sipNo",'nick_name',"product_id",'image_urun','cat_name','quantity','price','user_id','status','cdate','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'sipNo'  },
                        {data: 'nick_name'  },
                        {data: 'p_name'   },
                        {data: 'price'  },
                        {data: 'quantity'  },
                        {data: 'total_price'  },
                        {data: 'cdate' },
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 6, "desc" ]],
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
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="javascript:;' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.nick_name + "</a></span>";
                            }
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                            "render": function (data, type, row) {
                                if(row.image_urun==null){
                                    return '<a target="_blank" style="" href="<?= base_url("urun-guncelle/") ?>' + row.product_id +'" /><div style="padding:4px; " class="row"><div class="col-lg-3">' +
                                        '<img class="rounded" width="25" height="25" src="../assets/images/noimage.webp"></div><div class="col-lg-9">' + row.p_name + '</div></div></a>';

                                }else{
                                    return '<a target="_blank" style="" href="<?= base_url("urun-guncelle/") ?>' + row.product_id +'" /><div style="padding:4px; " class="row"><div class="col-lg-3">' +
                                        '<img class="rounded" width="25" height="25" src="../../../../../upload/product/' + row.image_urun + '"></div><div class="col-lg-9">' + row.p_name + '</div></div></a>';

                                }
                            }
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
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:5,
                            "render": function (data, type, row) {
                                return row.total_price + " <?= getcur() ?>";
                            }
                        }, {
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
                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-clock" style="color:#FFA800"></i>&nbsp  Beklemede</span>';
                                }else if(row.status==3){
                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i class="fas fa-clock" style="font-size:9pt; margin-right:2px;color:#FFA800"></i> &nbsp; Hazırlanıyor</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i class="fas fa-check" style="font-size:9pt; margin-right:2px;color:#249f68"></i> &nbsp; Teslim Edildi</span>';
                                }else if(row.status==5){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i class="fas fa-window-close" style="font-size:9pt; margin-right:2px;"></i> &nbsp; İptal Edildi</span>';
                                }
                            }
                        },

                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return  '<a href="<?= base_url('siparis-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                                    '<i class="la la-edit text-warning"></i></a>';

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