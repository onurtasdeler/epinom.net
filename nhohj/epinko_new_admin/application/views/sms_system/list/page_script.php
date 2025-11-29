<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script src="<?= base_url() ?>assets/backend/tinymce/tinymce.bundle.js"></script>
<script src="<?= base_url() ?>assets/backend/tinymce/tinymce.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/crud/forms/widgets/select2.js?v=7.2.9"></script>
<script>

    tinymce.init({
        selector: 'textarea#editor1',
        language_url: '<?= base_url("assets/backend/tinymce/") ?>tr.js',
        language: 'tr',
        cleanup : false,
        statusbar : false,


        menubar: false,
        toolbar: ['styleselect fontselect fontsizeselect',
            'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
            'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
        plugins : 'advlist autolink link image lists charmap print preview code'

    });
    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url('sms/sms/get_record') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('coupon/action_delete') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Kupon Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }

    $(document).ready(function() {

        $('#sablon').select2({
            placeholder: 'Seçiniz',
        }).on("select2:select", function(e) {
            var sablonId = e.params.data.id; // Seçilen müşterinin ID'si
            $.ajax({
                url:  "<?= base_url("sms/sms/sablon_getir") ?>",
                type: 'POST',
                data: {sablon:sablonId},
                success: function (response) {
                    if(response){
                        $("#mailadi").val(response.ad);
                        $("#mailkonu").val(response.icerik);
                    }else{
                        return false;
                    }
                },
                cache: false,
            });
        });

        $('#grup').select2({
            placeholder: 'Seçiniz',
            allowClear: true,
            multiple: true,
            tags: true,
            ajax: {
                url: '<?= base_url("sms/sms/getusertop") ?>', // Verilerinizi çeken PHP dosyasının URL'si
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term // Arama sorgusu
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        }).on('select2:select', function(e) {
            var id = e.params.data.id;
            if (id === 'tumunuSec') {
                // Tüm seçenekleri seç
                var tumSecenekler = $(this).find('option').not('[value=tumunuSec]').map(function() {
                    return this.value;
                }).get();
                $(this).val(tumSecenekler).trigger('change');
            }
        }).on('select2:unselect', function(e) {
            if (e.params.data.id === 'tumunuSec') {
                // Tüm seçimleri kaldır
                $(this).val([]).trigger('change');
            }
        });
        $('#grup').val(null).trigger('change');
        $('#kategori').val(null).trigger('change');

        $('#kategori').select2({
            placeholder: 'Seçiniz',
            allowClear: true,
            multiple: true,
            tags: true,
            ajax: {
                url: '<?= base_url("sms/sms/getusercategory") ?>', // Verilerinizi çeken PHP dosyasının URL'si
                dataType: 'json',
                data: function (params) {
                    return {
                        q: params.term // Arama sorgusu
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        }).on('select2:select', function(e) {
            var id = e.params.data.id;
            if (id === 'tumunuSec') {
                // Tüm seçenekleri seç
                var tumSecenekler = $(this).find('option').not('[value=tumunuSec]').map(function() {
                    return this.value;
                }).get();
                $(this).val(tumSecenekler).trigger('change');
            }
            // Kategori seçildiğinde grup selectini devre dışı bırak
            $('#grup').val(null).trigger('change');
            $('#grup').prop('disabled', true);
        }).on('select2:unselect', function(e) {
            if (e.params.data.id === 'tumunuSec') {
                // Tüm seçimleri kaldır
                $(this).val([]).trigger('change');
            }
            // Eğer hiç bir kategori seçili değilse grup selectini yeniden aktif hale getir
            if ($('#kategori').val().length === 0) {
                $('#grup').prop('disabled', false);
                $('#grup').val(null).trigger('change');
            }
        });


        $("#sablonKaydetButton").on("click",function (){

            if($("#mailkonu").val() ){
                $.ajax({
                    url:  "<?= base_url("sms/sms/sablon_kaydet") ?>",
                    type: 'POST',
                    data: {name:$("#mailadi").val(),konu:$("#mailkonu").val()},
                    success: function (response) {
                        if(response.hata=="var"){
                            toastr.warning(response.message);
                        }else{
                            toastr.success(response.message);
                        }
                    },
                    cache: false,
                });
            }else{
                als("Lütfen konu ve içerik alanını boş bırakmayınız.","warning");
            }

        });

        $("#guncelleForm").on("submit",function (){
            if($("#kategori").val()!=""){
                var fdata=new FormData(document.getElementById('guncelleForm'))
                fdata.append('mkonu', $("#mailkonu").val());
                $.ajax({
                    url:"<?= base_url() ?>sms/sms/send_mails",
                    type: 'POST',
                    data:fdata,
                    success: function (response) {
                        if(response.hata=="var"){
                            setTimeout(function () {
                                toastr.warning(response.message);

                            }, 2000);
                        }else{
                            toastr.success(response.message);
                            setTimeout(function () {
                                // window.location.reload();
                            }, 2000);
                        }

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }else{
                if($("#grup").val()!=""){
                    var fdata=new FormData(document.getElementById('guncelleForm'))
                    fdata.append('mkonu', $("#mailkonu").val());
                    $.ajax({
                        url:"<?= base_url() ?>sms/sms/send_mails",
                        type: 'POST',
                        data:fdata,
                        success: function (response) {
                            if(response.hata=="var"){
                                setTimeout(function () {
                                    toastr.warning(response.message);

                                }, 2000);
                            }else{
                                toastr.success(response.message);
                                setTimeout(function () {
                                    // window.location.reload();
                                }, 2000);
                            }

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }else{
                    toastr.warning("Lütfen alıcı seçiniz");
                }
            }

        })

    });
</script>

