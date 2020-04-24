<header class="hd-bg">
    <div class="container">
      <div class="hd-flex">
        <?php 
          $img = _upload_hinhanh_l.$logolang["photo"];
         ?>
        <a href="" class="logo" >
          <figure><img src="<?= $img ?>" alt="logo"></figure>
          <div class="logo-text">
            <h2><?= $logolang["ten"] ?></h2>
            <span><?= $logolang["mota"] ?></span>
          </div>  
        </a>
        <div id="search">
          <div class="my-search">
            <input type="text" class="form-control keyword" required="true" 
            onkeypress="doEnter(event)" value="<?=_nhaptukhoatimkiem?>..." 
            onclick="if(this.value=='<?=_nhaptukhoatimkiem?>...'){this.value=''}" 
            onblur="if(this.value==''){this.value='<?=_nhaptukhoatimkiem?>...'}"> 
            <span onclick="onSearch($(this));return false;" class="btn_search">
              <i class="fas fa-search"></i></span>
            </div>
          </div>
          <a href="gio-hang.html" class="giohang_fix">
            <figure><i class="fas fa-shopping-cart"></i></figure>
            <p><strong>Giỏ hàng</strong></p>
            <p>(<span><?= count($_SESSION["cart"]) ?></span>) <?= _sanpham ?></p>
          </a>
          <div id="lang">
              <a href="index.php?com=ngonngu&lang=en" title="English">
                <img src="images/en.png" alt="English" /> </a>
              <a href="index.php?com=ngonngu&lang=" title="Việt Nam">
                <img src="images/vi.png" alt="Việt Nam" /></a>
          </div>
      </div>
    </div>
</header>