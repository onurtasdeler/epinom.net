<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tabs extends CI_Controller
{
    public function getTabContent()
    {
        $this->load->helper('functions');

        $content_html = "";
        $catId = $this->input->post("catId");
        $subCatId = $this->input->post("subCatId");
        $tum = getLangValue(105, "table_pages");
        $products = $this->m_tr_model->query("select * from table_products where category_id=" . $subCatId . " and status=1 and is_delete=0 and is_populer=1 order by order_id limit 6");
        $item = getTableSingle("table_products_category", array("id" => $subCatId));
        $lld = getLangValue($subCatId, "table_products_category");
        $llm = getLangValue($item->parent_id, "table_products_category");

        foreach ($products as $items) {
            $ll = getLangValue($items->id, "table_products");

            if ($item->parent_id != 0) {
                $link = base_url(gg() . $tum->link . "/" . $llm->link . "/" . $lld->link);
            } else {
                $llm = getLangValue($item->id, "table_products_category");
                $link = base_url(gg() . $tum->link . "/" . $lld->link);
            }

            $content_html .= '<div class="col-6 col-lg-2 col-md-6 col-sm-6 ">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-16 mb-5 col-sm-16 col-12">
                                                        <div class="product-style-one no-overlay with-placeBid">
                                                            <div class="card-thumbnail">
                                                                <a href="' . base_url(gg() . $tum->link . "/" . $llm->link . "/" . $ll->link) . '">
                                                                    <img id="proSpe"
                                                                         src="' . base_url("upload/product/" . $items->image) . '"
                                                                         alt="' . $ll->name . '">

                                                                </a>
                                                                
                                                            </div>

                                                            <a href="' . base_url(gg() . $tum->link . "/" . $llm->link . "/" . $ll->link) . '"
                                                               class="mt-4">
                                                                <span class="mt-3 product-name" style="font-size: 15px;">
                                                                
            <div class="product-nem-title">';
            if ($_SESSION["lang"] == 1) {
                $content_html .= kisalt($ll->name, 35).
            '</div>  
                                                                    
                                                                    <small style="color: var(--color-body);">
                                                                        ' . strip_tags($item->desc_tr) . '
                                                                    </small>
                                                                </span>
                                                                ';
            } else {
                $content_html .= kisalt($item->ad_name_en, 35) . '
                                                                    
                                                                    <small style="color: var(--color-body);">
                                                                        ' . strip_tags($item->desc_en) . '
                                                                    </small>
                                                                    </span>
                                                                    ';
            }
            $content_html .= '
                                                            </a>';


            if ($item->is_populer == 1) {
                $content_html .= '
                                                                <div class="adsDoping"
                                                                     style="top:10px !important; right:10px">
                                                                    <a href="" class="avatar" data-tooltip-placement="left"
                                                                       data-tooltip="<?= (lac()==1)?"Popüler":"Populer" ?>">
                                                                        <img src="<?= base_url("upload/icon/" . $ayar->icon_vitrin) ?>"
                                                                             alt="">
                                                                    </a>
                                                                </div>
                                                                ';
            }

            $content_html .= '
                                                            <div class="bid-react-area">

                                                                <div class="last-bid ">
                                                                    ';


            if ($items->is_discount == 1) {
                $content_html .= '
                                                                        <div class="priceAreaInner"
                                                                             style="display: flex; flex-basis: 50%;flex-direction: row">
                                                                            <h5
                                                                                style="font-size: 16px"
                                                                                class="mt-1 priceMain">' . custom_number_format(getProductPrice($items->id)) . " " . getcur() . '</h5>
                                                                            <h6
                                                                                class="text-warning"
                                                                                style="font-size:12pt !important;    margin: 5px 3px 10px 6px;">
                                                                                <del>
                                                                                    <small>' . custom_number_format($items->price_sell) . " " . getcur() . '</small>
                                                                                </del>
                                                                            </h6>
                                                                        </div>

                                                                        ';
            } else {
                $content_html .= '
                                                                        <div style="display: flex; flex-basis: 50%">
                                                                            <h5
                                                                                style="font-size: 16px"
                                                                                class="mt-1 priceMain">' . custom_number_format($items->price_sell) . " " . getcur() . '</h5>
                                                                        </div>
                                                                        ';
            }
            $content_html .= '

                                                                </div>
                                                                

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
        }

        echo $content_html;
    }
}
