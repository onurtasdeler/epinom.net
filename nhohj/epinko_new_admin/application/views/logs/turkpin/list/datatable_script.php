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
                        url: "<?= base_url("turkpin-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','cdate','adet','pri','order_id','data','p_name','stat','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'p_name'},
                        {data: 'adet'},
                        {data: 'pri'},
                        {data: 'data'},
                        {data: 'cdate'},
                        {data: 'stat'},

                    ],

                    order: [[ 5, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0,
                            type: "num"
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:1,
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                            "render": function (data, type, row) {
                                var obj = jQuery.parseJSON( row.data );
                                if(obj){
                                    if(obj.HATA_NO=="000"){
                                        var str='Hata No:' + obj.HATA_NO + ' <br> ';
                                        str += 'Hata Açıklama: <span class="">' + obj.HATA_ACIKLAMA + ' <br> ';
                                    }else{
                                        var str='Hata No:' + obj.HATA_NO + ' <br> ';
                                        str += 'Hata Açıklama: <span class="text-danger">' + obj.HATA_ACIKLAMA + ' </span><br> ';
                                    }

                                }
                                return str;
                            }
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:5,

                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.stat==1){
                                    if(row.order_id!=0){
                                        return '<span style="height:auto;" class="label label-inline label-light-success text-primary font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-cog text-primary "></i> Başarılı</span><br> <a href="<?= base_url("siparis-guncelle/") ?>' + row.order_id + '">Siparişe Git</a>';
                                    }else{
                                        return '<span style="height:auto;" class="label label-inline label-light-success text-primary font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-cog text-primary "></i> Başarılı</span><br> ';

                                    }
                                }else if(row.stat==58){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-window-close"></i> İşlem Red</span>';
                                }else if(row.stat==3){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-secret  text-danger"></i>Saldırı</span>';
                                }else if(row.stat==5){
                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-cog text-success"></i>Otomatik İşlem</span>';
                                }else if(row.stat==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-cog text-danger"></i>Başarısız</span>';
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