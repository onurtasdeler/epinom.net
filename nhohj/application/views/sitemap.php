<?php header ("Content-Type:text/xml"); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">


<?php
$sayfalar=$this->m_tr_model->getTableOrder("table_pages",array("sitemaps" => 1,"status" => 1),"id","asc");

if($sayfalar){
    foreach ($sayfalar as $item) {
        $par=json_decode($item->field_data);
        foreach ($par as $items) {
            if($items->lang_id==1){
                
                if($item->id==11){
                    ?>
                    <url>
                        <loc><?= base_url() ?></loc>
                        <priority>1</priority>
                        <changefreq>daily</changefreq>
                        <mobile:mobile/>
                    </url>
                    <?php
                }else if($item->id==34){
                    ?>
                    <url>
                        <loc><?= base_url().$items->link ?></loc>
                        <priority>1</priority>
                        <changefreq>daily</changefreq>
                        <mobile:mobile/>
                    </url>
                    <?php
                    $ilamlar=$this->m_tr_model->getTableOrder("table_adverts",array("is_delete" => 0,"status" => 1,"deleted" => 0),"id","asc");
                    if($ilamlar){
                        foreach ($ilamlar as $ilan) {
                            $par=json_decode($ilan->field_data);
                            foreach ($par as $itemss) {
                                if($itemss->lang_id==1){
                                    ?>
                                    <url>
                                        <loc><?= base_url().$items->link."/".$itemss->link ?></loc>
                                        <priority>1</priority>
                                        <changefreq>daily</changefreq>
                                        <mobile:mobile/>
                                    </url>
                                    <?php
                                }

                            }
                        }
                    }

                    $ilamlar=$this->m_tr_model->getTableOrder("table_advert_category",array("is_delete" => 0,"status" => 1,"top_id" => 0,"parent_id" =>0 ),"id","asc");
                    if($ilamlar){
                        $tum=getTableSingle("table_pages",array("id" => 34));
                        $tumparse=json_decode($tum->field_data);
                        $links="";
                        foreach ($tumparse as $itemsss) {
                            if($itemsss->lang_id==1){
                                $links=$itemsss->link;
                            }
                        }
                        foreach ($ilamlar as $ilan) {
                            $par=json_decode($ilan->field_data);
                            $alts=$this->m_tr_model->getTableOrder("table_advert_category",array("is_delete" => 0,"status" => 1,"top_id" => $ilan->id,"parent_id" =>0 ),"id","asc");
                            foreach ($par as $itemss) {
                                if($itemss->lang_id==1){
                                    $analink=$itemss->link;
                                    ?>
                                    <url>
                                        <loc><?= base_url().$links."/".$itemss->link ?></loc>
                                        <priority>1</priority>
                                        <changefreq>daily</changefreq>
                                        <mobile:mobile/>
                                    </url>
                                    <?php
                                }
                            }
                            if($alts){
                                foreach ($alts as $alt) {
                                    $par2=json_decode($alt->field_data);
                                    $alts3=$this->m_tr_model->getTableOrder("table_advert_category",array("is_delete" => 0,"status" => 1,"top_id" => $ilan->id,"parent_id" =>$alt->id ),"id","asc");
                                    foreach ($par2 as $itemss2) {
                                        if($itemss2->lang_id==1){
                                            $analink2=$itemss2->link;
                                            ?>
                                            <url>
                                                <loc><?= base_url().$links."/".$analink."/".$itemss2->link ?></loc>
                                                <priority>1</priority>
                                                <changefreq>daily</changefreq>
                                                <mobile:mobile/>
                                            </url>
                                            <?php
                                        }
                                    }
                                    if($alts3){
                                        foreach ($alts3 as $alt3) {
                                            $par22=json_decode($alt3->field_data);
                                            foreach ($par22 as $itemss22) {
                                                if($itemss22->lang_id==1){
                                                    ?>
                                                    <url>
                                                        <loc><?= base_url().$links."/".$analink."/".$analink2."/".$itemss22->link ?></loc>
                                                        <priority>1</priority>
                                                        <changefreq>daily</changefreq>
                                                        <mobile:mobile/>
                                                    </url>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else{
                    ?>
                    <url>
                        <loc><?= base_url().$items->link ?></loc>
                        <priority>1</priority>
                        <changefreq>daily</changefreq>
                        <mobile:mobile/>
                    </url>
                    <?php
                }

            }
        }

    }
}



$sayfalar=$this->m_tr_model->getTableOrder("table_blog",array("status" => 1),"id","asc");
if($sayfalar){
    foreach ($sayfalar as $item) {
        $par=json_decode($item->field_data);
        foreach ($par as $items) {
            if($items->lang_id==1){
                ?>
                <url>
                    <loc><?= base_url()."haber/".$items->link ?></loc>
                    <priority>1</priority>
                    <changefreq>daily</changefreq>
                    <mobile:mobile/>
                </url>
                <?php
            }
        }

    }



$kategoriler=$this->m_tr_model->getTableOrder("table_products_category",array("status" => 1),"id","asc");
if($kategoriler){
    foreach ($kategoriler as $item) {
        $par=json_decode($item->field_data);
        foreach ($par as $items) {
            if($items->lang_id==1){
                ?>
                <url>
                    <loc><?= base_url().$items->link ?></loc>
                    <priority>1</priority>
                    <changefreq>daily</changefreq>
                    <mobile:mobile/>
                </url>
                <?php
                $urunler=$this->m_tr_model->getTableOrder("table_products",array("status" => 1,"is_delete" => 0,"category_id" => $item->id),"id","asc");
                if($urunler){
                    foreach ($urunler as $itemr) {
                        $par=json_decode($itemr->field_data);
                        foreach ($par as $itemsr) {
                            if($itemsr->lang_id==1){
                                ?>
                                <url>
                                    <loc><?= base_url().$items->link."/".$itemsr->link ?></loc>
                                    <priority>1</priority>
                                    <changefreq>daily</changefreq>
                                    <mobile:mobile/>
                                </url>
                                <?php
                            }
                        }

                    }
                }
            }
        }
    }
}
}

?>

</urlset>