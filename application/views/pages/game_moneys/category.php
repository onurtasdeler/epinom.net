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

        <div class="bg-white py-3 shadow-sm text-primary mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent mb-0">
                                <li class="breadcrumb-item"><a href="<?=base_url()?>">Anasayfa</a></li>
                                <li class="breadcrumb-item"><a href="<?=base_url('oyun-parasi')?>">Oyun Parası</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?=$category->title?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center">
                            <img src="<?=base_url("public/categories/" . $category->image_url)?>" width="150" class="rounded">
                            <h1 class="display-4 pl-4"><?=$category->title?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4 mb-4">
            <div class="row">
                <div class="col-lg-12">
                <?php
                    if(count($products)<1){
                ?>
                    <div class="alert alert-info">
                        <i data-feather="info"></i> Hiç ürün bulunmuyor.
                    </div>
                <?php
                    }else{
                ?>
                    <div class="table-responsive bg-white d-none d-md-block">
                        <table class="table table-hover table-condensed table-bordered mb-0">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-white">Ürün</th>
                                <th class="text-center text-white">Stok Durumu</th>
                                <th class="text-center text-white">Satış Fiyatı</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($products as $product):
                                ?>
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <img src="<?=base_url('public/categories/' . ($product->image_url ? $product->image_url : $category->image_url))?>" alt="<?=$product->product_name?>" width="85" class="mr-2 rounded">
                                            <div>
                                                <div class="h5 font-weight-bold"><?=$product->title?></div>
                                                <div>
                                                    <span class="font-weight-bold">Alış Fiyatı: <?=number_format($product->selltous_price, 2)?> AZN</span>
                                                    <a class="btn btn-sm btn-dark" href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id . '/bize-sat')?>">
                                                        Bize Sat
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle font-weight-bold text-center" width="10%">
                                    <?php
                                        if ($product->is_stock == 1 && $product->stock_qty > 0) {
                                    ?>
                                        <span class="text-success small font-weight-bold">
                                            <i data-feather="check" class="p-1 rounded-circle text-white bg-success"></i><br> <?=$product->stock_qty?> <small>Adet</small>
                                        </span>
                                    <?php
                                        } else {
                                    ?>
                                        <span class="text-danger small font-weight-bold">
                                            <i data-feather="x-circle" class="rounded-circle text-danger"></i> <br>Stokta Yok
                                        </span>
                                    <?php
                                        }
                                    ?>
                                    </td>
                                    <td class="align-middle text-center font-weight-bold" width="15%">
                                        <a class="text-dark text-dotted" href="javascript:;" data-toggle="tooltip" title="Birim satış fiyatıdır.">
                                            <?=number_format($product->price, 2)?> <small class="text-muted">TL</small>
                                        </a>
                                        <i data-feather="info" width="16" height="16"></i>
                                    </td>
                                    <td width="15%" class="align-middle text-center text-right">
                                    <?php
                                        if (getActiveUser()) {
                                    ?>
                                        <a class="btn btn-primary btn-block" href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id)?>">
                                            <i data-feather="shopping-cart" style="margin-bottom:4px" width="14" height="14"></i> Satın Al
                                        </a>
                                    <?php
                                        } else {
                                    ?>
                                        <a class="btn btn-primary btn-block" href="<?=base_url('uye/giris-yap?r=' . urlencode(current_url()))?>">
                                            <i data-feather="user" width="14" height="14" style="margin-bottom:4px;"></i> Giriş Yap
                                        </a>
                                    <?php
                                        }
                                    ?>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                <div class="d-block d-md-none">
                    <?php
                    foreach($products as $product):
                        ?>
                        <div class="bg-white p-2 shadow-sm mb-3 rounded">
                            <div class="d-block d-md-none justify-content-between align-items-center">
                                <div class="d-block mb-md-0 mb-2 d-md-flex text-center text-md-left align-items-center">
                                    <div class="mr-2 rounded d-none d-md-block" style="width:64px;height:64px;background-size:cover;background-position:center;background-image:url(<?=base_url('public/categories/' . ($product->image_url ? $product->image_url : $category->image_url))?>)">
                                    </div>
                                    <div>
                                        <a href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id)?>" class="d-block text-dark">
                                            <h5 class="mb-0"><?=$product->title?></h5>
                                        </a>
                                        <span class="text-primary small"><?=$product->provisions?></span>
                                        <div class="text-dark">
                                            <span class="font-weight-bold">
                                                Alış Fiyatı: <?=number_format($product->selltous_price, 2)?> AZN
                                            </span>
                                            <a href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id . '/bize-sat')?>" class="btn btn-dark btn-sm">
                                                Bize Sat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block d-md-flex justify-content-center align-items-center">
                                    <div class="d-flex justify-content-center mb-2 mb-md-0">
                                        <div class="pr-md-3 pr-0">
                                            <div class="text-dark font-weight-bold">Satış Fiyatı: <?=number_format($product->price, 2)?> AZN</div>
                                        </div>
                                    </div>
                                    <div class="text-center text-md-left">
                            <?php
                            if ($product->is_stock == 1) {
                            ?>
                                <div class="mb-2">
                                    <span class="text-success font-weight-bold">
                                        <span data-feather="check"></span> <?=$product->stock_qty?> <small>Adet Mevcut</small>
                                    </span>
                                </div>
                            <?php
                                if (getActiveUser()) {
                                    ?>
                                        <a class="btn btn-primary" href="<?=base_url('oyun-parasi-urunu/' . $product->slug . '/' . $product->id)?>">
                                            <i data-feather="shopping-cart" width="14" height="14"></i> Satın Al
                                        </a>
                                    <?php
                                } else {
                                    ?>
                                        <a class="btn btn-primary" href="<?=base_url('uye/giris-yap?r=' . urlencode(current_url()))?>">
                                            <i data-feather="user" width="14" height="14"></i> Giriş Yap
                                        </a>
                                    <?php
                                }
                            } else {
                                ?>
                                        <span class="text-danger font-weight-bold">
                                            <span data-feather="x-circle"></span> Stokta Yok
                                        </span>
                                    <?php
                            }
                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    }
                    ?>
                </div>
                </div>
            </div>
        </div>

        <div class="container mb-4">
            <nav>
                <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                    <a class="nav-item active nav-link rounded-0" id="nav-howtobuy-tab" data-toggle="tab" href="#nav-howtobuy" role="tab" aria-controls="nav-howtobuy" aria-selected="false"><i data-feather="help-circle" width="18" height="18"></i> Nasıl Alınır?</a>
                    <a class="nav-item nav-link rounded-0" id="nav-howtosell-tab" data-toggle="tab" href="#nav-howtosell" role="tab" aria-controls="nav-howtosell" aria-selected="false"><i data-feather="help-circle" width="18" height="18"></i> Nasıl Satılır?</a>
                    <a class="nav-item nav-link rounded-0" id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab" aria-controls="nav-comments" aria-selected="false"><i data-feather="message-square" width="18" height="18"></i> Yorumlar <small>(<?=$total_comment_count?> Yorum)</small></a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-howtobuy" role="tabpanel" aria-labelledby="nav-howtobuy-tab">
                    <div class="bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center text-dark bg-white border-bottom border-primary p-3">
                            <h1 class="h5 mb-0">
                                <i data-feather="help-circle" width="18" height="18" class="text-primary"></i> Nasıl Alırım?
                            </h1>
                        </div>
                        <div class="p-3 overflow-auto">
                            <div><?=$category->howtobuy ? $category->howtobuy : '<small class="text-muted">İçerik girilmemiş.</small>'?></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-howtosell" role="tabpanel" aria-labelledby="nav-howtosell-tab">
                    <div class="bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center text-dark bg-white border-bottom border-primary p-3">
                            <h1 class="h5 mb-0">
                                <i data-feather="help-circle" width="18" height="18" class="text-primary"></i> Nasıl Satarım?
                            </h1>
                        </div>
                        <div class="p-3 overflow-auto">
                            <div><?=$category->howtosell ? $category->howtosell : '<small class="text-muted">İçerik girilmemiş.</small>'?></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
                    <div class="bg-white shadow-sm">
                        <div class="d-flex justify-content-between align-items-center text-dark bg-white border-bottom border-primary p-3">
                            <h1 class="h5 mb-0">
                                <i data-feather="message-square" width="18" height="18" class="text-primary"></i> Müşteri Yorumları <small class="text-muted">(<?=$total_comment_count?> Yorum)</small>
                            </h1>
                            <?php
                            if(getActiveUser()) {
                                ?>
                                <div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addCommentModal">Yorum Yap</button>
                                    <div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <?=form_open(current_url(), [
                                                    'id' => 'addCommentForm'
                                                ])?>
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i data-feather="message-square"></i> Yorum Yap</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="commentAlertArea"></div>
                                                    <div id="commentFormElements">
                                                        <input type="hidden" name="addComment" value="ok">
                                                        <div class="form-group">
                                                            <label for="commentTextarea" class="form-label">Oyunuz</label>
                                                            <select name="point" required class="form-control">
                                                                <option value="">Seçiniz</option>
                                                                <option value="1">1 Puan</option>
                                                                <option value="2">2 Puan</option>
                                                                <option value="3">3 Puan</option>
                                                                <option value="4">4 Puan</option>
                                                                <option value="5">5 Puan</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="commentTextarea" class="form-label">Yorumunuz</label>
                                                            <textarea name="comment" required maxlength="300" id="commentTextarea" rows="4" class="form-control" placeholder="Bir şeyler yazın."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Kapat</button>
                                                    <button type="submit" class="btn btn-primary">Yorumu Gönder</button>
                                                </div>
                                                <?=form_close()?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="p-3 overflow-auto">
                            <?php
                            if(count($comments)>0){
                                ?>
                                <small class="text-muted d-block text-left pl-2 pt-2 pb-2">Son <?=count($comments)?> yorum gösteriliyor.</small>
                                <?php
                                foreach($comments as $comment):
                                    $comment_user = $this->db->where([
                                        'id' => $comment->user_id
                                    ])->get('users')->row();
                                    ?>
                                    <div class="comment rounded border bg-light p-1 mb-2">
                                        <div class="d-flex justify-content-between align-content-center pl-2">
                                            <div class="text-dark font-weight-bold font-vietnam">
                                                <i data-feather="user" width="16" height="16"></i> <?=explode(' ', $comment_user->full_name)[0]?>
                                            </div>
                                            <div class="text-muted small font-vietnam"><?=date('d.m.Y H:i', strtotime($comment->created_at))?> tarihinde yazıldı.</div>
                                        </div>
                                        <div class="mt-0 p-2 rounded">
                                            <p class="mb-0 text-dark"><?=$comment->text?></p>
                                            <div class="text-primary">
                                            <span>
                                        <?php
                                        for($x=0;$x<$comment->point;$x++){
                                            ?>
                                            <i data-feather="star" width="16" height="16"></i>
                                            <?php
                                        }
                                        ?>
                                            </span>
                                                <small class="text-muted"><?=$comment->point?> Puan</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            }else{
                                ?>
                                <div class="small">
                                    <i data-feather="info" class="text-primary" width="16" height="16"></i> <span class="text-muted">Hiç yorum bulunmuyor.</span>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE END -->

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
                            $($(this).data('formarea')).remove();
                            setTimeout(function(){
                                window.location.reload();
                            },3000);
                        }
                        $($(this).data('alertarea')).html(res.alert);
                        $(this).attr('disabled', false);
                        $(form).children('input[name="<?=$this->security->get_csrf_token_name()?>"]').val(res.csrf.token);
                    })
                });
                $('.buyProductFormSubmitButton').on('click', function(e){
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    var form = $(this).parent().parent();
                    $.post(form.action, form.serialize(), (res)=>{
                        var res = JSON.parse(res);
                        if(res.error == false){
                            $($(this).data('formarea')).remove();
                            setTimeout(function(){
                                window.location.reload();
                            },3000);
                        }
                        $($(this).data('alertarea')).html(res.alert);
                        $(this).attr('disabled', false);
                        $(form).children('input[name="<?=$this->security->get_csrf_token_name()?>"]').val(res.csrf.token);
                    })
                });
            })
        </script>

    </body>
</html>