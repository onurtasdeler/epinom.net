<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=$category->page_title?></title>
        <meta name="description" content="<?=$category->meta_description?>">
        <meta name="keywords" content="<?=$category->meta_keywords?>">
    </head>
    <body class="home-body-bg">

        <?php
            $this->load->view("template_parts/header");
        ?>

        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-white shadow-sm">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>">Anasayfa</a></li>
                            <li class="breadcrumb-item"><a href="<?=base_url('oyun-parasi')?>">Oyun Parası</a></li>
                            <li class="breadcrumb-item"><a href="<?=base_url('oyun-parasi/' . $category->slug . '/' . $category->id)?>"><?=$category->title?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$product->title?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- PAGE -->

        <div class="container mt-4 mb-4">
            <div class="row">
                <div class="col-lg-3 d-none d-md-block">
                    <div>
                        <img class="w-100 border border-primary rounded shadow-sm" src="<?=base_url('public/categories/' . $category->image_url)?>" alt="<?=$category->title?>">
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="bg-white p-2 shadow-sm border-primary border-bottom mb-4">
                        <div class="d-block d-md-flex justify-content-between align-items-center">
                            <div class="d-flex mb-2 mb-md-0 align-items-center">
                                <div>
                                    <h5 class="mb-0 font-weight-bold"><?=$product->title?></h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="pr-3">
                                    <div class="small text-muted text-uppercase">Bize Sat</div>
                                    <div class="text-dark"><?=number_format($product->selltous_price, 2)?> <small>AZN</small></div>
                                </div>
                                <div class="pr-3">
                                    <div class="small text-muted text-uppercase">Fiyat</div>
                                    <div class="text-dark"><?=number_format($product->price, 2)?> <small>AZN</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-2 shadow-sm border-primary border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Satın Al</h4>
                            <a href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id . '/bize-sat')?>" class="btn btn-outline-primary btn-sm">
                                Bize Sat
                            </a>
                        </div>
                    </div>
                    <div class="bg-white p-3 shadow-sm mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="small text-danger font-weight-bold rounded-0">
                                    <p>● Teslimat sırasında PM'inizi kapalı tutunuz ve sizinle oyun içerisinden iletişime geçmeye çalışan kişilere kesinlikle yanıt vermeyiniz.<br>●&nbsp;Biz asla teslim ettiğimiz ürünleri geri istemeyiz.<br>● Trade ile verilmektedir.</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                            <?php
                                if(isset($alert)):
                            ?>
                                <div class="alert alert-<?=$alert['class']?>"><?=$alert['message']?></div>
                            <?php
                                endif;
                            ?>
                            <?php
                                if(@$alert['class'] != 'success'){
                            ?>
                                <?=form_open(current_url(), [
                                    'orderForm'
                                ])?>
                                    <input type="hidden" name="buyproduct" value="<?=md5($product->id.$product->slug)?>">
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Ürün</label>
                                        <input type="hidden" value="<?=$product->id?>" name="product">
                                        <h4 class="mb-0"><?=$product->title?></h4>
                                        <small class="text-primary"><?=$product->provisions?></small>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="small text-muted mb-0">Adet</label>
                                            <input type="number" id="buyProductQtyInput<?=$product->id?>" data-piece-price="<?=$product->price?>" data-earndiv="#earnMoneyS<?=$product->id?>" placeholder="Adet" required min="1" value="<?=set_value('qty') ? set_value('qty') : 1?>" name="qty" class="form-control qtyInput">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted mb-0">Karakter Adı</label>
                                            <input type="text" maxlength="255" required placeholder="Karakter Adı" name="character_name" value="<?=set_value('character_name')?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="small text-muted mb-0">Adet Fiyatı</label>
                                            <div class="text-primary"><?=number_format($product->price, 2, ',', '.')?>₺</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted mb-0">Toplam Tutar <small>(Adet x <?=number_format($product->price, 2, ',', '.')?>₺)</small></label>
                                            <div id="earnMoneyS<?=$product->id?>" class="text-primary"><?=number_format(( set_value('qty') ? set_value('qty') * $product->price : $product->price ), 2, ',', '.')?>₺</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Siparişi Tamamla</button>
                                    </div>
                                <?=form_close()?>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-2 shadow-sm border-primary border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Ürün Açıklaması</h4>
                        </div>
                    </div>
                    <div class="bg-white p-3 shadow-sm">
                        <div><?=$product->description ? $product->description : '<div class="text-center text-muted small">Ürün açıklaması bulunmuyor.</div>'?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE END -->

        <div class="modal fade" id="bizeSatModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?=$product->title?> - Bize Sat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="bizesatAlertArea"></div>
                        <div class="row" id="formElements">
                            <div class="col-lg-6">
                                <div class="alert small">
                                    <ul class="m-0 p-0">
                                        <li> 
                                            <b><i class="far fa-exclamation-circle"></i> Ürün satışı geçtikten sonra "Ürünü teslim alacak karakter oyuna giriyor lütfen bekleyiniz" yazısı gelecektir. Bu alanda "Teslimat Karakteri : xxxx" şekline bir Nick verilene kadar oyun parasını kimseye vermeyiniz. </b>
                                        </li>
                                        <li> 
                                            <i class="far fa-exclamation-circle"></i> Teslimat Karakterinde verilen Nicke dikkat ediniz.
                                        </li>
                                        <li> 
                                            <b><i class="far fa-exclamation-circle"></i> Benzer şekilde açılan nicklere teslimat yapmayınız.</b>
                                        </li>
                                        <li> 
                                            <i class="far fa-exclamation-circle"></i> Oyun içerisinde size Trade, Party, Battle veya PM atarak yönlendirmeye çalışan DOLANDIRICILARA inanmayınız.
                                        </li>
                                        <li>
                                            <i class="far fa-exclamation-circle"></i> Vatangame ekibi oyun içerisinden pm (mesaj) atmaz.
                                        </li>
                                        <li> 
                                            <i class="far fa-exclamation-circle"></i> Teslimat sırasında oluşacak her türlü soru veya sorun için canlı desteğe bağlanarak bilgi alınız.
                                        </li>
                                        <li>
                                            <i class="far fa-exclamation-circle"></i> Hatalı teslimat yapmanız durumunda hiçbir şekilde sorumluluk kabul etmiyoruz.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?=form_open(current_url(), [
                                    'id' => 'bizeSatModal' . $product->id . 'bizeSatForm'
                                ])?>
                                    <input type="hidden" name="selltous" value="<?=md5($product->id.$product->slug)?>">
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Ürün</label>
                                        <input type="hidden" value="<?=$product->id?>" name="product">
                                        <h4><?=$product->title?></h4>
                                    </div>
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Adet</label>
                                        <input type="number" id="bizeSatQtyInput<?=$product->id?>" data-piece-price="<?=$product->selltous_price?>" data-earndiv="#earnMoney<?=$product->id?>" placeholder="Adet" required value="1" min="1" name="qty" class="form-control qtyInput">
                                    </div>
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Alış Fiyatı</label>
                                        <div class="text-info"><?=number_format($product->selltous_price,2,',','.')?>₺</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Hesabınıza Geçecek Tutar</label>
                                        <div id="earnMoney<?=$product->id?>" class="text-primary"><?=number_format($product->selltous_price, 2, ',', '.')?>₺</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="small text-muted mb-0">Karakter Adı</label>
                                        <input type="text" maxlength="255" required placeholder="Karakter Adı" name="character_name" class="form-control">
                                    </div>
                                    <div class="text-left text-md-right">
                                        <button type="submit" class="btn btn-primary bizeSatFormSubmitButton" data-alertarea="#bizesatAlertArea<?=$product->id?>" data-formarea="#bizesatFormArea<?=$product->id?>">Satışı Tamamla</button>
                                    </div>
                                <?=form_close()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $this->load->view("template_parts/footer");
        ?>

        <script src="<?=base_url("assets/dist/js/script.js")?>?ver=13"></script>
        <script async>var SITE_URL = "<?=base_url()?>";</script>
        <script async>
            function formatMoney(number, decPlaces, decSep, thouSep) {
                decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                decSep = typeof decSep === "undefined" ? "." : decSep;
                thouSep = typeof thouSep === "undefined" ? "," : thouSep;
                var sign = number < 0 ? "-" : "";
                var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
                var j = (j = i.length) > 3 ? j % 3 : 0;

                return sign + (j ? i.substr(0, j) + thouSep : "") + i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) + (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
            }
            $(function(){
                $('.qtyInput').on('input', function(){
                    if($(this).val()<1){
                        $(this).val(1);
                    }
                    $($(this).data('earndiv')).html(formatMoney((parseFloat($(this).val())*parseFloat($(this).data('piece-price'))), '.', ',') + '₺');
                });
            });
            $(function(){
                $('.bizeSatFormSubmitButton').on('click', function(e){
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    var form = $(this).parent().parent();
                    $.post(form.action, form.serialize(), (res)=>{
                        var res = JSON.parse(res);
                        if(res.error == false){
                            $('#formElements').remove();
                            setTimeout(function(){
                                window.location.href = "<?=current_url()?>";
                            },3000);
                        }
                        $('#bizesatAlertArea').html(res.alert);
                        $(this).attr('disabled', false);
                        $(form).children('input[name="<?=$this->security->get_csrf_token_name()?>"]').val(res.csrf.token);
                    })
                });
            })
        </script>

    <?php
        if(isset($_GET['bize-sat'])){
    ?>
        <script async>
        $(function(){
            $('#bizeSatModal').modal('show');
        });
        </script>
    <?php
        }
    ?>

    </body>
</html>