<?php 
$img_about = GetImg(_upload_hinhanh_l.$about["thumb"]);
 ?>
 <div class="gioithieu">
   <div class="container">
     <div class="gioithieu-wrap">
       <a href="gioi-thieu.html" class="imgsp">
         <figure><img src="<?= $img_about ?>" alt="<?= $about["ten"] ?>"></figure>
       </a>
       <div class="info">
         <p class="ten2 text-uppercase"><?= $about["ten2"] ?></p>
         <h2 class="ten text-uppercase"><?= $about["ten"] ?></h2>
         <div class="desc"><?= nl2br($about["mota"]) ?></div>
         <a href="gioi-thieu.html" class="xemthem text-uppercase"><?= _xemthem ?></a>
       </div>
     </div>
   </div>
 </div>
<div class="dmsanpham lazy" data-bg="url(images/productdm.jpg)">
  <div class="container">
    <div class="dmsanpham-main">
      <?php foreach ($product_danhmucnb as $key => $value) {
        $img = _upload_sanpham_l.$value["thumb"];
        $link = "thuc-don/".$value["tenkhongdau"]."-".$value["id"];
       ?>
      <div class="dmsanpham-item"><a href="<?= $link ?>">
          <figure class="zoom_hinh"><img src="images/1x1.png" data-lazy="<?= $img ?>" alt="<?= $value["ten"] ?>"></figure>
          <h2><?= $value["ten"] ?></h2>
        </a></div>
     <?php } ?>
    </div>
  </div>
</div>