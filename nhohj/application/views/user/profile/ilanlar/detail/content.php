
<?php
if($uniq->type==1){
    //stoklu
    $this->load->view("user/profile/ilanlar/detail/stoklu/content");

}else{
    //stoksuz
    //stoklu
    $this->load->view("user/profile/ilanlar/detail/stoksuz/content");
}
?>


