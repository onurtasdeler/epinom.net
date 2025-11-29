
<section class="page-title page-title-inner" style="background:url(<?= base_url("upload") ?>/pages/x/<?= $page->one_cikmis_gorsel ?>.webp) no-repeat center center !important; background-size:cover !important;">	
		<div class="overlay-pagetitle"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="page-title-heading">
					<?php 
					if($this->uri->segment(2)){
						$baslikh1=$menu->menu_name;

					}else{
						$baslikh1=$page->baslikh1;

					}
					?>

					<h1 class="heading"><?=  $baslikh1 ?></h1>
				</div>
				<div class="breadcrumbs">
					<ul>
						<li><a href="<?= base_url("") ?>">Home</a></li>
						<?php 
							$baslik="";
							$baslik2="";
							$menuu=getTableSingle("bk_opt_menu",array("menu_ozel_link" => $page->link));
							if($menuu){ $baslik=$menuu->baslik; }
							if($this->uri->segment(2)){
								$baslik2=$menu->menu_name;
								?>
								<li><?= $baslik2 ?></li>
								<?php
							}else{
								?>
								<li><?= $baslik ?></li>
								<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</section>	