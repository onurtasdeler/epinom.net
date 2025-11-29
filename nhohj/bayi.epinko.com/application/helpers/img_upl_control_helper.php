<?php
function upload_post_file_control($post, $file, $path, $folder, $type = "", $file_name, $table, $table_options,$table_options_where, $data, $where, $converttype = "")
{
    try {
        $t =& get_instance();
        if ($post) {
            $t->load->model("m_tr_model");
            $ayarlar = getTableSingle($table,$where);
            $ayarlar_img = getTableSingle($table_options,$table_options_where);
            $dosya = $file['name']; // dosya ismini aldık
            $uzanti = end(explode(".", $dosya)); // noktadan sonralarını alır
            if ($type == "update") {
                if ($file["tmp_name"] == "") {
                    $update = $t->m_tr_model->updateTable($table, $data, $where);
                } else {
                    $filename_new = permalink($ayarlar->site_name . "-" . $file_name . "-" . uniqid(rand(1, 100)));
                    $image_f = upload_picture($file["tmp_name"], $folder, $folder, $ayarlar_img->width, $ayarlar_img->height, $filename_new, $uzanti);
                    if ($ayarlar->url != "") {
                        if (file_exists($path . $ayarlar_img->width . "x" . $ayarlar_img->heigh . "/" . $ayarlar_img->url)) {
                            unlink($path . $ayarlar_img->width . "x" . $ayarlar_img->height . "/" . $ayarlar_img->url);
                        }
                    }
                    $data = explode(",", $data);
                    $guncelle = $t->m_tr_model->updateTable($table, array(
                        $data[0] => $filename_new . "." . $uzanti,
                        $data[1] => $data[3]
                    ), $where);
                }
            } else if ($type = "save") {
                if ($file["tmp_name"] == "") {
                    $update = $t->m_tr_model->updateTable($table, $data, $where);
                } else {
                    $filename_new = permalink($ayarlar->site_name . "-" . $file_name . "-" . uniqid(rand(1, 100)));
                    $image_f = upload_picture($file["tmp_name"], $folder, $folder, $ayarlar_img->width, $ayarlar_img->height, $filename_new, $uzanti);
                    if ($ayarlar->url != "") {
                        if (file_exists($path . $ayarlar_img->width . "x" . $ayarlar_img->heigh . "/" . $ayarlar_img->url)) {
                            unlink($path . $ayarlar_img->width . "x" . $ayarlar_img->height . "/" . $ayarlar_img->url);
                        }
                    }
                    $data = explode(",", $data);
                    $guncelle = $t->m_tr_model->updateTable($table, array(
                        $data[0] => $filename_new . "." . $uzanti,
                        $data[1] => $data[3]
                    ), $where);
                }
            }
        }
    } catch (Exception $ex) {
        return "error:1";
    }
}

