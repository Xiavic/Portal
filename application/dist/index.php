<?php
  require_once 'Util/Config.class.php';
  require_once 'Util/ServerStatus.class.php';
  $status = new ServerStatus();
	$voteSites = Config::getInstance()->getValue("voteSites");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Xiavic - Minecraft server</title>
  <meta name="description" content="The best minecraft server you never heard of!">
  <meta name="author" content="Pickle">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/icon" href="favicon.ico" />
</head>
<body>
  <div class="section landing">
    <header>
      <div class="banner">
        <img id="logo">
      </div>

      <nav class="top-nav">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="https://forums.xiav.icu">Forums</a></li>
          <li><a href="https://discord.gg/nY5yFhs">Discord</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="vote.html">Vote</a></li>
          <li><a href="store.html">Store</a></li>
        </ul>
      </nav>
    </header>

    <div class="introduction">
      <h1><img id="xiavic-badge"><span>iavic</span></h1>
      <h5>The only Minecraft server you need.</h5>
      <p>Start playing today @ <addr>mc.xiav.icu</addr></p>
    </div>

  </div>

  <div class="staggered-info">

    <div class="row">
        <div class="eight columns offset-by-four">
          <div class="sideServerList">
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
      </div>

      <div class="row">
        <div class="eight columns">
          <h3>Vote for Xiavic!</h3>
          <p>Looking to make grab some keys at a relatively fast rate?</p>
          <p style="color:#F9FF03;">Please wait approx. 10 seconds between your votes!<br />
          If you don't, you may not receive your in-game rewards.<br />
          <ul>
          <?php foreach ($voteSites as $key => $value) { ?>
            <li><a href="<?=$value?>">Vote on <?=$key?></a></li>
          <?php } ?>
          </ul>
        </div>
      </div>

      <div class="row">
        <div class="one-half columns offset-by-one-half">
          <img class="sleipnir">
          <ul>
            <li>Server hardware</li>
            <li>Cpu: Ryzen 3600 3.6Ghz 6 cores</li>
            <li>Ram: DDR4 32GB 3200Mhz</li>
            <li>
            Storage: 512GB Samsung 970 Evo<br>
            2x WD Red 4TB HDDs
            </li>
          </ul>
        </div>
      </div>  

  </div>

  <footer>
    <div class="row">
      <div class="one-half columns offset-by-one">
        <h5>Xiavic &copy; 2018 - <?php echo date('Y') ?></h5>
        <p>Designed by Pickle.</p>
      </div>
    </div>
  </footer>

  <script src="build/main.js"></script>
</body>
</html>
