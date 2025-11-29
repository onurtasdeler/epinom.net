<?php

class SEO extends CI_Controller
{

    function __construct(){
        parent::__construct();
    }

    function Index(){
        $this->Sitemap();
    }

    function Sitemap(){
        header('Content-type: text/xml');
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            ';

        $data = [
            [
                'url' => base_url(),
                'name' => 'Home Page',
                'priority' => 1
            ],
            [
                'url' => base_url('tum-oyunlar'),
                'name' => 'Tüm Oyunlar',
                'priority' => 1
            ],
            [
                'url' => base_url('odeme-yontemleri'),
                'name' => 'Ödeme Yöntemleri',
                'priority' => 0.7
            ],
            [
                'url' => base_url('bakiye-yukle'),
                'name' => 'Bakiye Yükle',
                'priority' => 0.7
            ],
            [
                'url' => base_url('destek'),
                'name' => 'Destek',
                'priority' => 0.5
            ],
            [
                'url' => base_url('haberler'),
                'name' => 'Haberler',
                'priority' => 1
            ],
            [
                'url' => base_url('bize-ulasin'),
                'name' => 'Bize Ulaşın',
                'priority' => 0.7
            ]
        ];

        foreach($this->db->get('pages')->result() as $page):
            $data[] = [
                'url' => base_url('sayfa/' . $page->slug),
                'name' => $page->page_name,
                'priority' => 1
            ];
        endforeach;

        foreach($this->db->where([
            'is_active' => 1
        ])->get('news')->result() as $newsItem):
            $data[] = [
                'url' => base_url('haber/' . $newsItem->slug),
                'name' => $newsItem->title,
                'priority' => 1
            ];
        endforeach;

        foreach($this->db->where([
            'is_active' => 1
        ])->get('categories')->result() as $category):
            $data[] = [
                'url' => base_url('oyunlar/' . $category->category_url),
                'name' => $category->category_name,
                'priority' => 1
            ];
        endforeach;

        foreach($data as $item) {
            $xml .= '<url>
                <loc>' . $item['url'] . '</loc>
                <priority>' . $item['priority'] . '</priority>
            </url>';
        }
        $xml .= '</urlset>';
        echo $xml;
    }

}
