<?php /* 
<i class="fas fa-home"></i> 
*/
?>
<li class="<?php if($source=='index') echo 'active'; ?>"><a href=""><?= _trangchu ?></a></li>
<li class="<?php if($com=='gioi-thieu') echo 'active'; ?>"><a href="gioi-thieu.html">
  <?= _gioithieu ?></a></li>
  <li class="<?php if($com == 'dich-vu') echo 'active'; ?>"><a href="dich-vu.html"><?= _dichvu ?></a></li>
  <li class="<?php if($com == 'catalogue') echo 'active'; ?>"><a href="catalogue.html">catalogue</a></li>
  <li class="<?php if($com == 'thu-vien') echo 'active'; ?>"><a href="thu-vien.html">
    Album ảnh</a></li>
<li class="<?php if($com == 'tin-tuc') echo 'active'; ?>"><a href="tin-tuc.html"><?= _tintuc ?></a></li>
<li class="<?php if($com == 'lien-he') echo 'active'; ?>"><a href="lien-he.html">
  <?= _lienhe ?></a></li>
<?php /* 
  <?= for2cap('product_danhmuc','product_list','thuc-don','thuc-don','','/')?>
<?= for1('news_danhmuc','nang-luc','nang-luc','')?>
  */?>