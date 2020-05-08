<header class="hd">
  <div class="hd__top">
    <div class="container">
      <div class="hd__top-flex">
        <marquee ><?= $company['slogan'] ?></marquee>
        <div class="hd__top-info">
          <p><i class="fas fa-map-marker-alt"></i><?= $company['diachi'] ?></p>
          <p><i class="fas fa-envelope"></i><?= $company['email'] ?></p>
          <div class="mxh"><span>Follow us:</span><?= lay_mxh('mxh') ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="hd__bot">
    <div class="container">
      <div class="hd__bot-flex">
        <?php 
        $img = _upload_hinhanh_l.$logolang["photo"];
        ?>
        <a href="" class="logo" ><img src="<?= $img ?>" alt="logo"></a>
        <div class="hd__search">
          <div id="search">
            <div class="my-search">
              <input type="text" class="form-control keyword" required="true" 
              onkeypress="doEnter(event)" value="<?=_nhaptukhoatimkiem?>..." 
              onclick="if(this.value=='<?=_nhaptukhoatimkiem?>...'){this.value=''}" 
              onblur="if(this.value==''){this.value='<?=_nhaptukhoatimkiem?>...'}"> 
              <select name="id_danhmuc" id="id_danhmuc" class="form-control">
                <option value="">Tất cả</option>
                <?php foreach ($dmsp as $key => $value) {  ?>
                <option value="<?= $value["id"] ?>"><?= $value["ten"] ?></option>
                <?php } ?>

              </select>
              <span onclick="onSearch($(this));return false;" class="btn_search">
                <?= _timkiem ?></span>
              </div>
            </div> 
            <p><strong>Xu hướng tìm kiếm:</strong>
            <?php foreach ($xuhuong as $key => $value) {
              echo '<i>'.$value["ten"].'</i>';
            } ?>
            </p>
        </div>
        <div class="hd__hotline">
          <img src="images/hd-hotline.jpg" alt="hotline">
          <section>
            <p>Liên hệ đặt hàng online để có giá tốt nhất</p>
            <p>
              <a href="tel:<?=preg_replace('/[^0-9]/','',$company['dienthoai']);?>">
                <?= $company['dienthoai'] ?></a><strong>(HỖ TRỢ MUA HÀNG)</strong>
            </p>
          </section>
        </div>
      </div>
    </div>
  </div>
    
</header>