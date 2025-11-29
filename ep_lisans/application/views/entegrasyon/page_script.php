<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function (){
        $("#smsayarSubmit").on("click",function (){
            $.post("<?= base_url("sms-ayarlari") ?>",$("#smsayar").serialize(),function(response){
                if(response=="1"){
                    als("İşlem Başarılı","success");
                }else{
                    als("Hata meydana geldi","error");
                }
            });
        })
    })
</script>