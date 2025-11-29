<!DOCTYPE html>
<html lang="tr">
    <head>
    <?php
        $this->load->view("template_parts/head");
    ?>
        <title><?=getSiteTitle()?></title>
    <?php
        $metas = getConfig();
    ?>
        <meta name="description" content="<?=$metas->meta_description?>">
        <meta name="keywords" content="<?=$metas->meta_keywords?>">
    </head>
    <body id="kt_body" class="dark-mode header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Main-->
        <?php if(is_array(headAnnouncements()) && headAnnouncements() != null): ?>
        <div class="bg-primary text-light">
            <div class="container">
                <div class="row">
                    <div class="col">
                    <i data-feather="volume-2" class="ml-2 mb-0"></i>
                    </div>
                    <div class="col-11">
                        <marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <?php foreach(headAnnouncements() as $_anc): ?>
                            <a href="<?=$_anc->a_link?>" class="text-white ml-5 font-weight-bold"><?=$_anc->content?></a>
                            <?php endforeach; ?>
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        
                <?php
                    $this->load->view("template_parts/header");
                ?>
                
                    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                        <!--begin::Post-->
                        <div class="content flex-row-fluid" id="kt_content">
                            <div class="row g-3 align-items-center">
                            <?php
                                if (count($slides) > 0 && $showSlider == 1){
                            ?>
                                <div class="col-12 col-md-<?= (count($slides2) || count($slides3))?'9':'12' ?>">
                                    <div id="home-slider">
                                        <div class="swiper swiper-container rounded">
                                            <div class="swiper-wrapper">
                                                <?php
                                                foreach($slides as $_slide):
                                                    ?>
                                                    <div class="swiper-slide rounded overflow-hidden" onclick="window.location.href='<?=$_slide->link?>'" style="cursor:pointer;">
                                                        <img src="<?=base_url('public/slider/' . $_slide->image_url)?>" width="100%" height="auto">
                                                    </div>
                                                    <?php
                                                endforeach;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                if (count($slides2) || count($slides3)){
                                    ?>
                                <div class="col-12 col-md-3">
                                    <div class="row g-3">
                                        <?php if(count($slides2)): ?>
                                            <div class="col-6 col-md-12">
                                                <div id="home-slider-rt" class="w-100">
                                                    <div class="swiper swiper-container rounded">
                                                        <div class="swiper-wrapper">
                                                            <?php
                                                            foreach($slides2 as $_slide):
                                                                ?>
                                                                <div class="swiper-slide rounded overflow-hidden" onclick="window.location.href='<?=$_slide->link?>'" style="cursor:pointer;">
                                                                    <img src="<?=base_url('public/slider/' . $_slide->image_url)?>" width="100%" height="auto">
                                                                </div>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(count($slides3)): ?>
                                            <div class="col-6 col-md-12">
                                                <div id="home-slider-rb" class="w-100">
                                                    <div class="swiper swiper-container rounded">
                                                        <div class="swiper-wrapper">
                                                            <?php
                                                            foreach($slides3 as $_slide):
                                                                ?>
                                                                <div class="swiper-slide rounded overflow-hidden" onclick="window.location.href='<?=$_slide->link?>'" style="cursor:pointer;">
                                                                    <img src="<?=base_url('public/slider/' . $_slide->image_url)?>" width="100%" height="auto">
                                                                </div>
                                                                <?php
                                                            endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                }
                            }
                            ?>
                            </div>
                            <?php
                            if (count($menuCategories) > 0){
                                ?>
                                    <div class="row mt-5 d-none d-md-flex">
                                        <div class="col-lg-12">
                                            <div id="home-popular-boxes" class="home-popular-boxes top-main-products d-flex justify-content-center gap-3 align-items-center">
                                                <?php
                                                foreach ($menuCategories as $_pc):
                                                    ?>
                                                    <a class="d-block border shadow-sm popular-box mr-2 mr-md-0 bg-white rounded-circle shadow-sm overflow-hidden d-flex justify-content-around align-items-center top-main-product" href="<?=base_url('oyunlar/' . $_pc->category_url)?>">
                                                        <img src="<?=base_url('public/categories/' . $_pc->image_url)?>" height="68px" width="68px">
                                                    </a>
                                                <?php
                                                endforeach;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                            <?php
                                if (count($popularCategories)) {
                            ?>
                                    <div class="row mt-5 pt-5 g-3">
                                        <div class="col-12">
                                            <div class="home-products-card">
                                                <div class="home-products-desc">
                                                    <h2>Popüler Kategoriler</h2>
                                                    <p>Müşteriler tarafından en çok tercih edilen ürünlerimiz</p>
                                                </div>
                                                <a href="<?= base_url('oyunlar'); ?>" class="home-products-btn btn btn-sm btn-primary">Tümü</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div id="popular-categories" class="row g-5">
                                            <?php
                                                foreach ($popularCategories as $_pop):
                                                    $_pop->hasDiscount = $this->db->where([
                                                        'discount>' => 0,
                                                        'category_id' => $_pop->id
                                                    ])->order_by('discount DESC')->get('products')->result();
                                            ?>
                                                <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                                    <a href="<?=base_url('oyunlar/' . $_pop->category_url)?>" class="position-relative product-card">
                                                        <?php if($_pop->is_new == 1 && 1==0) { ?>
                                                            <span class="position-absolute badge badge-success z-index-3" style="top:5px;left:5px;">Yeni</span>
                                                        <?php } ?>
                                                        <?php if(count($_pop->hasDiscount)>0 && 1==0) { ?>
                                                            <span class="position-absolute badge badge-primary z-index-3" style="top:5px;right:5px;">%<?=$_pop->hasDiscount[0]->discount?> İndirim</span>
                                                        <?php } ?>
                                                        <div class="card shadow-sm rounded overflow-hidden">
                                                            <div class="card-body p-0">
                                                                <img src="<?=image_url('categories/' . $_pop->image_url)?>" width="100%" class="product-card-image">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php
                                                endforeach;
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                            <?php
                                if (count($homePageCategories)) { 
                            ?>
                                <div class="row mt-5 pt-5 g-3">
                                    <?php foreach($homePageCategories as $category): 
                                        $categoryProducts = $this->db->query("SELECT * FROM products WHERE category_id={$category->id} AND is_active=1")->result();
                                        ?>
                                    <div class="col-12">
                                        <div class="home-products-card">
                                            <div class="home-products-desc">
                                                <h2><?= $category->category_name ?></h2>
                                                <p><?= $category->homepage_text ?></p>
                                            </div>
                                            <?php if(!empty($category->homepage_image_url)): ?>
                                            <img src="<?= image_url('categories/'.$category->homepage_image_url) ?>" class="home-products-img">
                                            <?php endif; ?>
                                            <a href="<?= base_url('oyunlar/'.$category->category_url); ?>" class="home-products-btn btn btn-sm btn-primary">Tümü</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="home-products-swiper">
                                            <div class="swiper swiper-container rounded">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                    foreach($categoryProducts as $_product):
                                                        ?>
                                                        <div class="swiper-slide rounded overflow-hidden" onclick="window.location.href='<?=base_url('oyunlar/'.$category->category_url);?>'" style="cursor:pointer;">
                                                            <div class="home-product-item">
                                                                <div class="home-product-image">
                                                                    <img src="<?= image_url('categories/'.productImage($_product, $category)) ?>" alt="">
                                                                </div>
                                                                <div class="home-product-detail">
                                                                    <span class="home-product-name"><?= $_product->product_name; ?></span>
                                                                    <div class="home-product-price">
                                                                        <span class="sales-price fw-bolder fs-4"><?=number_format(getProductPrice($_product), 2)?> AZN</span>
                                                                        <?php if(!empty($_product->discount) && $_product->discount>0 && ((!empty($_product->discount_end_date) && (time()-strtotime($_product->discount_end_date)) <= 0) || empty($_product->discount_end_date))): ?>
                                                                            <div class="text-muted">
                                                                                <del class="small"><?=number_format($_product->price, 2)?> <small class="text-muted">TL</small></del>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row my-5 pt-5 g-3">
                                <div class="col-12">
                                    <div class="home-products-card">
                                        <div class="home-products-desc">
                                            <h2>Güncel Haberler</h2>
                                            <p>Oyun dünyasına ait yeni ve önemli gelişmelerden haberdar olun!</p>
                                        </div>
                                        <a href="<?= base_url('haberler'); ?>" class="home-products-btn btn btn-sm btn-primary">Tümü</a>
                                    </div>
                                </div>
                                
                                <?php
                                    foreach($latestNews as $_item):
                                ?>
                                <div class="col-md-4">
                                    <!--begin::Feature post-->
                                    <div class="card-xl-stretch me-md-6">
                                        <!--begin::Image-->
                                        <a class="d-block bgi-no-repeat bgi-size-cover bgi-position-center card-rounded position-relative min-h-250px mb-5" style="background-image:url('<?=image_url('news/' . $_item->image_url)?>')"></a>
                                        <!--end::Image-->
                                        <!--begin::Body-->
                                        <div class="m-0">
                                            <!--begin::Title-->
                                            <a href="<?=base_url('haber/' . $_item->slug)?>" class="fs-4 text-dark fw-bolder text-hover-primary text-dark lh-base"><?=$_item->title?></a>
                                            <!--end::Title-->
                                            <!--begin::Text-->
                                            <div class="fw-bold fs-5 text-gray-600 text-dark my-4"><?=strlen($_item->text)>160 ? mb_substr(strip_tags($_item->text), 0, 160) . '...' : strip_tags($_item->text)?></div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Feature post-->
                                </div>
                                <?php
                                    endforeach;
                                ?>
                                
                            </div>
                            <div class="row mt-5 pt-5 g-3">
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="card rounded shadow-sm">
                                        <div class="card-body p-3 d-flex justify-content-center align-items-center gap-3 flex-column">
                                            <span class="svg-icon svg-icon-success svg-icon-3hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black"/>
                                                    <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <span class="text-dark fw-bold fs-3 text-center">Güvenli Alışveriş</span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="card rounded shadow-sm">
                                        <div class="card-body p-3 d-flex justify-content-center align-items-center gap-3 flex-column">
                                            <span class="svg-icon svg-icon-primary svg-icon-3hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M3 6C2.4 6 2 5.6 2 5V3C2 2.4 2.4 2 3 2H5C5.6 2 6 2.4 6 3C6 3.6 5.6 4 5 4H4V5C4 5.6 3.6 6 3 6ZM22 5V3C22 2.4 21.6 2 21 2H19C18.4 2 18 2.4 18 3C18 3.6 18.4 4 19 4H20V5C20 5.6 20.4 6 21 6C21.6 6 22 5.6 22 5ZM6 21C6 20.4 5.6 20 5 20H4V19C4 18.4 3.6 18 3 18C2.4 18 2 18.4 2 19V21C2 21.6 2.4 22 3 22H5C5.6 22 6 21.6 6 21ZM22 21V19C22 18.4 21.6 18 21 18C20.4 18 20 18.4 20 19V20H19C18.4 20 18 20.4 18 21C18 21.6 18.4 22 19 22H21C21.6 22 22 21.6 22 21ZM16 11V9C16 6.8 14.2 5 12 5C9.8 5 8 6.8 8 9V11C7.2 11 6.5 11.7 6.5 12.5C6.5 13.3 7.2 14 8 14V15C8 17.2 9.8 19 12 19C14.2 19 16 17.2 16 15V14C16.8 14 17.5 13.3 17.5 12.5C17.5 11.7 16.8 11 16 11ZM13.4 15C13.7 15 14 15.3 13.9 15.6C13.6 16.4 12.9 17 12 17C11.1 17 10.4 16.5 10.1 15.7C10 15.4 10.2 15 10.6 15H13.4Z" fill="black"/>
                                                    <path d="M9.2 12.9C9.1 12.8 9.10001 12.7 9.10001 12.6C9.00001 12.2 9.3 11.7 9.7 11.6C10.1 11.5 10.6 11.8 10.7 12.2C10.7 12.3 10.7 12.4 10.7 12.5L9.2 12.9ZM14.8 12.9C14.9 12.8 14.9 12.7 14.9 12.6C15 12.2 14.7 11.7 14.3 11.6C13.9 11.5 13.4 11.8 13.3 12.2C13.3 12.3 13.3 12.4 13.3 12.5L14.8 12.9ZM16 7.29998C16.3 6.99998 16.5 6.69998 16.7 6.29998C16.3 6.29998 15.8 6.30001 15.4 6.20001C15 6.10001 14.7 5.90001 14.4 5.70001C13.8 5.20001 13 5.00002 12.2 4.90002C9.9 4.80002 8.10001 6.79997 8.10001 9.09997V11.4C8.90001 10.7 9.40001 9.8 9.60001 9C11 9.1 13.4 8.69998 14.5 8.29998C14.7 9.39998 15.3 10.5 16.1 11.4V9C16.1 8.5 16 8 15.8 7.5C15.8 7.5 15.9 7.39998 16 7.29998Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <span class="text-dark fw-bold fs-3 text-center">Müşteri Memnuniyeti</span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="card rounded shadow-sm">
                                        <div class="card-body p-3 d-flex justify-content-center align-items-center gap-3 flex-column">
                                            <span class="svg-icon svg-icon-danger svg-icon-3hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="black"/>
                                                    <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <span class="text-dark fw-bold fs-3 text-center">Hızlı Teslimat</span>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-3">
                                    <div class="card rounded shadow-sm">
                                        <div class="card-body p-3 d-flex justify-content-center align-items-center gap-3 flex-column">
                                            <span class="svg-icon svg-icon-info svg-icon-3hx">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                    <path opacity="0.3" d="M16 0.200012H4C1.8 0.200012 0 2.00001 0 4.20001V16.2C0 18.4 1.8 20.2 4 20.2H16C18.2 20.2 20 18.4 20 16.2V4.20001C20 2.00001 18.2 0.200012 16 0.200012ZM15 10.2C15 10.9 14.8 11.6 14.6 12.2H18V16.2C18 17.3 17.1 18.2 16 18.2H12V14.8C11.4 15.1 10.7 15.2 10 15.2C9.3 15.2 8.6 15 8 14.8V18.2H4C2.9 18.2 2 17.3 2 16.2V12.2H5.4C5.1 11.6 5 10.9 5 10.2C5 9.50001 5.2 8.80001 5.4 8.20001H2V4.20001C2 3.10001 2.9 2.20001 4 2.20001H8V5.60001C8.6 5.30001 9.3 5.20001 10 5.20001C10.7 5.20001 11.4 5.40001 12 5.60001V2.20001H16C17.1 2.20001 18 3.10001 18 4.20001V8.20001H14.6C14.8 8.80001 15 9.50001 15 10.2Z" fill="black"/>
                                                    <path d="M12 1.40002C15.4 2.20002 18 4.80003 18.8 8.20003H14.6C14.1 7.00003 13.2 6.10003 12 5.60003V1.40002ZM5.40001 8.20003C5.90001 7.00003 6.80001 6.10003 8.00001 5.60003V1.40002C4.60001 2.20002 2.00001 4.80003 1.20001 8.20003H5.40001ZM14.6 12.2C14.1 13.4 13.2 14.3 12 14.8V19C15.4 18.2 18 15.6 18.8 12.2H14.6ZM8.00001 14.8C6.80001 14.3 5.90001 13.4 5.40001 12.2H1.20001C2.00001 15.6 4.60001 18.2 8.00001 19V14.8Z" fill="black"/>
                                                </svg>
                                            </span>
                                            <span class="text-dark fw-bold fs-3 text-center">7/24 Destek</span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
            $this->load->view("template_parts/footer");
        ?>

        
        <script src="<?=assets_url("dist/js/script.js")?>?ver=13"></script>
        <script>var hostUrl = "<?=assets_url("dist/")?>";</script>
        <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="<?=assets_url("dist/plugins/global/plugins.bundle.js")?>"></script>
        <script src="<?=assets_url("dist/js/scripts.bundle.js")?>"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Vendors Javascript(used by this page)-->
        <script src="<?=assets_url("dist/plugins/custom/fullcalendar/fullcalendar.bundle.js")?>"></script>
        <!--end::Page Vendors Javascript-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="<?=assets_url("dist/js/custom/widgets.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/apps/chat/chat.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/modals/create-app.js")?>"></script>
        <script src="<?=assets_url("dist/js/custom/modals/upgrade-plan.js")?>"></script>
        <script async>var SITE_URL = '<?=base_url()?>';</script>
    </body>
</html>