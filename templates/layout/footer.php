<footer id="footer" >
  <div class="ft-top ">
    <div class="">
      <div class="ft-flex">
        <div class="ft-info">
          <p class="ft-tit"><span>Thông tin công ty</span></p>
          <?php /* 
          <a href="" class="ft-logo"><img src="<?= _upload_hinhanh_l.$ftlogo["photo"] ?>" alt="logo"></a> 
          */?>
          <?php /* <h4 class="ft-company"><a href=""><?= $company["ten"] ?></a></h4> */?>
          <div class="content"><?php echo lay_text('footer'); ?> </div>
          <div class="mxhft"><span>Follow us:</span><?= lay_mxh('mxhft') ?></div>
        </div>
        <div class="ft-right">
          <div class="ft-right__top">
            <img src="images/dknt.png" alt="<?= _dangkynhantin ?>">
            <div class="ft-dknt">
              <p class="mailtit"><?= _mailtit ?></p>
              <?php include _template."layout/dangkynhantin.php"; ?>
            </div>
          </div>
          <div class="ft-right__bot">
            <div class="ft-baiviet">
              <p class="ft-tit"><span>Về chúng tôi</span></p>
              <?= for1('news','ve-chung-toi','ve-chung-toi','.html') ?>
            </div>
            <div class="ft-baiviet">
              <p class="ft-tit"><span>Chính sách quy định</span></p>
              <?= for1('news','chinh-sach','chinh-sach','.html') ?>
            </div>
            <?php  if($deviceType != "phone"){ ?>
              <div class="ft-fanpage">
                <p class="ft-tit"><span>Fanpage</span></p>
                <div class="fanpageplace">
                  <div class="fb-page" data-href="<?=$company['fanpage']?>" data-width="470" data-height="380" 
                    data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" 
                    data-show-posts="false">
                    <div class="fb-xfbml-parse-ignore">
                      <blockquote cite="<?=$company['fanpage']?>">
                        <a href="<?=$company['fanpage']?>">Facebook</a>
                      </blockquote>
                    </div>
                  </div>      <!-- end fb-page  -->
                </div>
              </div>

            <?php } ?>
          </div>
        </div>
        
        
       
    </div>
  </div>
</div>
<div class="copyright">
  <div class="container">
    <div class="ft-wrap">
      <p class="text">Copyright: Bản quyền thuộc về Thảo Vy. Cung cấp bởi Trí Lực Co.</p>
      <ul class="ft-thongke">
        <li>Đang Online: <span><?php $count=count_online(); echo $tong_xem=$count['dangxem'];?></span></li>
        <li><?=_tongtruycap?>: <span><?php $count=count_online(); echo $tong_xem=$count['daxem'];?></span></li>
      </ul>
             <?php /*  
        <li><?=_thongketuan?>: <span><?=$trongtuan;?></span></li>   
        <li><?=_thongkethang?>: <span><?=$trongthang;?></span></li> 
        
        <li><?=_ngayhomqua?>: <span><?=$homqua;?></span></li> 
*/?>
    </div>
  </div>
</div>
</footer>
          <?php /* <div class="codebando"><?= $company["bando"] ?></div>
            include _template."layout/dangkynhantin.php";<img src="http://placehold.it/600x520" 
            alt="" style="   -webkit-clip-path: polygon(25% 0, 75% 0, 100% 50%, 75% 100%, 25% 100%, 0 50%);
            clip-path: polygon(25% 0, 75% 0, 100% 50%, 75% 100%, 25% 100%, 0 50%);   "> 
            https://bennettfeely.com/clippy/ */?>