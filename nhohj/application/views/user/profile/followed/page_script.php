
<script>
    $(document).ready(function () {

        $(".unfollowButton").on("click",function (){
           var a=$(this).data("token");
           if(a){
               $.ajax({
                   url: "<?= base_url("unfollow-store") ?>",
                   type: 'POST',
                   data: {token:a},
                   success: function (response) {
                       if (response) {
                           if(response.hata=="var"){
                                toastr.warning(response.message);
                           }else {
                                toastr.success(response.message);
                                setTimeout(function (){window.location.reload()},1200);
                           }
                       } else {
                           toastr.warning("<?=langS(22,2)  ?>");
                       }
                   },
                   cache: false,

               });
           }
        });

    });
</script>