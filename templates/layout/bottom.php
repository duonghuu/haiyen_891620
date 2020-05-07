<div class="tinnb">
  <div class="container">
    <div class="idx-tit">
      <h4><a href="tin-tuc.html">Tin tức - sự kiện</a></h4>
    </div>
    <div class="tinnb-main">
      <?php foreach ($tinnb as $key => $value) { 
$img = _upload_tintuc_l.$value["thumb"];
        ?>
        <div class="tinnb-main__item">
          <a href="<?= get_url($value,'tin-tuc') ?>">
            <figure><img src="<?= $img ?>" alt="<?= $value["ten"] ?>"></figure>
            <h5><?= $value["ten"] ?></h5>
            <div class="tinnb-main__item-desc"><?= catchuoi($value["mota"],120) ?></div>
            <div class="tinnb-main__item-link"><span>Xem thêm</span></div>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</div>