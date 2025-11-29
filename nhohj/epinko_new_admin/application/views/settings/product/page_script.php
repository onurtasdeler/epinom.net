<script>

    function deleteModal(id,tur){
        var a="";
        var turs=tur;
        $.post("<?= base_url('get-record') ?>",{data:1,table:"table_options"},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">Resim Silinecektir. Emin misiniz ?</strong>' );
                $("#silinecek").val(id);
                $("#tur").val(turs);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function deleteModalSubmit(){
        var a=$("#silinecek").val();
        var tur=$("#tur").val();
        if(a!=""){
            if(tur==7){
                $.post("<?= base_url('image-deletes') ?>",{data:a,tur:tur,table:"table_options",field:"icon_vitrin",folder:"icon"},function(response){
                    if(response){
                        if(response.hata=="var"){
                            alertToggle(2,"Hata",response.message);
                        }else{
                            alertToggle(1,"Resim Silindi.","Başarılı");
                            setTimeout(function(){ window.location.reload(); }, 1000);

                        }

                    }else{
                        alertToggle(2,"Hata","Hata");
                    }
                });
            }else if(tur==8){
                $.post("<?= base_url('image-deletes') ?>",{data:a,tur:tur,table:"table_options",field:"icon_otomatik",folder:"icon"},function(response){
                    if(response){
                        if(response.hata=="var"){
                            alertToggle(1,"Resim Silindi.","Başarılı");
                            setTimeout(function(){ window.location.reload(); }, 1000);
                        }else{
                            alertToggle(2,"Hata","Hata");
                        }

                    }else{
                        alertToggle(2,"Hata","Hata");
                    }
                });
            }else if(tur==9){
                $.post("<?= base_url('image-deletes') ?>",{data:a,tur:tur,table:"table_options",field:"icon_dogrulanmis",folder:"icon"},function(response){
                    if(response){
                        if(response.hata=="var"){
                            alertToggle(1,"Resim Silindi.","Başarılı");
                            setTimeout(function(){ window.location.reload(); }, 1000);
                        }else{
                            alertToggle(2,"Hata","Hata");
                        }

                    }else{
                        alertToggle(2,"Hata","Hata");
                    }
                });
            }

        }
    }

    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"<?= base_url("settings-update/product") ?>",
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

