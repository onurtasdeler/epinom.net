<?php
$user=getActiveUsers();
if($user){

}else{
redirect(base_url(gg()."404"));
}
?>

<div class="profile-content">
    <div class="message-content">
        <div class="section-title" style="margin-top: 0px; margin-bottom: 10px;">
            <img src="https://www.webpsoft.com/itemilani/assets/images/diamond.svg" alt="">
            <span><?php
                echo $uniq->talepNo." - ".langS(271,2)." ";
                ?>
            </span>
        </div>
        <?php
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $mobil = 0;
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            $mobil = 1;
        }
        if($mobil==1){
            ?>
            <div class="col-lg-12  table-orders" style="height:auto;  background-color: #1f2030 !important;  border-radius: 30px;">
                <table style="text-align: left; width: 100% !important;">

                    <tr>
                        <td><?= langS(262, 2) ?></td>
                        <td>#T-S-<?= $uniq->id ?></td>
                    </tr>
                    <tr>
                        <td><?= langS(263, 2) ?></td>

                            <?php
                            if($uniq->order_id!=""){
                                if($uniq->code_id!=""){

                                }else{
                                    $tur=langS(264,2);
                                    $or= $this->m_tr_model->getTableSingle("table_orders",array("id" => $uniq->order_id));
                                    $or=$or->sipNo;
                                }
                            }
                            ?>
                        <td><?= $tur ?></td>
                    </tr>
                    <tr>
                        <td><?= langS(210, 2) ?></td>
                        <td>#<?= $or ?></td>

                    </tr>
                    <tr>
                        <?php
                        $str="";
                        if ($uniq->status == 0) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(203, 2) . '</span></td>';
                        } else if ($uniq->status == 1) {
                            $str .= '<td><span class="badge badge-info"><i class="mdi mdi-comment"></i> ' . langS(267, 2) . '</span></td>';
                        } else if ($uniq->status == 2) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2) . '</span> </td>';
                        } else if ($uniq->status == 3) {
                            $str .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(269, 2) . '</span></td>';
                        }else if ($uniq->status == 4) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2) . '</span> </td>';
                        }
                        ?>
                        <td><?= langS(240, 2) ?></td>
                         <?= $str ?>
                    </tr>

                    <tr>
                        <td><?= langS(272, 2) ?></td>
                    <?php
                        $yp="";
                        if($uniq->update_at!=""){
                            $yp=date("Y-m-d H:i",strtotime($uniq->update_at));
                            ?>
                            <td><?= date("Y-m-d H:i",strtotime($uniq->update_at)); ?></td>
                            <?php
                        }else{
                            ?>
                            <td> - </td>
                            <?php
                        }
                        ?>

                    </tr>

                </table>
            </div>
            <?php
        }else{
            ?>
            <div class="col-lg-12  table-orders" style="height:auto;  background-color: #1f2030 !important;  border-radius: 30px;">
                <table style="text-align: left">
                    <thead>
                    <th><?= langS(262, 2) ?></th>
                    <th><?= langS(241, 2) ?></th>
                    <th><?= langS(263, 2) ?></th>
                    <th><?= langS(210, 2) ?></th>
                    <th><?= langS(240, 2) ?></th>
                    <th><?= langS(272, 2) ?></th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>#T-S-<?= $uniq->id ?></td>
                        <td><?= date("Y-m-d H:i", strtotime($uniq->created_at)) ?></td>
                        <?php
                        if($uniq->order_id!=""){
                            if($uniq->code_id!=""){

                            }else{
                                $tur=langS(264,2);
                                $or= $this->m_tr_model->getTableSingle("table_orders",array("id" => $uniq->order_id));
                                $or=$or->sipNo;
                            }
                        }
                        ?>
                        <td><?= $tur ?></td>
                        <td><?= $or ?></td>
                        <?php
                        $str="";
                        if ($uniq->status == 0) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(203, 2) . '</span></td>';
                        } else if ($uniq->status == 1) {
                            $str .= '<td><span class="badge badge-info"><i class="mdi mdi-comment"></i> ' . langS(267, 2) . '</span></td>';
                        } else if ($uniq->status == 2) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2) . '</span> </td>';
                        } else if ($uniq->status == 3) {
                            $str .= '<td><span class="badge badge-success"><i class="mdi mdi-check"></i> ' . langS(269, 2) . '</span></td>';
                        }else if ($uniq->status == 4) {
                            $str .= '<td><span class="badge badge-warning"><i class="mdi mdi-clock"></i> ' . langS(268, 2) . '</span> </td>';
                        }
                        echo $str;
                        $yp="";
                        if($uniq->update_at!=""){
                            $yp=date("Y-m-d H:i",strtotime($uniq->update_at));
                            ?>
                            <td><?= date("Y-m-d H:i",strtotime($uniq->update_at)); ?></td>
                            <?php
                        }else{
                            ?>
                            <td> - </td>
                            <?php
                        }
                        ?>

                    </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }

        ?>
        <div class="row clearfix " >
            <div class="col-lg-12" style="margin-top: 20px;">
                <div class="card chat-app">
                    <div class="chat" style="margin-left: 0px">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6 col-8">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="<?= base_url("upload/logo/".$settings->site_logo) ?>" alt="avatar">
                                    </a>
                                    <div class="chat-about">
                                        <small><?= langS(272) ?>: <?= $yp ?></small>
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <div class="chat-history">
                            <ul class="m-b-0" id="sohbetIcerik">
                                <li class="clearfix">
                                    <div class="message-data text-right">
                                        <?php
                                        $tarih1= new DateTime($uniq->created_at);
                                        $tarih2= new DateTime();
                                        $interval= $tarih2->diff($tarih1);
                                        $fark="";
                                        if($interval->format('%a')>0){
                                            $fark=" - ".$interval->format('%a '.langS(274,2)." ".langS(274,2));
                                        }else{
                                            $fark=" - ".langS(275,2);
                                        }
                                        ?>
                                        <span class="message-data-time"><?= date("H:i",strtotime($uniq->created_at)).$fark ?></span>
                                        <img src="<?= base_url("upload/users/".$user->image) ?>" alt="avatar">
                                    </div>
                                    <div class="message other-message float-right"><?= $uniq->message ?></div>
                                </li>
                                <?php
                                $cekSohbet=getTableOrder("table_talep_message",array("talep_id" => $uniq->id),"created_at","asc");
                                if($cekSohbet){
                                    foreach ($cekSohbet as $item) {
                                        if($item->tur==1){
                                            $tarih1= new DateTime($item->created_at);
                                            $tarih2= new DateTime();
                                            $interval= $tarih2->diff($tarih1);
                                            $fark="";
                                            if($interval->format('%a')>0){
                                                $fark=" - ".$interval->format('%a '.langS(274,2)." ".langS(274,2));
                                            }else{
                                                $fark=" - ".langS(275,2);
                                            }
                                            ?>
                                            <li class="clearfix">
                                                <div class="message-data">
                                                    <img src="<?= base_url("assets/images/favicon.png") ?>" alt="avatar">
                                                    <span class="message-data-time"><?= date("H:i",strtotime($item->created_at)).$fark ?></span>
                                                </div>
                                                <div class="message my-message"><?= $item->message ?></div>
                                            </li>
                                            <?php
                                        }else{
                                            ?>
                                            <li class="clearfix">
                                                <div class="message-data text-right">
                                                    <span class="message-data-time"><?= date("H:i",strtotime($item->created_at)).$fark ?></span>
                                                    <img src="<?= base_url("upload/users/".$user->image) ?>" alt="avatar">
                                                </div>
                                                <div class="message other-message float-right"><?= $item->message ?></div>
                                            </li>
                                            <?php
                                        }
                                    }
                                }else{

                                }
                                ?>
                            </ul>
                        </div>
                        <input type="hidden" id="talep" value="<?= $uniq->talepNo ?>" >
                        <?php
                        if($uniq->status==0 || $uniq->status==2){
                        ?>
                            <input type="hidden" id="vars" value="1">
                        <?php
                            }else{
                            ?>
                            <input type="hidden" id="vars" value="0">
                            <?php
                            }
                        ?>
                        <div class="chat-message clearfix">
                            <?php
                            if($uniq->status==3){

                            }else{
                                ?>

                                <div class="input-group mb-0" id="mesajVal">
                                    <input type="text" class="form-control" id="mesaj" placeholder="<?= langS(276) ?>">
                                    <button id="sendMesaj"><?= langS(277) ?></button>
                                </div>
                                <?php
                            }
                            ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>