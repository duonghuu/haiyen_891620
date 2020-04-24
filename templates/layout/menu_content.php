<?php /* 
<i class="fas fa-home"></i> 
*/
?>
<li class="<?php if($source=='index') echo 'active'; ?>"><a href=""><?= _trangchu ?></a></li>
<li class="<?php if($com=='gioi-thieu') echo 'active'; ?>"><a href="gioi-thieu.html">
  <?= _gioithieu ?></a></li>
<li class="<?php if($com=='san-pham') echo 'active'; ?>"><a href="san-pham.html"><?= _sanpham ?></a>
  <?= for2cap('product_danhmuc','product_list','san-pham','san-pham','','/')?>
</li> 
<li class="<?php if($com == 'tin-tuc') echo 'active'; ?>"><a href="tin-tuc.html"><?= _tintuc ?></a></li>
<li class="<?php if($com == 'khuyen-mai') echo 'active'; ?>"><a href="khuyen-mai.html">
  <?= _khuyenmai ?></a></li>
<li class="<?php if($com == 'lien-he') echo 'active'; ?>"><a href="lien-he.html">
  <?= _lienhe ?></a></li>
<?php /* 
<?= for1('news_danhmuc','nang-luc','nang-luc','')?>
  */?>