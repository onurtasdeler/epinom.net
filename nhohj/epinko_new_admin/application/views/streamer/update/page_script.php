<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/custom/chat/chat.js?v=7.2.9"></script>

<!--end::Page Vendors-->

<script>





    function deleteModal(id){

        var a="";

        $.post("<?= base_url('yayinci-basvurulari-cek') ?>",{data:id},function(response){

            if(response){

                $("#makaleId").html('<strong style="color:green">' + response.username + "</strong>" );

                $("#menu #silinecek").val(id);


            }else{

                alertToggle(2,"Bir hata meydana geldi.","hata ");

            }

        });

    }



    function deleteModalSubmit(){

        var a=$("#menu #silinecek").val();


        if(a!=""){

            $.post("<?= base_url('yayinci-basvurulari-img-sil') ?>",{data:a},function(response){

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



        $("#status").change(function (){

            if($(this).val()==2){

                $("#redneden").fadeIn(200);

            }else{

                $("#redneden").fadeOut(200);

            }

        });



        $("#guncelleForm").on("submit",function (e){

            e.preventDefault();

            var formData = new FormData(this);

            $(".dis").prop("disabled",true);

            $.ajax({

                url:"<?= base_url("yayinci-basvurulari-guncelle/".$data["veri"]->id) ?>",

                type: 'POST',

                data: formData,

                success: function (response) {

                    if(response){

                        if(response.err){

                            $(".dis").prop("disabled",false);

                            alertS(response.message,"error");

                        }else{

                            alertS(response.message,"success");

                            //setTimeout(function(){ window.location.reload(); }, 500);

                        }

                    }else{

                        $(".dis").prop("disabled",false);

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



