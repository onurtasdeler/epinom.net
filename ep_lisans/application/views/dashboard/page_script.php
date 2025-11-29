<script src="<?= base_url() ?>assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<script>
    var table;
    $("#menu #makaleId").html("");

    //tekli silme işleminde bilgi gösterimi ve silinecek olan kaydın bilgisinin aktarımı
    function singleDelete(id){
        var a="";
        $.post("<?= base_url('get-info') ?>",{id:id,table:"table_musteri"},function(response){
            if(response){
                $("#menu #makaleId").html('<strong style="color:green">' + response.name + '</strong>' );
                $("#silinecek-menu").val(response.id);
            }else{
                als("Bir hata meydana geldi.","error");
            }
        });
    }

    //tekli silme işlemi ajax
    function singleDeleted(){
        var a=$("#silinecek-menu").val();
        if(a!=""){
            $.post("<?= base_url('record-delete') ?>",{table:"table_musteri",id:a,imageFolder:"",imageField:"",},function(response){
                if(response){
                    if(response.err){
                        als(response.message,"error");
                    }else {
                        $("#menu").modal("hide");
                        als(response.message,"success");
                        $('#markatable').DataTable().ajax.reload();
                    }

                }else{
                    als("Bir hata meydana geldi.","error");
                }
            });
        }
    }

    //çoklu silme işlemi bilgi gösterimi ve atama
    function multiDelete(){
        var a="";
        var form = $("#frm-example");
        var rows_selected = table.column(0).checkboxes.selected();
        var str="";
        $("#markaAddForm .silll").remove();
        $.each(rows_selected, function(index, rowId){
            $(form).append(
                $('<input>').attr('type', 'hidden')
                    .attr('name', 'id[]').attr("class","silll")
                    .val(rowId));

            str += rowId.toString() + ", ";
        });


        if(str==""){
            $("#menu2 #makaleId").html("Herhangi bir kayıt seçmediniz.");
            $("#baslikToplu").html("Lütfen Silinecek Kayıtları Seçiniz.");
            $("#siltopluonay").hide();
            $("#menu2 #toplumetin").html("");
            $("#vazgectoplu").html("Tamam");
            $("#siltopluonay").attr("onclick",'gonder(1)');
        }else{
            $.post("<?= base_url('musteri-sil-toplu') ?>",{data : str,tur:1},function(response){
                $("#vazgectoplu").html("Vazgeç");
                $("#siltopluonay").show();
                $("#siltopluonay").attr("onclick",'gonder(2)');
                $("#menu2 #makaleId").html("Kayıtlar Silinecektir. Emin misiniz ?");
                $("#menu2 #toplumetin").html("<br>" + response + " adlı kayıtlar silinecektir.");
            });

        }
    }

    //kayıt durum değiştirme ajax
    function durum_degistir(types, id) {
        if (types != "") {
            var $data = $("#switch-lg_" + types + "_" + id).prop("checked");
            var $data_url = $("#switch-lg_" + types + "_" + id).data("url");
        } else {
            var $data = $("#switch-lg_" + id).prop("checked");
            var $data_url = $("#switch-lg_" + id).data("url");
        }

        if (typeof $data !== "undefined" && typeof $data_url !== "undefined") {
            $.post($data_url, {data: $data}, function (response) {
                if (response == 2) {
                    als("Bir hata meydana geldi.", "error");
                } else if (response == 1) {
                    als("Durum Güncellendi", "success");
                }
            });
        }
    }

    //kayıt bölümü / güncelleme bölümü bilgi ataması
    function get_info(id) {
        $.post("<?= base_url("get-info") ?>", {table: "table_musteri", id: id}, function (response) {
            if (response) {

                $("#updateId").val(response.id);
                $("#secTitle").html("<b class='text-info'>" + response.name + "</b> - Müşteri Güncelle");
                $("#ad_soyad").val(response.name);
                $("#plaka").val(response.plaka);
                $("#telefon").val(response.telefon);
                $('#marka').val(response.marka_id);
                $('#marka').trigger('change');
                $.post("<?= base_url('get-info') ?>",{id:response.marka_id,table:"table_marka_model",parent:1},function(response2){
                    if(response){
                        $("#model").select2({ data: response2.data });
                        $('#model').val(response.model_id);
                        $('#model').trigger('change');
                    }else{
                        als("Bir hata meydana geldi.","error");
                    }
                });

                $("#subCont1").show();
                $("#subCont2").removeClass("col-lg-12").addClass("col-lg-6");
                if (response.logo != "") {
                    $("#imgCol1").fadeIn(200);
                    $("#imgCol2").removeClass("col-lg-12").addClass("col-lg-9");
                    $("#markaSubmitButton").html("<em class='icon ni ni-edit'></em> Güncelle");
                } else {

                }
                var body = $("html, body");
                body.stop().animate({scrollTop: 10}, 200, 'swing', function () {
                });
            } else {
                $("#updateId").val();
                als("Kayıt Getirilemedi", "error");
            }
        });
    }

    //çoklu silme işlemi ajax
    function gonder(type){
        if(type==1){

        }else{
            var form = $("#frm-example");

            $.post("<?= base_url('musteri-sil-toplu') ?>",{data : form.serialize() ,tur:2},function(response){
                if($.trim(response)=="1"){
                    $("#markaAddForm .silll").remove();
                    als("Kayıtlar başarılı şekilde silindi.","success");
                    $('#markatable').DataTable().ajax.reload();
                    $("#vazgectoplu").trigger("click");
                }
            });
        }
    }

    $(document).ready(function () {
        $("#marka").select2();
        $('#marka').on('select2:select', function (e) {
            var data = e.params.data;
            $.post("<?= base_url('get-info') ?>",{id:data.id,table:"table_marka_model",parent:1},function(response){
                if(response){
                    if(!response.data){
                        $('#model').empty().trigger("change");
                        var datas = {
                            id: 0,
                            text: 'Marka Seçiniz'
                        };
                        var newOption = new Option(datas.text, datas.id, false, false);
                        $('#model').append(newOption).trigger('change');
                    }else{
                        $("#model").select2({ data: response.data });
                    }
                }else{
                    $('#sel').empty().trigger("change");
                    var datas = {
                        id: 0,
                        text: 'Marka Seçiniz'
                    };
                    var newOption = new Option(data.text, data.id, false, false);
                    $('#model').append(newOption).trigger('change');
                }
            });
        });

        //güncelleme alanı vazgeç butonu işlevleri
        $("#formBackButton").on("click",function(){
            $("#updateId").val("");
            $("#imgCol1").hide();
            $("#subCont1").hide();
            $("#subCont2").removeClass("col-lg-6").addClass("col-lg-12");
            $("#imgCol2").removeClass("col-lg-9").addClass("col-lg-12");
            $("#markaSubmitButton").html("<em class='icon ni ni-check'></em> Kaydet");
            $("#secTitle").html("Müşteri Ekle");

            $('#markaAddForm').trigger("reset");
        });

        //Form validation ve form submit işlemleri (kayıt ve güncellemeyi içerir)
        $("#markaAddForm").validate({
            rules: {
                ad_soyad: "required",
            },
            messages: {
                ad_soyad: "Lütfen Ad Soyad Giriniz",
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("markaAddForm"));
                $.ajax({
                    url: "<?= base_url("musteri-ekle") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.err) {
                                als(response.message, "warning");
                            } else {
                                if( $("#updateId").val()){
                                    get_info($("#updateId").val());
                                }

                                als(response.message, "success");
                                $('#markaAddForm').trigger("reset");
                                $('#markatable').DataTable().ajax.reload();
                            }
                        } else {
                            als("API'de hata meydana geldi !", "danger");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $("#vazgectoplu").on("click",function(){
            $("#menu2").modal("hide");
        });

        table = $('#markatable').DataTable();
        table.destroy();

        //datatable AJAX
        table = $('#markatable').DataTable({

            responsive: true,
            processing: true,
            "searchDelay": 500,
            serverSide: true,
            order: [[2, "desc"]],
            ajax: {
                url: "<?= base_url("is-emri-list-table?t=3") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid', 'marka_adi','yetki','personel_adi','model_adi','musid', 'musteri_adi','logo', 'plaka','stat','islem_tarih','tutar','odenen', 'action'],
                },
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },


            columns: [
                {data: 'ssid', responsivePriority: -2},
                {data: 'plaka', responsivePriority: -3},
                {data: 'musteri_adi', responsivePriority: 1},
                {data: 'marka_adi', responsivePriority: 1},
                {data: 'tutar', responsivePriority: 1},
                {data: 'odenen', responsivePriority: 1},
                {data: 'islem_tarih', responsivePriority: 3},
                {data: 'personel_adi', responsivePriority: 0},
                {data: 'stat', responsivePriority: 4},
                {data: 'action', responsivePriority: -1, searchable: false, className: ""},
            ],
            columnDefs: [

                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 0,
                    "render": function (data, type, row) {

                        return '<a class="text-info" href="<?= base_url("fis-detay/")?>' + row.ssid + '">' + row.ssid+ "</a>";

                    }


                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {
                        if (row.plaka != "") {
                            var myArray = row.plaka.split(" ");
                            if(myArray[0] && myArray[1] && myArray[2]){
                                return '<div class="plaka" bis_skin_checked="1">' +
                                    '<div class="plaka-inside" bis_skin_checked="1"></div>' +
                                    '<div class="il" ><b>' + myArray[0] + '</b></div>' +
                                    '<div class="harf" ><b>' + myArray[1] + '</b></div>' +
                                    '<div class="son"><b>' + myArray[2] + '</b></div></div>';
                            }else{
                                return '<div class="plaka" >' +
                                    '<div class="plaka-inside" ></div>' +
                                    '<div class="il" ></div>' +
                                    '<div class="harf" ></div>' +
                                    '<div class="son"></div></div>';
                            }


                        } else {
                            return '<div class="plaka">' +
                                '<div class="plaka-inside" ></div>' +
                                '<div class="il" ></div>' +
                                '<div class="harf" ></div>' +
                                '<div class="son" ></div></div>';
                        }
                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 2,
                    "render": function (data, type, row) {
                        if(row.musid){
                            return '<a href="<?= base_url("musteriler/")?>' + row.musid + '">' + row.musteri_adi+ "</a>";
                        }else{
                            return row.musteri_adi;
                        }
                    }

                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 3,
                    "render": function (data, type, row) {
                        if (row.logo != "") {
                            return "<img src='<?= base_url("upload/marka/")?>" + row.logo +"' width='20' height='20' > " +row.marka_adi;
                        } else {
                            return row.marka_adi;
                        }
                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 4,
                    'render': function ( data, type, row ){
                        if(row.tutar!=0){
                            var num = $.fn.dataTable.render.number(',', '.', 2).display(row.tutar);
                            return num + " TL" ;
                        }else{
                            return "-" ;
                        }

                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 5,
                    'render': function ( data, type, row ){
                        if(row.odenen!=0){
                            if(row.odenen==0){
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(row.odenen);
                                return "<b class='text-danger'>" + num + " TL </b>" ;
                            }else{
                                var num = $.fn.dataTable.render.number(',', '.', 2).display(row.odenen);
                                return num + " TL" ;
                            }

                        }else{
                            var num = $.fn.dataTable.render.number(',', '.', 2).display(row.odenen);
                            return "<b class='text-danger'>" + num + " TL </b>" ;
                        }

                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 6,

                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 7,

                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 8,
                    'render': function ( data, type, row ){
                        if(row.stat==0){
                            return '<span class="badge bg-warning"><em style="margin-top:4px;margin-right:4px;" class="text-dark ni ni-clock"></em> Devam Ediyor</span>';
                        }else if(row.stat==1){
                            return '<span class="badge bg-success"><em style="margin-top:4px;margin-right:4px;" class="text-dark ni ni-check"></em> Tamamlandı</span>';
                        }else{
                            return '<span class="badge bg-danger"><em style="margin-top:4px;margin-right:4px;" class="text-dark ni ni-cross"></em> İptal Edildi</span>';
                        }
                    }

                },


                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if(row.yetki==2){
                            return '<ul class="nk-tb-actions gx-1"><li><div class="drodown">' +
                                '<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>' +
                                '<div class="dropdown-menu dropdown-menu-end"><ul class="link-list-opt no-bdr">' +
                                '<li><a data-bs-toggle="modal" onclick="get_info(' + row.ssid + ')" data-bs-target="#modalForm2"> <em class="icon ni ni-search"></em><span>Durum Güncelle</span></a></li>' +
                                '<li><a target="_blank" href="<?= base_url("fis-yazdir/") ?>' + row.ssid + '"> <em class="icon ni ni-printer"></em><span>Fiş Yazdır</span></a></li>' +
                                '<li><a onclick="singleDelete(' + row.ssid + ')"  data-bs-toggle="modal" data-bs-target="#menu" data-id="' + row.ssid + '" ><em class="icon ni ni-trash"></em><span>Sil</span></a></li>' +
                                '</ul></div></div></li></ul>';
                        }else{
                            return '<ul class="nk-tb-actions gx-1"><li><div class="drodown">' +
                                '<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>' +
                                '<div class="dropdown-menu dropdown-menu-end"><ul class="link-list-opt no-bdr">' +
                                '<li><a data-bs-toggle="modal" onclick="get_info(' + row.ssid + ')" data-bs-target="#modalForm2"> <em class="icon ni ni-search"></em><span>Durum Güncelle</span></a></li>' +
                                '<li><a target="_blank" href="<?= base_url("fis-yazdir/") ?>' + row.ssid + '"> <em class="icon ni ni-printer"></em><span>Fiş Yazdır</span></a></li>' +
                                '</ul></div></div></li></ul>';
                        }
                    },
                },
            ],

        });

        //selectboxlar değiştiğinde olacaklar
        $('#markatable tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
                var el = $('#example-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

    });
</script>