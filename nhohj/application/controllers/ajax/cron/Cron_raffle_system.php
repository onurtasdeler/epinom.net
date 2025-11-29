<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron_raffle_system extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->helper("functions_helper");
        $this->load->helper("user_helper");
    }

    public function finish_raffles()
    {
        ini_set('display_errors',1);
        $finishedRaffles = getTableOrder("table_raffles",array("end_time<="=>date('Y-m-d H:i:s'),"is_finished"=>0),"id","desc");
        foreach($finishedRaffles as $raffle):
            $participants = getTableOrder("raffle_participants",array("raffle_id"=>$raffle->id),"id","asc");
            $raffleItems = getTableOrder("raffle_items",array("raffle_id"=>$raffle->id),"id","asc");
            $participantsCount = count($participants);
            // participant değerine göre sayım yapacağız
            $winner_count = [];

            foreach ($raffleItems as $entry) {
                $participant = $entry->participant;
                
                // Eğer bu participant daha önce eklenmemişse 0 olarak başlat
                if (!isset($participant_count[$participant])) {
                    $winner_count[$participant] = 0;
                }
                
                // participant değerini bir artır
                $winner_count[$participant]++;
            }
            $winnerCount = count($winner_count);
            $winnerIds = [];
            for($i=0;$i<$winnerCount;$i++) {
                if($i == $participantsCount)
                    break;
                $winnerIndex = 0;
                do {
                    $winnerIndex = rand(0,($participantsCount-1));
                } while(in_array($winnerIndex,$winnerIds));
                $winnerIds[$i] = $winnerIndex;
            }
            foreach($winnerIds as $key=>$item):
                $this->m_tr_model->updateTable("raffle_items",array("winner_id"=>$participants[$item]->user_id),array("raffle_id"=>$raffle->id,"participant"=>$key));
            endforeach;
            $this->m_tr_model->updateTable("table_raffles",array("is_finished"=>1),array("id"=>$raffle->id));
        endforeach;
    }



}

