<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>


<script>
    <?php $user=getActiveUsers();
    $ilans=getLangValue(34,"table_pages");
    $ilanss=getLangValue(36,"table_pages");
    ?>

    var delets="";
    var doping="";

    function modalGoster2(veri="",ad=""){
        if(veri){
            delets=veri;
            $("#placebidModal2 #isim").html(ad);
            $("#placebidModal2").modal("show");
        }
    }
    function yukariTasi(id="") {
        $.ajax({
            url:"<?= base_url("up-your-advert") ?>",
            type:"POST",
            data: {id:id},
            success:function(response) {
                if(response) {
                    if(response.hata == "var") {
                        toastr.warning(response.message)
                    } else {
                        toastr.success(response.message)
                    }
                }
            }
        })
    }

    function modalGoster(veri="",type=0){
        if(type==0){
            $.ajax({
                url: "<?= base_url("get-info-doping") ?>",
                type: 'POST',
                data: {token:veri,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if (response) {
                        if (response.hata == "var") {
                            doping="";
                            if(response.type=="balance"){
                                doping="";
                                toastr.warning(response.message);
                                $("#uyCont4 .alert").html(response.message);
                                $("#uyCont4").fadeIn(500);
                                $("#delete_button").prop("disabled", false);
                            }else{
                                doping="";
                                toastr.warning()
                                $("#uyCont4 .alert").html(response.message);
                                $("#uyCont4").fadeIn(500);
                                $("#delete_button").prop("disabled", false);
                            }
                        } else {
                            doping=veri;
                            $("#dopIlan").html(response.ilan);
                            $("#placebidModal3").modal("show");
                        }
                    } else {
                        window.location.reload();
                    }
                },
                cache:false,
            });
        }else{
            $.ajax({
                url: "<?= base_url("get-info-doping") ?>",
                type: 'POST',
                data: {veri:delets,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if (response) {
                        if (response.hata == "var") {
                            if(response.type=="balance"){
                                doping="";
                                toastr.warning(response.message);
                                $("#uyCont4 .alert").html(response.message);
                                $("#uyCont4").fadeIn(500);
                                $("#delete_button").prop("disabled", false);
                            }else{
                                doping="";
                                toastr.warning()
                                $("#uyCont4 .alert").html(response.message);
                                $("#uyCont4").fadeIn(500);
                                $("#delete_button").prop("disabled", false);
                            }

                        } else {
                            $("#uyCont4 .alert").removeClass("alert-warning").addClass("alert-success");
                            $("#uyCont4 .alert").html(response.message);
                            $("#uyCont4").fadeIn(500);
                            $("#delete_button").remove();

                            $(".deletedd").remove();
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                    } else {
                        window.location.reload();
                    }
                },
                cache:false,
            });
        }
    }



    $('#placebidModal2').on('hidden.bs.modal', function () {
        // do something…
        delets="";
    })
    $('#placebidModal3').on('hidden.bs.modal', function () {
        // do something…
        doping="";
    })

    $("#delete_button").on("click",function (){
        if(delets){
            $("#delete_button").prop("disabled",true);
            $.ajax({
                url: "<?= base_url("set-product-delete") ?>",
                type: 'POST',
                data: {veri:delets,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if (response) {
                        if (response.hata == "var") {
                            $("#uyCont4 .alert").html(response.message);
                            $("#uyCont4").fadeIn(500);
                            
                            $("#delete_button").prop("disabled", false);
                        } else {
                            $("#uyCont4 .alert").removeClass("alert-warning").addClass("alert-success");
                            $("#uyCont4 .alert").html(response.message);
                            $("#uyCont4").fadeIn(500);
                            $("#delete_button").remove();
                            $(".deletedd").remove();
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                    } else {
                        window.location.reload();
                    }
                },
                cache:false,
            });
        }else{
            window.location.reload();
        }
    });

    $(document).ready(function (){

        $("#feature_button").on("click",function (){
           if(doping!=""){
               if($("#mainCategory").val()){
                   $.ajax({
                       url: "<?= base_url("set-doping") ?>",
                       type: 'POST',
                       data: {token:doping,selects:$("#mainCategory").val(),lang:"<?= $_SESSION["lang"] ?>"},
                       success: function (response) {
                           if(response.hata=="yok"){
                               $("#feature_button").remove();
                                $("#returnss .alert").html(response.message);
                                $("#returnss").fadeIn(300);
                           }else{
                               if(response.type=="balance"){
                                   toastr.warning(response.message);
                                   $("#dopPrice").html(response.price);
                                   $("#dopIlan").html(response.ilan);
                                   $("#dopBalance").removeClass("text-success").addClass("text-danger").html(response.message);
                                   $("#dopDate").removeClass("text-success").addClass("text-danger").html("-");
                                   setTimeout(function (){
                                       window.location.reload();
                                   },2000);
                               }
                           }
                       },
                   });
               }else{
                   toastr.warning("<?= ($_SESSION["lang"]==1)?"Lütfen Paket Seçiniz":"Please Select Packet" ?>")
               }
           }else{
               toastr.warning("<?= ($_SESSION["lang"]==1)?"Bu İşlem Şu An Gerçekleştirilemez":"This Operation Cannot Be Performed Now" ?>")
           }
        });


        $("#mainCategory").select2({
            dropdownParent: $('#placebidModal3 .modal-content')
        });
        $('.selects#mainCategory').on('select2:select', function (e) {
            var data = e.params.data;
            if(data.id){
                $.ajax({
                    url: "<?= base_url("get-info-doping-type") ?>",
                    type: 'POST',
                    data: {token:doping,selects:data.id,lang:"<?= $_SESSION["lang"] ?>"},
                    success: function (response) {
                        if(response.hata=="yok"){
                            $("#dopPrice").html(response.price);
                            $("#dopIlan").html(response.ilan);
                            $("#dopBalance").removeClass("text-danger").addClass("text-success").html(response.balance);
                            $("#dopDate").removeClass("text-danger").addClass("text-success").html(response.ends);
                        }else{
                            if(response.type=="balance"){
                                $("#dopPrice").html(response.price);
                                $("#dopIlan").html(response.ilan);
                                $("#dopBalance").removeClass("text-success").addClass("text-danger").html(response.message);
                                $("#dopDate").removeClass("text-success").addClass("text-danger").html("-");
                            }
                        }
                    },
                });
            }else{

            }

        });

        var table = $('#kt_datatable');
        table.DataTable({
            responsive: true,
            searchDelay: 500,
            "language":{    
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom:'rtip',
            serverSide: true,
            order: [[0, "desc"]],
            ajax: {
                url: "<?= base_url("get-my-post-list") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ilanNo','redNedeni','ilanAdi','satAdet','sip','dop','ilanLink','ilanType','ilanFiyat','dopEnd','ilanDoping','stokAdet','ilanResim','ilanDurum','action'],
                },
            },

            columns: [
                {data: 'id',orderable: false, searchable: false,},
                {data: 'ilanResim', orderable: false, searchable: false, responsivePriority:0},
                {data: 'ilanNo', responsivePriority: 0},
                {data: 'ilanAdi', responsivePriority: -2},
                {data: 'ilanTarih', responsivePriority: 0},
                {data: 'ilanType', responsivePriority: 0},
                {data: 'ilanFiyat', responsivePriority: 0},
                {data: 'ilanDurum', responsivePriority: 0},
                {data: 'action', responsivePriority: 0, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    visible: false,
                    targets: 0,

                },
                {
                    orderable: false,
                    targets: 1,
                    searchable: false,
                    "render": function (data, type, row) {
                        return "<img  class='img-fluid tableImages' style='border-radius:10%' src='<?= base_url("upload/ilanlar/") ?>" + row.ilanResim + "'>" ;
                    }
                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 2,
                    "render": function (data, type, row) {
                        return "<a style='font-size: 11px;width:100%;text-decoration: none;' href='<?= base_url(gg().$ilans->link."/") ?>" +row.ilanLink+ "' target='_blank' class='btn btn-secondary trss'><i class='fa fa-external-link'></i> #" + row.ilanNo + "</a>" ;
                    }

                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets:3,
                    "render": function (data, type, row) {
                        if(row.ilanDoping==1){
                            return row.ilanAdi + " <span class='mt-2 ' style='color:#ff5b00;font-size: 12px'><br> <i class='fa fa-star text-warning'></i> Vitrin İlanı - Bitiş Tarihi: " + row.dopEnd + "</span>" ;
                        }else{

                                return "<div class='text-wrap width-200'>" + row.ilanAdi + "</div>";


                        }
                    }
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets:4,
                    "render": function (data, type, row) {
                        return "<div class='text-wrap width-200'>" + row.ilanTarih + "</div>";
                    }
                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets:5,
                    "render": function (data, type, row) {
                        if(row.ilanType==1){
                            var stok="-";
                            if(row.satAdet>0){
                                stok=row.stokAdet - row.satAdet;
                                if(stok==0){
                                    stok="a";
                                }else{
                                    stok=stok;
                                }
                            }else{
                                if(row.stokAdet){
                                    stok=row.stokAdet;
                                }
                            }
                            if(stok!="a"){
                                if(row.ilanDurum==6)  {
                                    return "<span style='margin-bottom: 5px;background:#ff5b00 ' class='badge  text-white'><i class='fa fa-send'></i> <?= (lac()==1)?"Otomatik Teslimat":"Auto Delivery" ?></span> <br> <small  class='mt-3 text-danger'> Stok Tükendi</small>" ;
                                }else{
                                    return "<span style='margin-bottom: 5px;background:#ff5b00 ' class='badge  text-white'><i class='fa fa-send'></i> <?= (lac()==1)?"Otomatik Teslimat":"Auto Delivery" ?></span> <br> <small  class='mt-3'> Kalan Adet : " + stok + " Adet</small>" ;
                                }
                            }else{
                                return "<span style='margin-bottom: 5px;background:#ff5b00 ' class='badge  text-white'><i class='fa fa-send'></i> <?= (lac()==1)?"Otomatik Teslimat":"Auto Delivery" ?></span> <br> <span style='margin-bottom: 5px; ' class='badge badge-danger text-white'><i class='fa fa-warning'></i> Stok Tükendi</span>" ;

                            }

                        }else{
                            return "<span style='font-size:12px;' class='badge text-secondary badge-success'><img width='25px' style='margin-right:10px;' src='<?= base_url("assets/img/photography.png") ?>'> Manuel Teslimat</span>";
                        }
                    }
                },{
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 6,
                    "render": function (data, type, row) {
                        return "<b >   " + row.ilanFiyat + " <?= getcur(); ?></b>" ;
                    }
                    /* "render": function (data, type, row) {
                         if (row.stat == 0) {
                             return '<span class="label label-warning label-pill label-inline mr-2"> <i class="fa fa-times mr-2 text-white"></i> Pasif</span>';
                         } else if(row.stat == 1) {
                             return '<span class="label label-success label-pill label-inline mr-2"> <i class="fa fa-check mr-2 text-white"></i> Aktif</span>';
                         }
                     }*/
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 7,
                    "render": function (data, type, row) {
                        if (row.ilanDurum == 1) {
                            return "<span class='badge badge-success text-white'><i class='fa fa-location-arrow'></i> Satışta</span>";
                        } else if(row.ilanDurum==0)  {
                            return '<span  style="font-size: 12px" class="badge badge-warning text-black mr-3"> <i class="fa fa-clock-o mr-2 text-warning"></i> <?= langS(130) ?></span>';
                        }else if(row.ilanDurum==2)  {
                            return '<span style="font-size: 12px" class="badge badge-warning text-danger mr-3"> <i class="fa fa-times mr-2 text-danger "></i> <?= langS(127) ?> </span><a class="avatar" data-tooltip="'+ row.redNedeni +'" href="#"><i class="fa fa-info-circle text-warning "></i></a>';
                        }else if(row.ilanDurum==6)  {
                            return '<span style="font-size: 12px" class="badge badge-warning text-danger mr-3"> <i class="fa fa-times mr-2 text-danger "></i> <?= (($_SESSION["lang"]==1)?"Stok Yok ":"No Stock") ?> </span>';
                        }else{
                            if(row.ilanDurum==4){
                                if(row.ilanType==1){
                                    return '<span style="font-size: 12px" class="badge badge-info text-warning mr-3"> <i class="fa fa-shopping-cart mr-2 text-white"></i> <?= ($_SESSION["lang"]==1)?"Kısmen Satıldı":"Partially Sold" ?></span>';

                                } else{
                                    return '<span style="font-size: 12px" class="badge badge-info text-success mr-3"> <i class="fa fa-check mr-2 text-white"></i> <?= langS(129) ?></span>';
                                }
                            }else if(row.ilanDurum==6){

                            }

                        }
                    }
                },
                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if (row.ilanDurum == 1) {
                            if(row.sip==1){
                                if(row.ilanDoping==1){
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' ;

                                }else{
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                        '<a onclick="modalGoster(\'' + row.ilanNo + '\')" style="margin-right:10px;cursor:pointer" title="Güncelle" ><img style="width:20px" src="<?= base_url("assets/img/icon/shuttle.png") ?>"></a>' ;
                                }

                            }else{
                                if(row.ilanDoping==1){
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                    '<a href="javascript:;" onclick="yukariTasi(\''+row.ilanNo+'\',\''+row.ilanAdi+'\')" style="margin-right:10px;cursor:pointer" title="Yukarı Taşı"><img style="width:20px" src="<?=base_url("assets/img/icon/up-arrow.png")?>"></a>'+
                                    '<a  href="javascript:;" onclick="modalGoster2(\'' + row.ilanNo + '\',\'' + row.ilanAdi + '\')"   title="Sil"><img style="width:20px" src="<?= base_url("assets/img/icon/trash-bin.png") ?>"></a>' ;
                                }else{
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                        '<a onclick="modalGoster(\'' + row.ilanNo + '\')" style="margin-right:10px;cursor:pointer" title="Güncelle" ><img style="width:20px" src="<?= base_url("assets/img/icon/shuttle.png") ?>"></a>' +
                                        '<a href="javascript:;" onclick="yukariTasi(\''+row.ilanNo+'\',\''+row.ilanAdi+'\')" style="margin-right:10px;cursor:pointer" title="Yukarı Taşı"><img style="width:20px" src="<?=base_url("assets/img/icon/up-arrow.png")?>"></a>'+
                                        '<a  href="javascript:;" onclick="modalGoster2(\'' + row.ilanNo + '\',\'' + row.ilanAdi + '\')"   title="Sil"><img style="width:20px" src="<?= base_url("assets/img/icon/trash-bin.png") ?>"></a>' ;
                                }

                            }
                        }else if(row.ilanDurum==4){
                            if(row.ilanType==1){
                                if(row.ilanDoping==1){
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' ;
                                }else{
                                    return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                        '<a onclick="modalGoster(\'' + row.ilanNo + '\')" style="margin-right:10px;cursor:pointer" title="Güncelle" ><img style="width:20px" src="<?= base_url("assets/img/icon/shuttle.png") ?>"></a>' ;
                                }

                            }else{
                               
                                return '<a href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>';
                            }

                        }else{
                            if(row.sip==1){
                                return '<a   href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                    '' ;


                            }else{
                                return '<a   href="<?= base_url(gg().$ilanss->link."/") ?>' + row.ilanNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><img style="width:20px" src="<?= base_url("assets/img/icon/edit.png") ?>"></a>' +
                                    '' +
                                    '<a  href="javascript:;" onclick="modalGoster2(\'' + row.ilanNo + '\',\'' + row.ilanAdi + '\')"   title="Sil"><img style="width:20px" src="<?= base_url("assets/img/icon/trash-bin.png") ?>"></a>' ;
                            }
                            
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
    });
</script>