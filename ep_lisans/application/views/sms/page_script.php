<script src="<?= base_url() ?>assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<script>
    var table;
    $("#menu #makaleId").html("");

    //tekli silme işleminde bilgi gösterimi ve silinecek olan kaydın bilgisinin aktarımı
    function singleDelete(id) {
        var a = "";
        $.post("<?= base_url('get-info') ?>", {id: id, table: "table_sms_taslak"}, function (response) {
            if (response) {
                $("#menu #makaleId").html('<strong style="color:green">' + response.name + '</strong>');
                $("#silinecek-menu").val(response.id);
            } else {
                als("Bir hata meydana geldi.", "error");
            }
        });
    }

    //tekli silme işlemi ajax
    function singleDeleted() {
        var a = $("#silinecek-menu").val();
        if (a != "") {
            $.post("<?= base_url('record-delete') ?>", {
                table: "table_sms_taslak",
                id: a,
                imageFolder: "",
                imageField: "",
            }, function (response) {
                if (response) {
                    if (response.err) {
                        als(response.message, "error");
                    } else {
                        $("#menu").modal("hide");
                        als(response.message, "success");
                        $('#markatable').DataTable().ajax.reload();
                    }

                } else {
                    als("Bir hata meydana geldi.", "error");
                }
            });
        }
    }

    //çoklu silme işlemi bilgi gösterimi ve atama
    function multiDelete() {
        var a = "";
        var form = $("#frm-example");
        var rows_selected = table.column(0).checkboxes.selected();
        var str = "";
        $("#markaAddForm .silll").remove();
        $.each(rows_selected, function (index, rowId) {
            $(form).append(
                $('<input>').attr('type', 'hidden')
                    .attr('name', 'id[]').attr("class", "silll")
                    .val(rowId));

            str += rowId.toString() + ", ";
        });


        if (str == "") {
            $("#menu2 #makaleId").html("Herhangi bir kayıt seçmediniz.");
            $("#baslikToplu").html("Lütfen Silinecek Kayıtları Seçiniz.");
            $("#siltopluonay").hide();
            $("#menu2 #toplumetin").html("");
            $("#vazgectoplu").html("Tamam");
            $("#siltopluonay").attr("onclick", 'gonder(1)');
        } else {
            $.post("<?= base_url('sabit-sms-sil-toplu') ?>", {data: str, tur: 1}, function (response) {
                $("#vazgectoplu").html("Vazgeç");
                $("#siltopluonay").show();
                $("#siltopluonay").attr("onclick", 'gonder(2)');
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
        $.post("<?= base_url("get-info") ?>", {table: "table_sms_taslak", id: id}, function (response) {
            if (response) {
                $("#updateIdTaslak").val(response.id);
                $("#secTitleTaslak").html("<b class='text-info'>" + response.name + "</b> - SMS Taslak Güncelle");
                $("#sabitBaslik").val(response.name);
                $("#sabitMesaj").val(response.mesaj);
                $("#sabitUpdCancel").show();
                $("#sabitSubmitButton").html("<em class='icon ni ni-edit'></em> Güncelle");
                var body = $("html, body");
                body.stop().animate({scrollTop: 100}, 200, 'swing', function () {
                });
            } else {
                $("#updateIdTaslak").val();
                als("Kayıt Getirilemedi", "error");
            }
        });
    }

    //çoklu silme işlemi ajax
    function gonder(type) {
        if (type == 1) {

        } else {
            var form = $("#frm-example");

            $.post("<?= base_url('sabit-sms-sil-toplu') ?>", {data: form.serialize(), tur: 2}, function (response) {
                if ($.trim(response) == "1") {
                    $("#markaAddForm .silll").remove();
                    als("Kayıtlar başarılı şekilde silindi.", "success");
                    $('#markatable').DataTable().ajax.reload();
                    $("#vazgectoplu").trigger("click");
                }
            });
        }
    }


    $(document).ready(function () {

        $("#sabitUpdCancel").on("click",function (){
            $('#sabitSaveForm').trigger("reset");
            $("#sabitUpdCancel").hide();
            $("#updateIdTaslak").val();
            $("#secTitleTaslak").html("Sabit Mesaj Oluşturun");
            $("#sabitSubmitButton").html("<em class='icon ni ni-save'></em> Sabit Mesajı Kaydet");
        });

        $("#sabitSaveForm2").validate({
            rules: {
                sabitBaslik: "required",
                sabitMesaj: "required",
            },
            messages: {
                sabitBaslik: "Lütfen Başlık Giriniz",
                sabitMesaj: "Lütfen Mesaj Giriniz.",
            },
            submitHandler: function (form) {
                var valid = 0;
                var formData = new FormData(document.getElementById("sabitSaveForm2"));
                $.ajax({
                    url: "<?= base_url("sabit-sms-ekle") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.err) {
                                als(response.message, "warning");
                            } else {
                                $('#sabitSaveForm').trigger("reset");
                                als(response.message, "success");
                                setTimeout(function (){
                                    window.location.reload();
                                },500);
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


        $("#selectTaslak").select2();
        $('#selectTaslak').on('select2:select', function (e) {
            var data = e.params.data;
            $.post("<?= base_url('get-info') ?>", {
                id: data.id,
                table: "table_sms_taslak"
            }, function (response) {
                if (response) {
                    $("#sabitMesajGelen").val(response.mesaj)
                } else {
                    als("Kayıt getirilemedi", "info");
                }
            });
        });

        $("#musteriler").select2();
        $('#musteriler').on('select2:select', function (e) {
            var data = e.params.data;
            $.post("<?= base_url('get-info') ?>", {
                id: data.id,
                table: "table_musteriler"
            }, function (response) {
                if (response) {
                    $("#tels").val(response.telefon);
                } else {
                    als("Kayıt getirilemedi", "info");
                }
            });
        });




        //güncelleme alanı vazgeç butonu işlevleri
        $("#formBackButton").on("click", function () {
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
                date: "required",
                plaka: "required",
            },
            messages: {
                date: "Lütfen İşlem Tarihi Seçiniz",
                plaka: "Lütfen İşlem Tarihi Seçiniz",
            },
            submitHandler: function (form) {
                var valid = 0;
                if (($("#plaka").val() != "" && $("#plaka").val() != "0") || ($("#ad_soyad").val() != "" && $("#ad_soyad").val() != "0")) {
                    if ($("#total").val() <= 0) {
                        $("#total").val(0);
                        als("Lütfen Hizmet Seçiniz", "warning");
                    } else {
                        var formData = new FormData(document.getElementById("markaAddForm"));
                        $.ajax({
                            url: "<?= base_url("is-emri-ekle") ?>",
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                if (response) {
                                    if (response.err) {
                                        als(response.message, "warning");
                                    } else {
                                        $("#plaka").val("0");
                                        $('#plaka').trigger("change");
                                        $("#ad_soyad").val("0");
                                        $('#ad_soyad').trigger("change");

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
                } else if ($("#plaka").val() != "" || $("#plaka").val() != "0" && $("#ad_soyad").val() == "" || $("#ad_soyad").val() == "0") {
                    $("#plakaCont").css("border", "1px solid #e95858");
                    $("#plakaCont").css("border-radius", "5px")
                    $("#ad_soyadCon").css("border", "1px solid #e95858");
                    $("#ad_soyadCon").css("border-radius", "5px")
                } else if ($("#plaka").val() == "" || $("#plaka").val() == "0" && $("#ad_soyad").val() != "" || $("#ad_soyad").val() != "0") {
                    $("#ad_soyadCon").css("border", "none");
                    $("#ad_soyadCon").css("border-radius", "0px")
                    $("#plakaCont").css("border", "1px solid #e95858");
                    alert("asd");
                    $("#plakaCont").css("border-radius", "5px")
                } else {

                }


            }
        });

        $("#smsSubmitForm").validate({
            rules: {
                sabitMesajGelen: "required",
                tels: "required",
            },
            messages: {
                sabitMesajGelen: "Lütfen Mesaj Giriniz",
                tels: "Lütfen Telefon Giriniz",
            },
            submitHandler: function (form) {
                var valid = 0;
                    var formData = new FormData(document.getElementById("smsSubmitForm"));
                    $.ajax({
                        url: "<?= base_url("sms-gonder") ?>",
                        type: 'POST',
                        data: {tels:$("#tels").val(),mesaj:$("#sabitMesajGelen").val()},
                        success: function (response) {
                            if (response) {
                                if (response.err) {
                                    als(response.message, "error");
                                } else {  als(response.message, "success");
                                    $('#smsSubmitForm').trigger("reset");
                                }
                            } else {
                                als("API'de hata meydana geldi !", "danger");
                            }
                        }
                    });

            }
        });

        $("#vazgectoplu").on("click", function () {
            $("#menu2").modal("hide");
        });

        table = $('#markatable').DataTable();
        table.destroy();

        //datatable AJAX
        table = $('#markatable').DataTable({

            responsive: true,
            processing: true,
            "searchDelay": 1000,
            serverSide: true,
            order: [[0, "desc"]],
            ajax: {
                url: "<?= base_url("sms-list-table") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'ssid', 'name', 'mesaj', 'status', 'action'],
                },
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json",
                lengthMenu: "_MENU_",
                searchPlaceholder: "Kayıtlarda Ara",


            },


            columns: [
                {data: 'ssid', orderable: false, searchable: false, responsivePriority: 0},
                {data: 'name', responsivePriority: 1},
                {data: 'mesaj', responsivePriority: 2},
                {data: 'status', responsivePriority: 4},
                {data: 'action', responsivePriority: -1, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    title: "Seçim",
                    orderable: false,
                    targets: 0,
                    searchable: false,
                    checkboxes: {
                        'selectRow': false,
                    },
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 1,
                },
                {
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
                                '<input type="checkbox" data-url="<?= base_url('sms-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                'onchange="durum_degistir(1,' + row.ssid + ')" name="select" checked id="switch-lg_1_' + row.ssid + '"  class="custom-control-input">' +
                                ' <label class="custom-control-label" for="switch-lg_1_' + row.ssid + '"></label></div>';
                        } else {
                            return '<div class="custom-control custom-switch">' +
                                '<input type="checkbox" data-url="<?= base_url('sms-veri-guncelle/status/') ?>' + row.ssid + '" ' +
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
        $('#markatable tbody').on('change', 'input[type="checkbox"]', function () {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#example-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked && ('indeterminate' in el)) {
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

    });
</script>