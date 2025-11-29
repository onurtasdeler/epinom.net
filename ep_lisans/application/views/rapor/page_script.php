<script src="<?= base_url() ?>assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css  "></script>

<script src="<?= base_url() ?>assets/assets/js/example-chart.js?ver=3.1.0"></script>
<script>
    var table;
    var table2;
    $("#menu #makaleId").html("");

    //tekli silme işleminde bilgi gösterimi ve silinecek olan kaydın bilgisinin aktarımı
    function singleDelete(id){
        var a="";
        $.post("<?= base_url('get-info') ?>",{id:id,table:"musteri"},function(response){
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
            $.post("<?= base_url('record-delete') ?>",{table:"musteri",id:a,imageFolder:"",imageField:"",},function(response){
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
        $.post("<?= base_url("get-info") ?>", {table: "musteri", id: id}, function (response) {
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

        table = $('#markatable').DataTable({

            responsive: true,
            processing: true,
            "searchDelay": 500,
            serverSide: true,
            order: [[3, "asc"]],
            ajax: {
                url: "<?= base_url("lisans-list-table2") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid', 'ad_soyad','lisans_bit','lisans_domain','proje_adi','lisans_bas', 'created_at','kalan', 'stat', 'action'],
                },
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },



            columns: [
                {data: 'ssid', orderable: false, searchable: false, responsivePriority: 0},
                {data: 'ad_soyad', responsivePriority: -2},
                {data: 'lisans_domain', responsivePriority: -2},
                {data: 'lisans_bit', responsivePriority: -2},
                {data: 'kalan', responsivePriority: -2},
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
                },{
                    orderable: false,
                    searchable: false,
                    visible: true,
                    targets: 4,
                    render: function (data, type, row) {
                        if(row.lisans_bit==row.lisans_bas){
                            return "Sınırsız ";
                        }else{
                            if(row.kalan<5){
                                return '<span class="badge bg-danger">' + row.kalan + ' GÜN</span>';
                            }else{
                                return '<span class="badge bg-success">' + row.kalan + ' GÜN </span>';
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

                        return '<ul class="nk-tb-actions gx-1"><li><div class="drodown">' +
                            '<a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>' +
                            '<div class="dropdown-menu dropdown-menu-end"><ul class="link-list-opt no-bdr">' +
                            '<li><a href="<?= base_url("odemeler/") ?>' + row.ssid + '"><em class="icon ni ni-coins"></em><span>Ödemeler</span></a></li>' +
                            '<li><a onclick="singleDelete(' + row.ssid + ')"  data-bs-toggle="modal" data-bs-target="#menu" data-id="' + row.ssid + '" ><em class="icon ni ni-trash"></em><span>Sil</span></a></li>' +
                            '</ul></div></div></li></ul>';



                    },
                },
            ],

        });
        //datatable AJAX
        
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

        $('#markatable2 tbody').on('change', 'input[type="checkbox"]', function(){
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