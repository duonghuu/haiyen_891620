<div class="gioithieu">
    <div class="container">
        <div class="gioithieu-flex">
            <a href="gioi-thieu.html" class="gioithieu__img">
              <h5><?= _gioithieu ?></h5>
              <img 
                src="<?= _upload_hinhanh_l.$about["thumb"] ?>" alt="<?= _gioithieu ?>"></a>
                <div class="gioithieu__info">
                    <h5><?= _gioithieu ?></h5>
                    <div class="gioithieu__desc"><?= nl2br($about["mota"]) ?></div>
                    <a href="gioi-thieu.html" class="gioithieu__link text-uppercase">Xem thêm</a>
                </div>
        </div>
    </div>
</div>
<?php foreach ($dmspnoibat as $kdm => $vdm) {
    $dmsp1=get_result("select ten$lang as ten,tenkhongdau,id,type from #_product_list
     where type='san-pham' and id_danhmuc='".$vdm["id"]."' and hienthi>0 order by stt asc");
 ?>
<div class="spnoibat">
    <div class="container">
      <div class="idx-tit">
        <h4><a href="san-pham/<?= $vdm["tenkhongdau"] ?>-<?= $vdm["id"] ?>"><?= $vdm["ten"] ?></a></h4>
      </div>
      <!-- Nav pills -->
      <ul class="nav nav-pills justify-content-center">
        <?php foreach ($dmsp1 as $kli => $vli) { ?>
        <li class="nav-item">
          <a class="nav-link <?= ($kli==0)?'active':'' ?>" data-toggle="pill" 
            href="#sp<?= md5($vli["tenkhongdau"].$vli["id"]) ?>"><?= $vli["ten"] ?></a>
        </li>
        <?php } ?>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <?php foreach ($dmsp1 as $kli => $vli) { 
            $spnoibat=get_result("select mota$lang as mota,ten$lang as ten,tenkhongdau,id,thumb,photo
                ,type,gia,giakm,masp from #_product where type='san-pham' and id_list='".$vli["id"]."'
                 and noibat>0 and hienthi>0 order by stt asc");
            ?>
        <div class="tab-pane <?= ($kli==0)?'active':'fade' ?>" 
            id="sp<?= md5($vli["tenkhongdau"].$vli["id"]) ?>">
                <div class="product-grid">
                    <?php foreach ($spnoibat as $key => $value) {
                        showProduct($value);
                    } ?>
                </div>
            </div>
        <?php } ?>
      </div>
  </div>
</div>
<?php } ?>