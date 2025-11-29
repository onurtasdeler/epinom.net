<script>
 




    $(document).ready(function (){

        $("#searchOne").on('input propertychange paste', function () {
            var value = $("#searchOne").val();
            // eğer input içinde değer yoksa yani boşsa tüm menüyü çıkartıyoruz
            if (value.length == 0) {
                $(".list-unstyled .clearfix").fadeIn(100);
                // arama yapılmışsa ilk olarak tüm menüyü gizliyoruz ve girilen değer ile eşleşen kısmı çıkarıyoruz
            } else {
                $(".list-unstyled .clearfix").fadeOut(100);
                $(".list-unstyled .clearfix:contains(" + value + ")").fadeIn(100);
            }
        });


        var body = $("html, body");
        body.stop().animate({scrollTop:330}, 300, 'swing', function() {
        });

    });
</script>