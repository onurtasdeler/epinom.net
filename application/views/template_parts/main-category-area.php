<?php

if (isset($css)) {
    $styleBindings = NULL;
    foreach($css as $_css_key => $_css_val):
        $styleBindings .= $_css_key . ':' . $_css_val . ';';
    endforeach;
}

if(count($mainCategories)>0) {
?>
    <div id="search-bar" class="p-1">
        <input id="mainCategorySearch" type="search" class="form-control" placeholder="Oyun Arayın...">
    </div>
    <ul id="mainCategoryAreaList"<?=isset($css) ? ' style="' . $styleBindings . '"' : NULL?>>
        <?php
        foreach($mainCategories as $_mac):
            $_mac->sub_categories = $this->db->where([
                'up_category_id' => $_mac->id
            ])->get('categories')->result();
            if(count($_mac->sub_categories)>0) {
                ?>
                <li class="has-child border-bottom">
                    <a class="h" href="<?=base_url('oyunlar/' . $_mac->category_url)?>"><?=$_mac->category_name?> <span data-feather="chevron-down" width="14" height="14"></span></a>
                    <ul class="sub-categories border-top border-primary">
                        <?php
                        foreach($_mac->sub_categories as $_mac_s):
                            ?>
                            <li>
                                <a href="<?=base_url('oyunlar/' . $_mac_s->category_url)?>"><?=$_mac_s->category_name?></a>
                            </li>
                        <?php
                        endforeach;
                        ?>
                    </ul>
                </li>
                <?php
            } else {
                ?>
                <li class="border-bottom">
                    <a href="<?=base_url('oyunlar/' . $_mac->category_url)?>"><?=$_mac->category_name?></a>
                </li>
                <?php
            }
        endforeach;
        ?>
    </ul>
<?php
}
?>