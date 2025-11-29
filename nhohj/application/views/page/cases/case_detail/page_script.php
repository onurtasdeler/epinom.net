<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php 
$urunlerIndexArr = [];
for($i=0;$i<count($urunler);$i++):
    $urunlerIndexArr[] = $i;
endfor;
?>
<script>
        $(document).ready(function () {
            //setup multiple rows of colours, can also add and remove while spinning but overall this is easier.
        
        });
        var caseOpening = false;
        function spinWheel() {
            if(caseOpening) {
                toastr.warning("<?= (lac()==1)?"Lütfen kasa açılımınızın bitmesini bekleyiniz.":"Please wait your case opening." ?>");
                return;
            }
            caseOpening = true;
            $.ajax({
                url: '<?= base_url("purchase-case") ?>',
                method: 'POST',
                data: {
                    caseId:<?= $kasa->id ?>
                },
                success: function (response) {
                    if(response){
                        if(response.error){
                            toastr.warning(response.message);
                        }else{
                            toastr.success("<?= (lac()==1)?"Kasanız açılıyor...":"Case opening..." ?>");
                            var roll = response.data.selectedIndex;
                            var $wheel = $('.roulette-wrapper .wheel'),
                                order = JSON.parse(`<?= json_encode($urunlerIndexArr) ?>`),
                                position = order.indexOf(roll) + <?= ceil(count($urunlerIndexArr)/2) ?>;

                            //determine position where to land
                            var rows = 12,
                                card = 200 + 3 * 2,
                                landingPosition = (rows * <?= count($urunlerIndexArr) ?> * card) + (position * card);
                            console.log(position);
                                
                            const minCeiled = Math.ceil(1);
                            const maxFloored = Math.floor(<?= count($urunlerIndexArr)%2 == 1 ? 100:200 ?>);
                            var randomize = Math.floor(Math.random() * (maxFloored - minCeiled) + minCeiled);

                            landingPosition = landingPosition + randomize;

                            var object = {
                                x: Math.floor(Math.random() * 50) / 100,
                                y: Math.floor(Math.random() * 20) / 100
                            };

                            $wheel.css({
                                'transition-timing-function': 'cubic-bezier(0,' + object.x + ',' + object.y + ',1)',
                                'transition-duration': '6s',
                                'transform': 'translate3d(-' + landingPosition + 'px, 0px, 0px)'
                            });

                            setTimeout(function () {
                                $wheel.css({
                                    'transition-timing-function': '',
                                    'transition-duration': '',
                                });
                                caseOpening = false;
                                $("#resultProductName").text(response.data.selectedProduct.p_name);
                                $("#resultProductImage").attr("src","<?= base_url("upload/product") ?>/" + response.data.selectedProduct.image);
                                $("#winModal").modal("show");
                                var winMessage = "<?= langS(416) ?>";
                                winMessage =winMessage.replace("[case_name]","<?= $kasa->name ?>");
                                winMessage =winMessage.replace("[product_name]",response.data.selectedProduct.p_name);
                                winMessage =winMessage.replace("[order_no]",response.data.orderNo);
                                $("#resultMessage").text(winMessage);
                                var resetTo = -(position * card + randomize);
                                $wheel.css('transform', 'translate3d(' + resetTo + 'px, 0px, 0px)');
                            }, 6 * 1000);
                        }
                    }
                },
                error:function(err) {
                    toastr.warning("<?= (lac()==1)?"Bilinmeyen bir hata meydana geldi...":"An unknown error occured..." ?>");
                    caseOpening=false;
                },
                cache:false,
            });
        }

</script>