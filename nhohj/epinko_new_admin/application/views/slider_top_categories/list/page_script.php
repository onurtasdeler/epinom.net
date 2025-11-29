<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>

<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>



<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->

<script>



</script>

<script>

    var tabless;

    $("#menu #makaleId").html("");



    // begin first table





    function sosyalDelete(id){

        var a="";

        $.post("<?= base_url($this->nameTekil.'-cek') ?>",{data:id},function(response){

            if(response){

                $("#menu #makaleId").html('<strong style="color:green">' + response + "</strong>" );

                $("#silinecek").val(id);

            }else{

                alertToggle(2,"Bir hata meydana geldi.","hata ");

            }

        });

    }

    function sosyalDelete2(id){

        var a="";

        var form = $("#frm-example");

        var rows_selected = tabless.column(0).checkboxes.selected();

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

            $.post("<?= base_url($this->nameTekil.'-cek-toplu') ?>",{data : str,tur:1},function(response){

                $("#vazgectoplu").html("Vazgeç");

                $("#siltopluonay").show();

                $("#siltopluonay").attr("onclick",'gonder(2)');

                $("#menu2 #makaleId").html("Kayıtlar Silinecektir. Emin misiniz ?");

                $("#menu2 #toplumetin").html("<br>" + response + " adlı kayıtlar silinecektir.");

            });



        }

        /*$.post("<?= base_url('liman-cek') ?>",{data:id},function(response){



            if(response){

                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );

                $("#silinecek").val(id);



            }else{

                alertToggle(2,"Bir hata meydana geldi.","hata ");

            }

        });*/

    }




    function durum_degistir(types,id){

        if(types!=""){

            var $data= $("#switch-lg_" + types + "_" + id).prop("checked");

            var $data_url=$("#switch-lg_" + types + "_" + id).data("url");

        }else{

            var $data= $("#switch-lg_" + id).prop("checked");

            var $data_url=$("#switch-lg_" + id).data("url");

        }



        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){

            $.post($data_url,{data : $data},function(response){

                if(response==2){

                    alertToggle(2,"Bir hata meydana geldi.","Hata");



                }else if(response==1){

                    alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");

                }

            });

        }

    }



    function sosyal_delete(){

        var a=$("#silinecek").val();

        if(a!=""){

            $.post("<?= base_url($this->nameTekil.'-sil') ?>",{data:a},function(response){

                if(response){

                    alertToggle(1,"<?= $this->titleAdTekil ?> Silindi.","İşlem Başarılı");

                    setTimeout(function(){ window.location.reload(); }, 400);

                }else{

                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }

            });

        }

    }



    function sosyal_delete2(){

        var a=$("#silinecek").val();

        if(a!=""){

            $.post("<?= base_url($this->nameTekil.'-sil') ?>",{data:a},function(response){

                if(response){

                    alertToggle(1,"<?= $this->titleAdTekil ?> Silindi.","İşlem Başarılı");

                    setTimeout(function(){ window.location.reload(); }, 400);

                }else{

                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }

            });

        }

    }





    $(document).ready(function() {

    });

</script>









