<script src="<?= base_url() ?>assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<link rel="stylesheet" href="<?= base_url() ?>assets/assets/css/editors/tinymce.css?ver=3.1.2">
<script src="<?= base_url() ?>assets/assets/js/libs/editors/tinymce.js?ver=3.1.2"></script>
<script src="<?= base_url() ?>assets/assets/js/editors.js?ver=3.1.2"></script>


<script>
    var table;

    //tekli silme işleminde bilgi gösterimi ve silinecek olan kaydın bilgisinin aktarımı
    function singleDelete(id){
        var a="";
        $.post("<?= base_url('get-info') ?>",{id:id,table:"table_hizmetler"},function(response){
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
            $.post("<?= base_url('record-delete') ?>",{table:"table_hizmetler",id:a,imageFolder:"marka",imageField:"logo",},function(response){
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
        $(".silll").remove();
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
            $.post("<?= base_url('marka-sil-toplu') ?>",{data : str,tur:1},function(response){
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
                    als("Demo Hesabında İşlem Yetkisi Bulunmamaktadır..", "error");
                } else if (response == 1) {
                    als("Durum Güncellendi", "success");
                }
            });
        }
    }

    //kayıt bölümü / güncelleme bölümü bilgi ataması
    function get_info(id) {
        $.post("<?= base_url("get-info") ?>", {table: "table_hizmetler", id: id}, function (response) {
            if (response) {

                $("#updateId").val(response.id);
                $("#secTitle").html("<b class='text-info'>" + response.name + "</b> - Hizmet Güncelle");
                $("#marka_name").val(response.name);
                $("#subCont1").show();
                $("#subCont2").removeClass("col-lg-12").addClass("col-lg-6");
                $("#fiyat").val(response.fiyat_goster);
                $("#parca").val(response.parca);
                $("#oda").val(response.oda);
                if(response.parca==1){
                    $("#parca").prop("disabled",false);
                }else{
                    $("#parca").prop("disabled",true);
                }
                tinymce.get("aciklama").setContent(response.aciklama);
                if (response.logo != "") {
                    $("#imgCol1").fadeIn(200);
                    $("#imgCol2").removeClass("col-lg-12").addClass("col-lg-9");
                    $("#updImage").attr("src", "<?= base_url("../upload/hizmetler/") ?>" + response.logo);
                    $("#markaSubmitButton").html("<em class='icon ni ni-edit'></em> Güncelle");
                } else {
                    $("#imgCol1").hide();
                    $("#imgCol2").removeClass("col-lg-9").addClass("col-lg-12");
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

            $.post("<?= base_url('marka-sil-toplu') ?>",{data : form.serialize() ,tur:2},function(response){
                if($.trim(response)=="1"){
                    als("Kayıtlar başarılı şekilde silindi.","success");
                    $('#markatable').DataTable().ajax.reload();
                    $("#vazgectoplu").trigger("click");
                }
            });
        }
    }

    $(document).ready(function () {

        $("#oda").on("change",function (){
           if($(this).val()==1){
               $("#parca").prop("disabled",true);
           } else{
               $("#parca").prop("disabled",false);
           }
        });

        //güncelleme alanı vazgeç butonu işlevleri
        $("#formBackButton").on("click",function(){
            $("#imgCol1").hide();
            $("#subCont1").hide();
            $("#subCont2").removeClass("col-lg-6").addClass("col-lg-12");
            $("#imgCol2").removeClass("col-lg-9").addClass("col-lg-12");
            $("#markaSubmitButton").html("<em class='icon ni ni-check'></em> Kaydet");
            $("#secTitle").html("Hizmet Ekle");
            $("#updateId").val();
            $('#markaAddForm').trigger("reset");
            $('#customFileLabel').text("Seçiniz");
            document.getElementById("customFile").value = null;
        });

        //Form validation ve form submit işlemleri (kayıt ve güncellemeyi içerir)
        $("#markaAddForm").validate({
            rules: {
                marka_name: "required",
            },
            messages: {
                marka_name: "Lütfen Hizmet Başlığını giriniz",
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("markaAddForm"));
                $.ajax({
                    url: "<?= base_url("hizmet-ekle") ?>",
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
                                $('#customFileLabel').text("Seçiniz");
                                $('#customFile').val("");

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



        //Logo silme işlemi ajax
        $("#imgDeleted").on("click",function(){
           if($("#updateId").val()){
               $.post("<?= base_url("delete-image") ?>", {table:"table_hizmetler",field:"logo",id:$("#updateId").val(),folder:"hizmetler"}, function (response) {
                   if(response){
                       if(response.err){
                           als(response.message,"error");
                       }else{
                           als(response.message,"success")
                           get_info($("#updateId").val());
                           $("#modalForm").modal("hide");
                           $('#markatable').DataTable().ajax.reload();
                       }
                   }else{
                       als("Beklenmeyen hata","error");
                   }
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
            order: [[0, "desc"]],
            ajax: {
                url: "<?= base_url("hizmet-list-table/".$data["v"]->id) ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid', 'logo', 'name', 'created_at', 'status', 'action'],
                },
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },



            columns: [
                {data: 'ssid', orderable: false, searchable: false, responsivePriority: 0},
                {data: 'logo', responsivePriority: 2},
                {data: 'name', responsivePriority: -2},
                {data: 'status', responsivePriority: -1},
                {data: 'action', responsivePriority: 0, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    title: "No",
                    orderable: false,
                    targets: 0,
                    searchable: false,

                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {
                        if (row.logo != null) {
                            return '<ul class="project-users g-1"><li>' +
                                '<img width="50" height="50" src="<?= base_url("../upload/hizmetler/") ?>' + row.logo + '" alt=""></li></ul>';
                        } else {
                            return '<ul class="project-users g-1"><li>' +
                                'Resim Yok</li></ul>';
                        }
                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 2,
                },
                {
                    orderable: true,
                    searchable: false,
                    targets: 3,
                    "render": function (data, type, row) {
                        if (row.status == 1) {
                            return '<div class="custom-control custom-switch">' +
                                '<input type="checkbox" data-url="<?= base_url('hizmet-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                'onchange="durum_degistir(1,' + row.ssid + ')" name="select" checked id="switch-lg_1_' + row.ssid + '"  class="custom-control-input">' +
                                ' <label class="custom-control-label" for="switch-lg_1_' + row.ssid + '"></label></div>';
                        } else {
                            return '<div class="custom-control custom-switch">' +
                                '<input type="checkbox" data-url="<?= base_url('hizmet-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                'onchange="durum_degistir(1,' + row.ssid + ')" name="select"  id="switch-lg_1_' + row.ssid + '"  class="custom-control-input">' +
                                ' <label class="custom-control-label" for="switch-lg_1_' + row.ssid + '"></label></div>';
                        }
                    }
                },

                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return '<ul class="nk-tb-actions gx-1"><li><div class="drodown">' +
                            '<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>' +
                            '<div class="dropdown-menu dropdown-menu-end"><ul class="link-list-opt no-bdr">' +
                            '<li><a onclick="get_info(' + row.ssid + ')"><em class="icon ni ni-edit"></em><span>Düzenle</span></a></li>' +
                            '<li><a onclick="singleDelete(' + row.ssid + ')"  data-bs-toggle="modal" data-bs-target="#menu" data-id="' + row.ssid + '" ><em class="icon ni ni-trash"></em><span>Sil</span></a></li>' +
                            '</ul></div></div></li></ul>';
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