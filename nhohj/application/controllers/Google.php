<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product;
use Vitalybaev\GoogleMerchant\Product\Shipping;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

class Google extends CI_Controller
{
    public function index()
    {
        $products = $this->db->order_by('order_id', 'asc')
            ->get_where('table_products', array('status' => 1, 'is_delete' => 0))
            ->result();

        $setting = $this->db->get_where('table_pages', array('name' => 'Anasayfa'))->row();
        $decodedText = json_decode($setting->field_data);

        $feed = new Feed($decodedText[0]->stitle, base_url(), $decodedText[0]->sdesc);

        foreach ($products as $product) {
            $pDecoded = json_decode($product->field_data);
            if (is_null($pDecoded)) {
                continue;
            }

            $categoryInfo = $this->db->get_where('table_products_category', array('id' => $product->category_main_id))->row();
            if (!$categoryInfo) {
                continue;
            }

            $item = new Product();
            $item->setId($product->id);
            $item->setTitle($pDecoded[0]->name);
            $item->setDescription(isset($pDecoded[0]->aciklama) && $pDecoded[0]->aciklama !== "" ? $pDecoded[0]->aciklama : (isset($pDecoded[0]->kisa_aciklama) ? $pDecoded[0]->kisa_aciklama : "Açıklama Yok"));
            $item->setLink(base_url('oyunlar/' . $categoryInfo->seflink_tr . '/' . $product->p_seflink_tr));
            $item->setImage(base_url('upload/product/' . $product->image));
            $item->setAvailability(Availability::IN_STOCK);
            $item->setPrice("{$product->price_sell} TRY");
            $item->setGoogleCategory($categoryInfo->c_name);
            $item->setBrand($categoryInfo->satici_name ?? 'EpinKo');

            $feed->addProduct($item);
        }

        $xmlOutput = $feed->build();
        $filePath = FCPATH . 'google_merchant.xml';
        
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if (file_put_contents($filePath, $xmlOutput) !== false) {
            echo "XML dosyası başarıyla oluşturuldu: $filePath";
        } else {
            echo "XML dosyası oluşturulurken bir hata oluştu.";
        }
    }
}
