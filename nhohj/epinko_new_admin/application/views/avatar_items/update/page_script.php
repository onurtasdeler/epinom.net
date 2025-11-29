<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>




    function deleteModal(id,tur){
        var a="";
        $.post("<?= base_url('avatarlar-cek') ?>",{data:id},function(response){
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
            $.post("<?= base_url('avatarlar-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }
    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
         
            $.ajax({
                url:"<?= base_url("avatarlar-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");

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

