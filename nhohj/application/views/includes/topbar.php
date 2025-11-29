
<div class="topbar">
    <div class="container">
        <ul class="top-buttons">

            <li><?php
                $lan=getLangValue(2,"table_pages");

                ?>
                <a href="<?= base_url(gg().$lan->link) ?>">
                        <span>
                  <i class="mdi mdi-phone-message"></i>
            </span><?= $lan->titleh1; ?>
                </a>
            </li>
            <li>
                <?php
                $lan=getLangValue(13,"table_pages");

                ?>
                <a href="<?= base_url(gg().$lan->link) ?>">
                        <span>
              <i class="mdi mdi-information"></i>
            </span>  <?= $lan->titleh1; ?>
                </a>
            </li>

                
                    <?php
                    $records = $this->m_tr_model->query("SELECT * FROM table_social where status=1 ORDER BY order_id ASC");
                    foreach ($records as $record) {
                        $ll=getLangValue($record->id,"table_social");
                        if($record->id==6){
                            ?>
                            <li><a target="_blank" style="font-size: 20pt !important;" href="<?= $ll->link ?>">
                                    <svg height="20" viewBox="31.32 12 501.68 552.91" width="20" xmlns="http://www.w3.org/2000/svg"><g fill="#51b4c3"><path d="m71.52 405.54c6.31 40.19 20.44 69.89 38.17 91.85-27.88-22.66-51.99-58.37-60.83-114.57 0 0-17.54-178.44 191.59-176.97l.37 23.27c-185.59 10.95-169.3 176.42-169.3 176.42z"/><path d="m388.07 34.72h-72.16l-4.27 375.69c-13.34 58.5-72.43 55.57-72.43 55.57-34.31.46-52.31-14.97-61.74-31.46 9.81 5.5 22.56 8.96 39.08 8.74 0 0 59.09 2.92 72.45-55.57l4.25-375.69h91s.64 9.2 3.82 22.72zm122.27 107.27v20.84c-33.52-5.59-56.26-23.03-71.65-43.3 17.63 13.24 40.92 22.28 71.65 22.46z"/></g><g fill="#d44e61"><path d="m264.56 322.66s-95.55-11.7-97.5 73.12c0 0-.27 20.07 10.42 38.75-33.65-18.82-33.06-61.47-33.06-61.47 1.95-84.82 97.49-73.12 97.49-73.12l-1.09-70.82c7.13-.4 14.54-.59 22.27-.54zm174.13-203.14c-31.59-23.74-45.03-60.98-50.62-84.8h18.82c.01 0 3.33 47.27 31.8 84.8z"/><path d="m533 164.71v89.7s-63.69 1.29-126.1-42.25l-1.29 187.85s-2.11 145.92-152.74 159.08c0 0-88.62 5.82-143.17-61.71 53.37 43.4 120.51 38.99 120.51 38.99 150.63-13.17 152.74-159.08 152.74-159.08l1.31-187.85c62.4 43.54 126.09 42.25 126.09 42.25v-68.87c7.05 1.19 14.6 1.84 22.65 1.89z"/></g></svg>
                                </a></li>
                            <?php
                        }else{
                            ?>
                            <li><a target="_blank" style="font-size: 20pt !important;" href="<?= $ll->link ?>"><i  class="<?= $record->image ?>"></i></a></li>
                            <?php
                        }
                    }
                    ?>

        </ul>
        <div class="top-announce">

                <?php

                if ($this->session->userdata("lang")) {
                    $getLang = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                    if ($getLang) {
                        $langValue = json_decode($getLang->field_data);
                        foreach ($langValue as $item) {
                            if ($getLang->id == $item->lang_id) {

                                ?>
                                <span style="margin-top:16px;"><i style="font-size:14pt;" class="<?= $getLang->icon ?>"></i></span>
                                <?php
                                break;
                            }
                        }
                    }
                }
                ?>


                    <?php
                    $getLang = getTableSingle("table_langs", array("id" => $this->session->userdata("lang")));
                    if ($getLang) {
                        $langValue = json_decode($getLang->field_data);
                        foreach ($langValue as $item) {
                            if ($this->session->userdata("lang") != $item->lang_id) {
                                $cc=getTableSingle("table_langs",array("id" => $item->lang_id));

                                ?>

                              <a style="margin-left:10px;margin-top:16px;" class="langVal" data-id="<?= $item->lang_id ?>" data-idd="<?= $_SERVER['REQUEST_URI'];
                                    ?>" href="javascript:;"> <i style="font-size:14pt;" class="<?= $cc->icon ?>"></i></a>
                                <?php
                            }
                        }
                    }
                    ?>



            <div class="topbar-left" style="margin-top: 16px;">
                <?php  $con=getLangValue(1,"table_contact") ?>

                <a href="tel:<?= $con->tel1 ?>"><span><i class="mdi mdi-phone-incoming-outline"></i></span><?= $con->tel1 ?></a>
            </div>
        </div>
    </div>
    <div class="mode">
        <span></span>
    </div>
</div>
