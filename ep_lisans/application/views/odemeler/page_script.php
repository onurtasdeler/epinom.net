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
        $.post("<?= base_url('get-info') ?>",{id:id,table:"table_musteriler"},function(response){
            if(response){
                $("#menu #makaleId").html('<strong style="color:green">' + response.lisans_domain + '</strong>' );
                $("#silinecek-menu").val(response.id)
               
            }else{
                als("Bir hata meydana geldi.","error");
            }
        });
    }

    //tekli silme işlemi ajax
    function singleDeleted(){
        var a=$("#silinecek-menu").val();
        if(a!=""){
            $.post("<?= base_url('record-delete') ?>",{table:"table_musteriler",id:a,imageFolder:"",imageField:"",},function(response){
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
        $.post("<?= base_url("get-info") ?>", {table: "table_musteriler", id: id}, function (response) {
            if (response) {

                $("#updateId").val(response.id);
                $("#secTitle").html("<b class='text-info'>" + response.name + "</b> - Lisans Güncelle");
                $("#adsoyad").val(response.ad_soyad);
                $("#domain").val(response.lisans_domain);
                $("#tels").val(response.telefon);
                $("#bas").val(response.lisans_bas);
                $("#bit").val(response.lisans_bit);
                $("#subCont1").show();
                $("#grup").val(response.grup);
                $("#subCont2").removeClass("col-lg-12").addClass("col-lg-6");

                var aciklaam=response.aciklama;
                tinymce.get('aciklamas').setContent(aciklaam);


                tinymce.activeEditor.save();
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

        $("#icerik").on("change",function (){
           if($(this).val()==1){
               $("#icerikcont").fadeOut(300);
           }else{
               $("#icerikcont").fadeIn(300);
           }
        });


        //güncelleme alanı vazgeç butonu işlevleri
        $("#formBackButton").on("click",function(){
            $("#imgCol1").hide();
            $("#subCont1").hide();
            $("#subCont2").removeClass("col-lg-6").addClass("col-lg-12");
            $("#imgCol2").removeClass("col-lg-9").addClass("col-lg-12");
            $("#markaSubmitButton").html("<em class='icon ni ni-check'></em> Kaydet");
            $("#secTitle").html("Ödeme Ekle");
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
                marka_name: "Lütfen  giriniz",
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("markaAddForm"));
                $.ajax({
                    url: "<?= base_url("odeme-ekle/".$data["v"]->id) ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.err) {
                                als(response.message, "warning");
                            } else {
                                als(response.message, "success");
                                $('#markaAddForm').trigger("reset");
                                $('#markatable').DataTable().ajax.reload();
                                $('#customFileLabel').text("Seçiniz");
                                $('#customFile').val("");
                                setTimeout(function (){
                                    window.location.reload();
                                },600);

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
                url: "<?= base_url("odeme-list-table/".$data["v"]->id) ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid','bit_date','bas_date','tutar','manuel', 'created_at', 'stat', 'action'],
                },
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },



            columns: [
                {data: 'ssid', orderable: false, searchable: false, responsivePriority: 0},
                {data: 'bas_date', responsivePriority: -2},
                {data: 'bit_date', responsivePriority: -2},
                {data: 'tutar', responsivePriority: -2,render: $.fn.dataTable.render.number( ',', '.', 2 )},
                {data: 'manuel', responsivePriority: -2},
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
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 2,
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 3,
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 4,
                    "render": function (data, type, row) {
                        if (row.manuel == 1) {
                            return '<span class="badge bg-info">Manuel Tutar</span>';
                        }else{
                            return '<span class="badge bg-success">Paket Tutarı</span>';

                        }
                    }
                }

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