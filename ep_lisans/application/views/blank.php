


<!DOCTYPE html>
<html lang="tr" class="js">

<head>
    <?php $this->load->view("includes/head") ?>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
        <?php $this->load->view("includes/sidebar") ?>
        <!-- sidebar @e -->
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php $this->load->view("includes/header") ?>
            <!-- main header @e -->
            <!-- content @s -->
            <?php $this->load->view($this->viewFolder."/content")  ?>
            <!-- content @e -->
            <!-- footer @s -->
            <?php $this->load->view("includes/footer") ?>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- select region modal -->
<!-- JavaScript -->
<?php $this->load->view("includes/script")  ?>
<?php $this->load->view($this->viewFolder."/page_script")  ?>
</body>

</html>