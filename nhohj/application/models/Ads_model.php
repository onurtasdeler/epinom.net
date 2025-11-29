<?php

class Ads_model extends CI_Model{

    public $advertTable="table_adverts";
    public $userTable="table_users";

    public function __constrsuct(){
        parent::__construct();
        $this->db=$this->load->database("data_tr",TRUE);
    }

    public function get_ads_list($where="",$order="",$page=0,$limit=1){
        if($where!=""){
            $s= "select *,ilan.id as ilanid,users.id as userid,ilan.views as vs from ".$this->advertTable." as ilan
                    left join ".$this->userTable." as users on ilan.user_id=users.id 
                    where (users.is_magaza=1 and users.status=1 and users.banned=0) and ilan.is_delete=0 and ((ilan.type=1 and (ilan.status=1 or ilan.status=4)) or (ilan.type=0 and (ilan.status=1)))    ".$where." ".$order." limit ".$page." , ".$limit." ";

            $veri=$this->db->query("select *,ilan.id as ilanid,users.id as userid,ilan.views as vs,ilan.ilanNo as ilanNos from ".$this->advertTable." as ilan 
                    left join ".$this->userTable." as users on ilan.user_id=users.id 
                    where (users.is_magaza=1 and users.status=1 and users.banned=0) and  ilan.is_delete=0 and  ((ilan.type=1 and (ilan.status=1 or ilan.status=4)) or (ilan.type=0 and (ilan.status=1)))    ".$where." ".$order." limit ".$page." , ".$limit." ")->result();
            if($veri){
                return array("veri" => $veri,"sorgu" => $s);
            }else{
                return array("veri" => "","sorgu" => $s);
            }
        }
    }

    public function get_ads_list_2($where="",$order="",$page=0,$limit=1,$filter=""){
        if($where!=""){
            $s= "select *,ilan.id as ilanid,users.id as userid,ilan.views as vs from ".$this->advertTable." as ilan 
                    left join ".$this->userTable." as users on ilan.user_id=users.id 
                    left outer join  as spe on ilan.id=spe.ads_id
                    where (users.is_magaza=1 and users.status=1 and users.banned=0) and  ilan.is_delete=0 and ((ilan.type=1 and (ilan.status=1 or ilan.status=4)) or (ilan.type=0 and (ilan.status=1)))  
                    
                     ".$where." ".$filter." ".$order." limit ".$page." , ".$limit." ";
            //echo $s;
            $veri=$this->db->query("select *,ilan.id as ilanid,users.id as userid,ilan.views as vs from ".$this->advertTable." as ilan 
                    left join ".$this->userTable." as users on ilan.user_id=users.id 
                     left  join table_adverts_spe_field as spe on ilan.id=spe.ads_id
                    where (users.is_magaza=1 and users.status=1 and users.banned=0) and  ilan.is_delete=0 and  ((ilan.type=1 and (ilan.status=1 or ilan.status=4)) or (ilan.type=0 and (ilan.status=1)))  
                    
                     ".$where." ".$filter." ".$order." limit ".$page." , ".$limit." ")->result();;
            if($veri){
                return array("veri" => $veri,"sorgu" => $s);
            }else{
                return false;
            }
        }
    }

}

?>
