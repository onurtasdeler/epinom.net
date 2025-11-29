<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    


    function deleteModal(id,tur){
        var a="";
        $.post("<?= base_url('ilan-cek') ?>",{data:id},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
                $("#tur").val(tur);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function deleteModalSubmit(){
        var a=$("#silinecek").val();
        var tur=$("#tur").val();
        if(a!=""){
            $.post("<?= base_url('ilan-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","Başarılı");
                    //setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }
    $(document).ready(function() {

        $("#status").on("change",function (){
           if($(this).val()==5){
               $("#redNedeni").fadeIn(500);
           } else{
               $("#redNedeni").fadeOut(500);
           }
        });

        //turkpin selectbox ajax


        $('.float-number').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $("#status").change(function (){
           if($(this).val()==2){
                $("#kodlar").fadeIn(200);
           }else{
               $("#kodlar").fadeOut(200);
           }
        });



        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);

            alertS("Lütfen Bekleyiniz..","warning");
            $.ajax({
                url:"<?= base_url("siparis-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                            setTimeout(function() {window.location.reload()}, 600);
                        }
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
</script>

