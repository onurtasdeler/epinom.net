<script src="assets/backend/js/pages/custom/login/login-general.js"></script>
<script>

    $(document).ready(function() {


        $("#login-form").on("submit",function(){
            $.post("<?= base_url("login-control") ?>",$(this).serialize(),function(response){
                var str="";
                if(response.errorr){
                    if(response.tur==2){
                        str= " * Email veya şifre hatalı tekrar deneyiniz..";
                    }else if(response.tur==3){
                        if(response.mail_error!=""){
                            $("#emailaddress").css("border","1px solid #95323D");
                            if(str!=""){ str= str + "<br> * " + response.mail_error + "";}else{ str= str + " * " + response.mail_error + "";}
                        }
                        if(response.password_error!=""){
                            $("#password").css("border","1px solid #95323D");
                            if(str!=""){ str= str + "<br> * " + response.password_error + "";}else{ str= str + " * " + response.password_error + "";}
                        }
                    }
                    else if(response.tur==5){
                        window.location.href="<?= base_url("mail-onay"); ?>";
                    }
                    $("#registerReturnHata").html(str);
                    $("#formReturn").show(300);
                }else{
                    if(response.tur==1){
                        $("#gizlenecek").hide();
                        $("#successAlert").show(200);
                        setTimeout(function(){
                            window.location.href="<?= base_url() ?>";
                        }, 1500);
                    }else{
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>