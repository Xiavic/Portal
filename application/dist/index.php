<?php
  require_once 'Util/Config.class.php';
  require_once 'Util/ServerStatus.class.php';
  $status = new ServerStatus();
	$voteSites = Config::getInstance()->getValue("voteSites");

  $manifest = json_decode(file_get_contents('./build/manifest.json'), true);
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
  <script src="build/<?php echo $manifest['main.js']; ?>"></script>
</head>
<body>
  <div class="section landing">
    <div class="landing-img l1"></div>
    <header>
      <div class="banner">
        <img id="logo">
      </div>

      <nav class="top-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="https://forums.xiav.icu">Forums</a></li>
          <li><a href="https://discord.gg/nY5yFhs">Discord</a></li>
          <li><a href="#vote">Vote</a></li>
          <li><a href="http://store.xiav.icu">Store</a></li>
        </ul>
      </nav>
    </header>

    <div class="slideshow-controls">
      <a class="control left"><img class="arrow-img"></a>
      <a class="control right"><img class="arrow-img"></a>
    </div>

    <div class="introduction">
      <h1><img id="xiavic-badge"><span>iavic</span></h1>
      <h5>The only Minecraft server you need.</h5>
      <p>
        Start playing today @ 
        <button class="button server-addr" data-clipboard-text="mc.xiav.icu">
          <div class="copy-alert">Copied!</div>
          mc.xiav.icu
        </button>
      </p>
    </div>

  </div>

  <div class="staggered-info">

    <div class="row">
        <div class="eight columns offset-by-four">
          <div class="side-server-list">
            <?php foreach ($status->getServers() as $key => $value): ?>
            <?php $st = $status->getStatus($key); ?>
                  <div class="side-server-item">
                    <div class="status <?php echo $st["online"] ? "online" : "offline" ?>">
                      <span class="server-name"><?=$key?></span>
                      <span>Players <?=!empty($st["players"]) ? ($st["info"]["Players"] ."/". $st["info"]["MaxPlayers"]) : "N/A" ?></span>
                    </div>
                    <div>
                      <button class="button server-addr" data-clipboard-text="<?=$status->getIpWithPort($key, true)?>">
                        <div class="copy-alert">Copied!</div>
                        <?=$status->getIpWithPort($key, true)?> &nbsp;&nbsp;
                      </button>

                      Version: <?php echo $st['online'] ? $st['info']['Version'] : ''; ?>
                    </div>
                    <?php if ($st['online']) { ?>
                    <h6>Online Players:</h6>
                    <div class="server-players">					
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
          <h3 id="vote">Vote for Xiavic!</h3>
          <p>Looking to snag Xiavic keys? Then start voting now to be rewarded!</p>
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
        <div class="eight columns offset-by-four">
          <img class="sleipnir">
          <div class="u-pull-right">
            <h6>Server Hardware Specifications</h6>
            <ul class="specs">
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

  </div>

  <footer>
    <div class="row">
      <div class="one-half columns offset-by-one">
        <h5>Xiavic &copy; 2018 - <?php echo date('Y') ?></h5>
        <p>
          <img class="secret-img">
          Designed by P<span class="secret-trigger">i</span>ckle.
        </p>
      </div>
    </div>
  </footer>

</body>
</html>
