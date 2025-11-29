
<div style="padding-top: 30px" class="nu-subscribe-area rn-section-gapTop sal-animate" data-sal-delay="200"
    data-sal="slide-up" data-sal-duration="800">
    <div class="container">
        <div class="row">
            <p><?= substr($this->setting->anasayfa_yazi,0,160); ?> <?php if(strlen($this->setting->anasayfa_yazi) > 160): ?><b onclick="document.querySelector('#loadMore').style.display = 'block';this.style.display='none'" style="cursor:pointer;">Devamını Göster</b><?php endif; ?><span id="loadMore" style="display: none;"><?= substr($this->setting->anasayfa_yazi,160,9999999) ?></span></p>  
        </div>
    </div>
</div>
<div class="rn-footer-one rn-section-gap bg-color--1 mt--100 mt_md--80 mt_sm--80 ">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="widget-content-wrapper">
                    <div class="footer-left">
                        <div class="logo-thumbnail logo-custom-css">
                            <a class="logo-light" href="<?= base_url() ?>"><img
                                        src="<?= geti("logo/" . $this->general->site_logo) ?>"
                                        alt="<?= $this->general->site_name ?>"></a>
                            <a class="logo-dark" href="<?= base_url() ?>"><img
                                        src="<?= geti("logo/" . $this->general->site_logo) ?>"
                                        alt="<?= $this->general->site_name ?>"></a>
                        </div>
                    </div>
                    <!-- Google tag (gtag.js) -->

					<div id="ETBIS"><div id="2354168337137134"><a href="https://etbis.eticaret.gov.tr/sitedogrulama/2354168337137134" target="_blank"><img style='width:100px; height:120px' src="data:image/jpeg;base64, iVBORw0KGgoAAAANSUhEUgAAAIIAAACWCAYAAAASRFBwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAESSSURBVHhe7Z0HnF5F9f4lICEQEoqAdBCkg0JCkyaC0qWL9BYEpQgh0jtIEwWlg4DUoPSOEelpm63JppAE0nvvlcz/fO97n3fP3p23bLIJ+vv7fD4PYafd+957ZuacM2fmfssQWoJ//etfA5g+fXpYd911m+R369Ytyfe45ZZbmpTbf//909wQzjvvvCb5nu+//35S7ssvvwwrr7xyknb11VcnaWDnnXduUifGk046Ka0RwuGHHx4tU4wPPPBAUnf27Nnhu9/9bpJ24oknJmkew4cPD9/+9reT/N/97ndpanHMmTMnbLTRRkmdE044IU0N4ec//3n++svIV4wJYpnNZilBeOedd5J8j2UVhB49eiTlJk2alE+76qqrkjTwwx/+sFH5QuTlCy0lCKeeemqS5jFjxoy8INxwww1pamlssskmSZ0VIghbbbVVOP3005vFn/70p/kGY4Lwve99L1+2X79+ST4P45lnnkl400035fPXWmutpE5zBIFeRTuPPvpoOOOMM5J2eMBqf9NNN21SZ88998xfU9SLBBKEtm3bhtNOO61J2bXXXrtJmzFB2GOPPfL3If7pT3/Kj1xcJ5sfI89V14wJwhprrJEIXfY+i/GUU04Jq6++elLf2FgQfvWrX6WXKB+VlZVqLCoInTp1StI8Bg4cmK9z/fXXp6kh7LLLLklacwRB/M53vpPWCOGOO+6IlhGfffbZtGQcEgQ6Rgy77bZbkzZjgrA8GBOELbbYIk1pHlwnaSwIZ555ZlqkfHz44YdqLCoI55xzTpLmMXjw4LDSSisl+bfddlua2jCfH3jggWlKSOqr/WJcf/31w+LFi5M6t99+e7SM+PjjjyflCkEPeMsttwyLFi1KUxuwzTbbNGnzmxSEzTbbLCxYsCBNLQ/z5s0LG2+8sdotLAhXXnllOOSQQwpy5MiRSblSgoCSozpVVVVJvhcEep3yGYpJYxhU2h/+8IdEISzFTz/9NCxZsiRp3wvCI4880qQs0wltH3PMMWHatGlJnY8//jh/TUYX6npB+Pvf/57PZ0ShHYZ5XaeUINx8881N7qMUjz766CbtlBKEV155JX+fMb722mtJubIFgXlU6THW19cn5WKCwMN180+e7777bpLvBaEUn3rqqaROc+AF4auvvkpTG3DBBRfk8xFa8MILL+TTxA033DAvCNddd10+Hc0ffPHFF/m0xx57LEn7+uuv87qOZ/fu3ZP85qBLly5N2jnqqKPS3LgglJoW77rrrqRc2YJw0EEH5SvHyDwPYoIwc+bMsOuuuyY9ar311svny3z0gsBDoxxcddVVk7TVVlstn3b//fcnL7M5ZLpR/UGDBiXX5IcrH0WJ66Bk9enTJ0l78skn83VEdBVNNw8//HA+/V//+ldS5+WXX87/Nno8aQMGDAgdOnRIyjFdKZ9no+sX45gxY5LrgYsvvjipy7NiPqfN3/zmN2luXBD8KBXjfffdl5RbIYIA6EmQHq38mCBce+21+bI77LBDkrbffvvl01BgV1lllWYRP4Lqa7r4/PPP8/mtWrXK35PSfvnLX+breAr0dKWhLFJH2j+kTdLat28fRo8enZTr2rVrPp+yulYx/uhHP0qv2CAIjK4jRoxI2pRggv8KQRCeeOKJfD4vA0yYMCGfxvAn7LTTTknaAQcckKaExNGjsuXSO5SEvn37RsuKmFTlophvgtEMoQFvv/12tEwxduzYMakLzj777Hz6uHHj0tQG/FcJAgoiyhn8/e9/H+6+++5kHlMaSpGw4447Ju148/Gll17Kl40R00nXF70gMCJxTYbUbDnPH/zgB0m5cigvX4xMb5jElLv11luj9ywi8Nn66GbC66+/npS75pprEt9LFitEEDDhlB5juYLgwbBHOfSGGGKCUAooT7q+6D2LxV7a8iYvqhgeeuihJnVwQpWLmCD88Y9/bNKm57333puUK1sQeBlKjxGlCDRHEH7yk58k5Qo5QDQ1/PjHP05TSgOTSNcXr7jiijQ3hO22265J/opibK3BI/bSUDTLRUwQMLezbXpyTVC2IGAaoVEXIg2BmCDMmjUrmVqY7zxxl1KXNYdsHmzTpk3SzpprrplPe/XVV5M2sc8PPvjgJA1TTpAg8KN69+6dtI+yJvTv3z9J4950n0wd+h0x7rPPPkk5RpNevXolaRdddFG+vognNFv3s88+y/tQvCBceuml+d8kav0APv/880l9pkLlv/jii2ntOGKCMH78+Cb35Il+BooKQqeIO7gUeFCqL0HAj9C6det8uqgFoilT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"/></a></div></div>




                    <div class="widget-bottom mt--40 pt--40">
                        <h6 class="title"> <?= ($_SESSION["lang"] == 1) ? "İletişim Bilgileri" : "Contact Information" ?></h6>
                        <div class="row">
                            <?php
                            if ($this->iletisim->telefon != "") {
                                ?>
                                <div class="col-lg-12">

                                    <a href="tel:<?= $this->iletim->telefon ?>"><i
                                                class="fa fa-phone"></i> <?= $this->iletisim->telefon ?></a>
                                </div>

                                <?php
                            }
                            ?>

                            <?php
                            if ($this->iletisim->telefon != "") {
                                ?>
                                <div class="col-lg-12 mt-3">
                                    <a href="tel:<?= $this->iletim->email ?>"><i
                                                class="fa fa-envelope"></i> <?= $this->iletisim->email ?></a>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($this->iletisim->wp != "" && $this->iletisim->wp_status == 1) {
                                ?>
                                <div class="col-lg-12 mt-3">
                                    <a href="https://api.whatsapp.com/send/?phone=<?= str_replace( "+","",str_replace( " ","",$this->iletisim->wp)) ?>&text&type=phone_number&app_absent=0"><i
                                                class="fa fa-whatsapp"></i> <?= $this->iletisim->wp ?></a>
                                </div>
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_mobile--40">
                <div class="footer-widget widget-quicklink">
                    <h6 style="font-size:18px" class="widget-title"><?= langS(200) ?></h6>
                    <ul class="footer-list-one">
                        <?php

                        $kruumsl = getTableOrder("table_menus", array("tip" => 2, "status" => 1, "parent" => 1), "order_id", "asc");
                        if ($kruumsl) {
                            foreach ($kruumsl as $item) {
                                $ll = getLangValue($item->id, "table_menus");
                                ?>
                                <li class="single-list"><a href="<?= base_url($ll->link) ?>"><?= $ll->titleh1 ?></a></li>
                                <?php
                            }
                        }
                        ?>


                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--40 mt_sm--40">
                <div class="footer-widget widget-information">
                    <h6 style="font-size:18px" class="widget-title"><?= ($_SESSION["lang"]==1)?"Kategoriler":"Categories" ?></h6>
                    <ul class="footer-list-one">
                        <?php
                        $tum=getLangValue(34,"table_pages");
                        $blog=getLangValue(33,"table_pages");

                        $randCat=$this->m_tr_model->query("select * from table_advert_category where status=1 and top_id=0 and parent_id=0 order by rand() limit 7");
                        if($randCat){
                            foreach ($randCat as $item) {
                                $ll=getLangValue($item->id,"table_advert_category");
                                ?>
                                <li class="single-list"><a href="<?= base_url(gg().$tum->link."/".$ll->link) ?>"><?= ($_SESSION["lang"]==1)?$item->name_tr:$item->name_en ?></a></li>
                                <?php
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--40 mt_sm--40">
                <div class="footer-widget">
                    <h6 style="font-size:18px" class="widget-title"><?= ($_SESSION["lang"]==1)?"Son Haberler":"Last News" ?></h6>
                    <ul class="footer-recent-post">
                        <?php
                        $randCat=$this->m_tr_model->query("select * from table_blog where status=1  order by rand() limit 3");
                        if($randCat){
                            foreach ($randCat as $item) {
                                $ll=getLangValue($item->id,"table_blog");
                                ?>
                                <li class="recent-post">

									
                                    <div class="content">
                                        <h6 class="title"><a href="<?= base_url(gg().getst("haber")."/".$ll->link) ?>"><?= kisalt($ll->name,30) ?></a></h6>
                                        <p><?= date("d-m-Y",strtotime($item->date)) ?></p>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Footer Area -->
<!-- Start Footer Area -->

<div class="copy-right-one ptb--20 bg-color--1 ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="copyright-left">
                    <span style="font-size:14px; font-family: 'montserrat'">©<?= date("Y") ?> <?= $this->general->site_name ?> <?= ($_SESSION["lang"]==1)?"Tüm Hakları Saklıdır":"All Rights Reserved" ?></span>

                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="copyright-right">
                    <ul class="social-copyright">
                        <?php
                        if($this->iletisim->facebook!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->facebook ?>" target="_blank"><i data-feather="facebook"></i></a></li>
                            <?php
                        }
                        if($this->iletisim->twitter!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->twitter ?>" target="_blank"><i data-feather="twitter"></i></a></li>
                            <?php
                        }
                        if($this->iletisim->instagram!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->instagram ?>" target="_blank"><i data-feather="instagram"></i></a></li>
                            <?php
                        }
                        if($this->iletisim->discord!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->discord ?>" target="_blank"><img style="width: 30px" src="<?=  base_url("assets/discord.png")?>" alt=""></a></li>
                            <?php
                        }
                        if($this->iletisim->skype!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->skype ?>" target="_blank"><i style="font-size:17px !important;" class="fa fa-skype"></i></a></li>
                            <?php
                        }
                        if($this->iletisim->youtube!=""){
                            ?>
                            <li><a href="<?= $this->iletisim->youtube ?>" target="_blank"><i style="font-size:17px !important;" class="fa fa-youtube"></i></a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>
<div class="rn-progress-parent">
    <svg class="rn-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>






