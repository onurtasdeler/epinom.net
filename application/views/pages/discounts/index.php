<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
    $this->load->view("template_parts/head");
    ?>
    <title><?=getSiteTitle() . ' - İndirimli Ürünler'?></title>
    <?php
    $metas = getConfig();
    ?>
    <meta name="description" content="<?=$metas->meta_description?>">
    <meta name="keywords" content="<?=$metas->meta_keywords?>">
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
                        <li class="breadcrumb-item active" aria-current="page">İndirimli Ürünler</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div>
                    <h1 class="display-4 mb-0">İndirimli Ürünler</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
        <?php
            if (count($categories) > 0) {
        ?>
           <div class="category-list">
            <?php
                foreach($categories as $category){
                    $category->hasDiscount = $this->db
                        ->where([
                            'discount>' => 0,
                            'is_active' => 1,
                            'category_id' => $category->id
                        ])->order_by('discount DESC, id DESC')->get('products')->row();
                    $show = TRUE;
                    if (!empty($product->discount_end_date)) {
                        if (time() - strtotime($product->discount_end_date) > 0) {
                            $show = FALSE;
                        }
                    }
                    if ($show == TRUE) {
            ?>
                <div class="rounded category border position-relative" id="product__<?=md5($category->id)?>">
                <?php
                    if ($category->hasDiscount->discount > 0) {
                ?>
                    <div class="animate__animated animate__pulse">
                        <div class="category-discount py-0 bg-success-gradient rounded-top shadow">
                            <div>%<?=$category->hasDiscount->discount?> İndirim!</div>
                        <?php
                            if (!empty($category->hasDiscount->discount_end_date)) {
                        ?>
                            <div style="background: rgba(0, 0, 0, 0.15);" data-parent="#product__<?=md5($category->id)?>" data-countdown="<?=date('Y-m-d H:i:s', strtotime($category->hasDiscount->discount_end_date))?>"></div>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
                    <div class="category-image bg-white rounded-top" style="background-size:100%;background-repeat:no-repeat;background-image:url(<?=base_url('public/categories/' . $category->image_url)?>)"></div>
                    <div class="category-title bg-white rounded-bottom text-truncate">
                        <div class="d-block">
                            <a href="<?=base_url('oyunlar/' . $category->category_url)?>" class="d-block text-center stretched-link">
                                <span class="font-weight-bold d-block text-truncate"><?=$category->category_name?></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php
                    }
                }
            ?>
           </div>
       <?php
            } else {
        ?>
            <div class="alert alert-info"><span data-feather="info"></span> Şu anda indirimde olan ürün bulunmuyor.</div>
        <?php
            }
        ?>
        </div>
    </div>
</div>

<!-- PAGE END -->

<?php
$this->load->view("template_parts/footer");
?>

<script src="<?=base_url("assets/dist/js/script.js?v=" . time())?>"></script>
<script async>var SITE_URL = "<?=base_url()?>";</script>
</body>
</html>