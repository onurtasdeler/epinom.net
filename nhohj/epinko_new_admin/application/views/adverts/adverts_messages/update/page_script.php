
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
        setInterval(function (){
            window.location.reload();
        },6000);
        $("#status").on("change",function (){
           if($(this).val()==2){
               $("#redNedeni").fadeIn(500);
           } else{
               $("#redNedeni").fadeOut(500);
           }
        });




        //turkpin selectbox ajax




    });
</script>

