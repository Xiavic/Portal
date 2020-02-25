<?php

	require_once 'Util/ServerStatus.class.php';

	$status = new ServerStatus();

?>
<aside id="columnRight" class="one-third column">
	<div class="module">
		<h2 class="moduleHeader">Servers</h2>
		<div class="moduleContent sideServerList">
<?php foreach ($status->getServers() as $key => $value): ?>
<?php $st = $status->getStatus($key); ?>
			<div class="sideServerListItem">
				<div class="status <?php echo $st["online"] ? "statusOnline" : "statusOffline" ?>"><b><?=$key?></b>
					<span class="sideServerListRight">Players <?=!empty($st["players"]) ? ($st["info"]["Players"] ."/". $st["info"]["MaxPlayers"]) : "N/A" ?></span>
				</div>
				<div>
					<?=$status->getIpWithPort($key, true)?> &nbsp;&nbsp;
					Version: <?php echo $st['online'] ? $st['info']['Version'] : ''; ?>
				</div>
				<?php if ($st['online']) { ?>
				<h5>Online Players:</h5>
				<div>					
					<?php foreach ($st['players'] as $name => $uuid) { ?>
						<img class="mcSkin" src="https://crafatar.com/avatars/<?=$uuid?>?size=32&default=MHF_Steve" alt="<?=$name?>" title="<?=$name?>">
					<?php } ?>
				</div>
				<?php } ?>
			</div>
<?php endforeach; ?>
		</div>
	</div>

	<div class="module">
            <h2 class="moduleHeader">Sleipnir Specs</h2>
            <div class="moduleContent">
                <img src="images/sleipnir.png" style="display: block; height: 150px; margin: 0 auto 15px auto;">
                <ul>
					<li>Codename: Sleipnir</li>
                    <li>Cpu: Ryzen 3600 3.6Ghz 6 cores</li>
                    <li>Ram: DDR4 32GB 3200Mhz</li>
                    <li>
                        Storage: 512GB Samsung 970 Evo<br>
                        2x WD Red 4TB HDDs
                    </li>
                </ul>
            </div>
        </div>

	<div class="module">
		<iframe src="https://discordapp.com/widget?id=524830692350361601&theme=dark" height="400" allowtransparency="true" frameborder="0"></iframe>
	</div>

</aside>
