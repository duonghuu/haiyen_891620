<?php 
if($source=="index"){
  $product_danhmucnb=get_result("select ten$lang as ten,tenkhongdau,id,thumb,photo
      ,type from #_product_danhmuc where type='san-pham' and noibat>0 and hienthi>0 order by stt asc");
    $spbanchay=get_result("select mota$lang as mota,ten$lang as ten,tenkhongdau,id,thumb,photo
        ,type,gia,giakm from #_product where type='san-pham' and spbanchay>0 and hienthi>0 order by stt asc");
    $txtuudai=get_fetch("select ten$lang as ten,mota$lang as mota from #_about 
        where type='txtuu-dai' ");
    $txtbanchay=get_fetch("select ten$lang as ten,mota$lang as mota from #_about 
        where type='txtban-chay' ");
    $quangcao=get_result("select ten$lang as ten,mota$lang as mota,link,photo,thumb
     from #_slider where hienthi=1 and type='quang-cao' order by stt");
    $txtvisao=get_fetch("select ten$lang as ten,mota$lang as mota from #_about 
        where type='txtvi-sao' ");
    $visao=get_result("select ten$lang as ten,tenkhongdau,id,thumb,photo
      ,type from #_news where type='vi-sao' and hienthi>0 order by stt asc");
    $txttintuc=get_fetch("select ten$lang as ten,mota$lang as mota from #_about 
        where type='txttin-tuc' ");
    $tinnb = get_result("select ten$lang as ten,mota$lang as mota,tenkhongdau,id,thumb,photo
      ,type,luotxem from #_news where type='tin-tuc' and noibat>0 and hienthi>0 order by stt asc");
}
    // $video=get_result("select id,ten$lang as ten,tenkhongdau,link
    //  from #_video where hienthi=1 and type='video' order by stt");
$logolang = get_fetch("select ten$lang as ten,mota$lang as mota,photo as photo from 
#_background where type='logo'");
// $bannerlang = get_fetch("select photo as photo from #_background where type='banner'");
$ftlogo=get_fetch("select photo from #_about where type='footer' ");
// $bgbnlang = get_fetch("select photo as photo from #_background where type='bgbn'");
// $tutags = get_result("select id,ten$lang as ten,link from #_news where type='tags'
 // and hienthi=1 order by stt asc");
// $hotline = get_result("select id,ten$lang as ten,chucvu,link from #_news where
//  type='hotline' and hienthi=1 order by stt asc");
// $diachi = get_result("select id,ten$lang as ten,mota$lang as mota from #_news 
// where type='diachi' and hienthi=1 order by stt asc");
// $yahoo = get_result("select * from #_yahoo where type='yahoo' and hienthi=1 order by stt asc");
// $lkweb = get_result("select link,ten from #_lkweb where type='lkweb' and hienthi=1 order by stt asc");

