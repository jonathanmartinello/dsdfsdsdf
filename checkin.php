<?php
include('app/includes/resources/security.php');
echo '<br>';
echo addNPCBox(19, $txt['pagetitle_box'], $txt['pagetext_box']);
echo '<div class="red">Em manutenção!</div>';
break;
if ($gebruiker['rank'] >= 5) {
	if(isset($_POST['submit'])){
		if($rekening['check'] > time()) echo '<div class="red">'.$txt['back_in'].'<span class="timer">'.formatTime($rekening['check'] - time()).'</span>!</div>';
		else{
			GiveItensDaily($gebruiker['user_id'], $rekening['checkin'] + 1, $txt);
			echo '<div class="green">'.$txt['succes_checkin'].'</div>';
			$amanha = time() + 86400;
			DB::exQuery("UPDATE `rekeningen` SET `check`='".$amanha."',`checkin`=`checkin`+'1' WHERE `acc_id`='" . $_SESSION['acc_id'] . "'");
			$rekening['checkin']++; 
		}
	}
	$check = DB::exQuery("SELECT * FROM `checkin` WHERE `mostra`='1'");?>
	<div class="box-content" style="width: 572px;">
		<table class="general" style="width: 100%">
			<thead>
				<tr>
					<th colspan="7"><center><?=$txt['table_checkin'];?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<center>
					<?php 
					$i = 1;
					while($CheckIn = $check->fetch_assoc()) { 
						$passestylecompleted = '';
						if($rekening['checkin'] >= $CheckIn['dia']) $passestylecompleted = 'filter: blur(3px) brightness(0.3);';?>
						<td><div id="passbattles" style="width: 50px">
							<div id="enterpass" style="<?=$passestylecompleted;?>">
								<span id="lvpass" style="bottom: 40px;font-size: 7px;line-height: 13px;border-radius: 0 0 5px 5px;width: 35px;height: 11px;"><?=$txt['day'];?> <?=$CheckIn['dia'];?></span> 
								<?php if($CheckIn['vip'] == 1){
									echo '<span id="lvpass" style="bottom: 0px;left: 52px;font-size: 7px;border-radius: 10px 10px 0 0;width: 33px;height: 10px;line-height: 12px;background-color: #045e15;" title="'.$txt['title_vip2x'].'">Vip 2x</span>';
								}
								if(!empty($CheckIn['item'])) { 
									list ($quanty, $item) = preg_split ('[/]', $CheckIn['item']);?>
									<span id="itempass" style="background: url('<?=$static_url;?>/images/items/<?=$item;?>.png') center center no-repeat, url('https://i.imgur.com/i5EDO3H.png') center center no-repeat;" title="<?=$quanty;?>x <?=$item;?>"></span>
								<?php }elseif(!empty($CheckIn['pokemon'])) { 
									$pkmon = DB::exQuery("SELECT `naam` FROM `pokemon_wild` WHERE `wild_id`='".$CheckIn['pokemon']."'")->fetch_assoc();
									if($CheckIn['shiny'] == 0) {
										$shiny = 'pokemon';
										$pkmshiny = '';
									}elseif($CheckIn['shiny'] == 1) {
										$shiny = 'shiny';
										$pkmshiny = 'Shiny';
									}?>
									<span id="itempass" style="background: url('<?=$static_url;?>/images/<?=$shiny;?>/icon/<?=$CheckIn['pokemon'];?>.gif') center center no-repeat, url('https://i.imgur.com/i5EDO3H.png') center center no-repeat;" title="1x <?=$pkmshiny;?> <?=$pkmon['naam'];?> "></span>
								<?php }elseif(!empty($CheckIn['silver'])) { ?>
									<span id="itempass" style="background: url('<?=$static_url;?>/images/icons/silver.png') center center no-repeat, url('https://i.imgur.com/i5EDO3H.png') center center no-repeat;" title="<?=$CheckIn['silver'];?>x Silvers"></span>
								<?php }elseif(!empty($CheckIn['gold'])) { ?>
									<span id="itempass" style="background: url('<?=$static_url;?>/images/icons/gold.png') center center no-repeat, url('https://i.imgur.com/i5EDO3H.png') center center no-repeat;" title="<?=$CheckIn['gold'];?>x Golds"></span>
								<?php }elseif(!empty($CheckIn['diasvip'])) { ?>
									<span id="itempass" style="background: url('<?=$static_url;?>/images/icons/vip.gif') center center no-repeat, url('https://i.imgur.com/i5EDO3H.png') center center no-repeat;" title="<?=$CheckIn['diasvip'];?>x <?=$txt['days_vip'];?>"></span>
								<?php } ?>
							</div>
						
							<?php if($rekening['checkin'] >= $CheckIn['dia']) { ?>
								<div class='verde' style='background: url(<?=$static_url;?>/images/seta.png) center center no-repeat;position: absolute;width: 50px;height: 50px;background-size: cover;top: 0px;left: 8px;'></div> 
							<?php } ?>	
						</div></td>
						
						<?php 
						$i++;
						if($i == 8){
							echo '</tr><tr>';
							$i = 1;
						}
					} ?>
					</td>
				</tr>
			</tbody>
			<form action="./index.php?page=checkin" method="post"><tfoot><tr><td align="right" colspan="7"><input class="tip_top-middle" type="submit" style="margin: 5px;" name="submit" value="<?=$txt['button_checkin'];?>" title="<?=$txt['button_title'];?>" class="button"/></td></tr></tfoot></form>
		</table>
	</div>
<?php } else { ?>
	<div class="red"><?=$txt['need_rank'];?></div>
<?php } ?>