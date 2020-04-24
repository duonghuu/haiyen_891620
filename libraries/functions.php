<?php if(!defined('_lib')) die("Error");
use Intervention\Image\ImageManagerStatic as Image;
ini_set ('memory_limit', '256M');
function del_cache(){
  $files = glob('../@#cache/*'); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file)){
      unlink($file); // delete file
    }
  }
}
function unzip_chuanhoa($s){
  $s = str_replace('&#039;', "'", $s);
  $s = str_replace('&quot;', '"', $s);
  $s = str_replace('&lt;', '<', $s);
  $s = str_replace('&gt;', '>', $s);
  return $s;
}
if (! function_exists('array_column')) {
  function array_column(array $input, $columnKey, $indexKey = null) {
    $array = array();
    foreach ($input as $value) {
      if ( !array_key_exists($columnKey, $value)) {
        trigger_error("Key \"$columnKey\" does not exist in array");
        return false;
      }
      if (is_null($indexKey)) {
        $array[] = $value[$columnKey];
      }
      else {
        if ( !array_key_exists($indexKey, $value)) {
          trigger_error("Key \"$indexKey\" does not exist in array");
          return false;
        }
        if ( ! is_scalar($value[$indexKey])) {
          trigger_error("Key \"$indexKey\" does not contain scalar value");
          return false;
        }
        $array[$value[$indexKey]] = $value[$columnKey];
      }
    }
    return $array;
  }
}
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
  // PARA: Date Should In YYYY-MM-DD Format
  $datetime1 = date_create($date_1);
  $datetime2 = date_create($date_2);
  $interval = date_diff($datetime1, $datetime2);
  return $interval->format($differenceFormat);
}
function isAjaxRequest(){
  if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
  {
   return true;
 }
 return false;
}
function get_place_name($tb_name,$id){
  global $d;
  $result = get_fetch("select ten from table_place_$tb_name where id='".$id."'");
  return $result["ten"];
}
function convert_number_to_string($str){
  if($str == 0 || $str == ''){
    $str = ' Thương lượng';
  }else{
    $str = number_format($str);
    $str1 = explode(',',$str);
    $count = count($str1);
    switch ($count){ 
      case '2':
      $str = $str1[0].' ngàn';
      break;
      case '3':
      if($str1[1] != 0){
        $str = $str1[0].' triệu '.number_format($str1[1]).' ngàn';
      }else{
        $str = $str1[0].' triệu';
      }
      break;
      case '4':
      if($str1[1] != 0){
        $str = $str1[0].' tỷ '.number_format($str1[1]).' triệu '.number_format($str1[2]).' ngàn';
        if($str1[2]==0)
          $str = $str1[0].' tỷ '.number_format($str1[1]).' triệu';
      }else {
        $str = $str1[0].' tỷ';
      }
      break;
    }
  } 
  return $str;
} 
function check_login(){
  global $d,$config,$login_name_admin;
  if((!isset($_SESSION[$login_name_admin]) or ($_SESSION[$login_name_admin] != true)) && $act=="login"){
    echo 'Bạn không có quyền truy cập';
    die;
  }
}
function check_login_ajax(){
  global $d,$config,$login_name_admin;
  if((!isset($_SESSION[$login_name_admin]) or ($_SESSION[$login_name_admin] != true))){
    echo 'Bạn không có quyền truy cập';
    die;
  }
}
function image_fix_orientation($path){
  $image = imagecreatefromjpeg($path);
  $exif = exif_read_data($path);
  if (!empty($exif['Orientation'])) {
    switch ($exif['Orientation']) {
      case 3:
      $image = imagerotate($image, 180, 0);
      break;
      case 6:
      $image = imagerotate($image, -90, 0);
      break;
      case 8:
      $image = imagerotate($image, 90, 0);
      break;
    }
    print_r($image);
    imagejpeg($image, $path);
  }
}
function encrypt_password($salt_sta,$str,$salt_end){return md5($salt_sta.$str.$salt_end);}
function format_size ($rawSize)
{
  if ($rawSize / 1048576 > 1) return round($rawSize / 1048576, 1) . ' MB';
  else
    if ($rawSize / 1024 > 1) return round($rawSize / 1024, 1) . ' KB';
  else
    return round($rawSize, 1) . ' Bytes';
}
function humanTiming ($time)
{
    $time = time() - $time; // to get the time since that moment
    $tokens = array (
      31536000 => 'năm',
      2592000 => 'tháng',
      604800 => 'tuần',
      86400 => 'ngày',
      3600 => 'giờ',
      60 => 'phút',
      1 => 'giây'
    );
    foreach ($tokens as $unit => $text) {
      if ($time < $unit) continue;
      $numberOfUnits = floor($time / $unit);
      return $numberOfUnits.' '.$text.(($numberOfUnits>1)?' trước ':'');
    }
  }
  function phanquyen_menu($ten,$com,$act,$type){
   global $d;
   $l_com = $_SESSION['login_admin']['com'];
   $nhom = $_SESSION['login_admin']['nhom'];
   $d->reset();
   $sql = "select id from #_com_quyen where id_quyen='".$nhom."' and com='".$com."' and type ='".$type."' and find_in_set('".$act."',act)>0  limit 0,1";
   $d->query($sql);
   $com_manager = $d->result_array();
   if(!empty($com_manager) or $l_com=='admin'){
    if($com==$_GET['com'] && $act==$_GET['act'] && $type==$_GET['type']){$add_class = 'class="this"';}
    echo  "<li ".$add_class."><a href='index.php?com=".$com."&act=".$act."&type=".$type."'>".$ten."</a></li>";
  }
}
function phanquyen($l_com,$nhom,$com,$act,$type){
  //dump($nhom);
  global $d;
  if($com=='' or $act=='login' or $act=='logout' or $l_com=='admin'){return false;}
  $d->reset();
  $sql = "select id from #_com_quyen where id_quyen='".$nhom."' and com='".$com."' and type ='".$type."' and find_in_set('".$act."',act)>0 limit 0,1";
  $d->query($sql);
  $com_manager = $d->result_array();
  if(empty($com_manager)){
    return true;
  }else{
    return false;
  }
}
function pagesListLimitadmin($url , $totalRows , $pageSize = 5, $offset = 5){
  if ($totalRows<=0) return "";
  $totalPages = ceil($totalRows/$pageSize);
  if ($totalPages<=1) return "";
  if( isset($_GET["p"]) == true)  $currentPage = $_GET["p"];
  else $currentPage = 1;
  settype($currentPage,"int");
  if ($currentPage <=0) $currentPage = 1;
  $firstLink = "<li><a href=\"{$url}\" class=\"left\">First</a><li>";
  $lastLink="<li><a href=\"{$url}&p={$totalPages}\" class=\"right\">End</a></li>";
  $from = $currentPage - $offset;
  $to = $currentPage + $offset;
  if ($from <=0) { $from = 1;   $to = $offset*2; }
  if ($to > $totalPages) { $to = $totalPages; }
  for($j = $from; $j <= $to; $j++) {
    if ($j == $currentPage) $links = $links . "<li><a href='#' class='active'>{$j}</a></li>";
    else{
      $qt = $url. "&p={$j}";
      $links= $links . "<li><a href = '{$qt}'>{$j}</a></li>";
    }
  } //for
  return '<ul class="pages">'.$firstLink.$links.$lastLink.'</ul>';
}
function process_quote($data,$flag=1){
  global $d;
  foreach ($data as $key => $value) {
    $data[$key]=$d->escape_str($data[$key]);
  }
  return $data;
}
function magic_quote($str, $id_connect=false)
{
  global $d;
  return $d->escape_str($str);
  // if (is_array($str))
  // {
  //   foreach($str as $key => $val)
  //   {
  //     $str[$key] = escape_str($val);
  //   }
  //   return $str;
  // }
  // if (is_numeric($str)) {
  //   return $str;
  // }
  // if(get_magic_quotes_gpc()){
  //   $str = stripslashes($str);
  // }
  // if (function_exists('mysql_real_escape_string') AND is_resource($id_connect))
  // {
  //   return mysql_real_escape_string($str, $id_connect);
  // }
  // elseif (function_exists('mysql_escape_string'))
  // {
  //   return mysql_escape_string($str);
  // }
  // else
  // {
  //   return addslashes($str);
  // }
}
// To SANITIZE Integer value use
//$var=(filter_var($var, FILTER_SANITIZE_NUMBER_INT));
//To SANITIZE String value use
function StringInputCleaner($data)
{
  //remove space bfore and after
  $data = trim($data); 
  //remove slashes
  $data = stripslashes($data); 
  $data=(filter_var($data, FILTER_SANITIZE_STRING));
  return $data;
}
//To SANITIZE Sql query value use
function mysqlCleaner($data)
{
  $data= mysql_real_escape_string($data);
  $data= stripslashes($data);
  return $data;
  //or in one line code 
  //return(stripslashes(mysql_real_escape_string($data)));
}
//Get code youtube
function getYoutubeIdFromUrl($url) {
  $parts = parse_url($url);
  if(isset($parts['query'])){
    parse_str($parts['query'], $qs);
    if(isset($qs['v'])){
      return $qs['v'];
    }else if($qs['vi']){
      return $qs['vi'];
    }
  }
  if(isset($parts['path'])){
    $path = explode('/', trim($parts['path'], '/'));
    return $path[count($path)-1];
  }
  return false;
}
function getRealIPAddress(){
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
    //check ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    //to check ip is pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}
function images_name($tenhinh)
{
  $rand=rand(10,9999);
  $ten_anh=explode(".",$tenhinh);
  $result = changeTitle($ten_anh[0])."-".$rand;
  return $result;
}
function escape_str($str, $id_connect=false)
{
  if (is_array($str))
  {
    foreach($str as $key => $val)
    {
      $str[$key] = escape_str($val);
    }
    return $str;
  }
  if (is_numeric($str)) {
    return $str;
  }
  if(get_magic_quotes_gpc()){
    $str = stripslashes($str);
  }
  if (function_exists('mysql_real_escape_string') AND is_resource($id_connect))
  {
    return "'".mysql_real_escape_string($str, $id_connect)."'";
  }
  elseif (function_exists('mysql_escape_string'))
  {
    return "'".mysql_escape_string($str)."'";
  }
  else
  {
    return "'".addslashes($str)."'";
  }
}
// dem so nguoi online
function count_online(){
  global $d;
  $time = 600; // 10 phut
  $ssid = session_id();
  // xoa het han
  $sql = "delete from #_online where time<".(time()-$time);
  $d->query($sql);
  //
  $sql = "select id,session_id from #_online order by id desc";
  $d->query($sql);
  $result['dangxem'] = $d->num_rows();
  $rows = $d->result_array();
  $i = 0;
  while(($rows[$i]['session_id'] != $ssid) && $i++<$result['dangxem']);
  if($i<$result['dangxem']){
    $sql = "update #_online set time='".time()."' where session_id='".$ssid."'";
    $d->query($sql);
    $result['daxem'] = $rows[0]['id'];
  }
  else{
    $sql = "insert into #_online (session_id, time) values ('".$ssid."', '".time()."')";
    $d->query($sql);
    $result['daxem'] = mysql_insert_id();
    $result['dangxem']++;
  }
  return $result; // array('dangxem'=>'', 'daxem'=>'')
}
//Lấy ngày
function make_date($time,$dot='.',$lang='vi',$f=false){
  $str = ($lang == 'vi') ? date("d{$dot}m{$dot}Y",$time) : date("m{$dot}d{$dot}Y",$time);
  if($f){
    $thu['vi'] = array('Chủ nhật','Thứ hai','Thứ ba','Thứ tư','Thứ năm','Thứ sáu','Thứ bảy');
    $thu['en'] = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    $str = $thu[$lang][date('w',$time)].', '.$str;
  }
  return $str;
}
//Alert
function alert($s){
  echo '<script language="javascript"> alert("'.$s.'") </script>';
}
function delete_file($file){
  return @unlink($file);
}
//Upload file
function upload_image($file, $extension, $folder, $newname=''){
  if(isset($_FILES[$file]) && !$_FILES[$file]['error']){
    $ext = end(explode('.',$_FILES[$file]['name']));
    $name = basename($_FILES[$file]['name'], '.'.$ext);
    if($name!='sitemap')
    {
      $name=changeTitle($name).'-'.fns_Rand_digit(0,9,4);
    }
    $newname = $name.'.'.$ext;
    if(strpos($extension, $ext)===false){
     alert('Chỉ hỗ trợ upload file dạng '.$extension);
      return false; // không hỗ trợ
    }
    if($newname=='' or file_exists($folder.$_FILES[$file]['name']))
      for($i=0; $i<100; $i++){
        if(!file_exists($folder.$name.$i.'.'.$ext)){
          $_FILES[$file]['name'] = $name.$i.'.'.$ext;
          break;
        }
      }
      else
      {
       $_FILES[$file]['name'] = $newname;
     }
     if (!copy($_FILES[$file]["tmp_name"], $folder.$_FILES[$file]['name'])) {
       if ( !move_uploaded_file($_FILES[$file]["tmp_name"], $folder.$_FILES[$file]['name']))                {
        return false;
      }
    }
    return $_FILES[$file]['name'];
  }
  return false;
}
function upload_photos($file, $extension, $folder, $newname=''){
  if(isset($file) && !$file['error']){
    $ext = end(explode('.',$file['name']));
    $name = basename($file['name'], '.'.$ext);
    //alert('Chỉ hỗ trợ upload file dạng '.$ext);
    if(strpos($extension, $ext)===false){
      alert('Chỉ hỗ trợ upload file dạng '.$ext.'-////-'.$extension);
      return false; // không hỗ trợ
    }
    if($newname=='' && file_exists($folder.$file['name']))
      for($i=0; $i<100; $i++){
        if(!file_exists($folder.$name.$i.'.'.$ext)){
          $file['name'] = $name.$i.'.'.$ext;
          break;
        }
      }
      else{
       $file['name'] = $newname.'.'.$ext;
     }
     if (!copy($file["tmp_name"], $folder.$file['name'])) {
       if ( !move_uploaded_file($file["tmp_name"], $folder.$file['name']))  {
        return false;
      }
    }
    return $file['name'];
  }
  return false;
}
//Tạo hình khác
function thumb_image($file, $width, $height, $folder){
  if(!file_exists($folder.$file)) return false; // không tìm thấy file
  if ($cursize = getimagesize ($folder.$file)) {
    $newsize = setWidthHeight($cursize[0], $cursize[1], $width, $height);
    $info = pathinfo($file);
    $dst = imagecreatetruecolor ($newsize[0],$newsize[1]);
    $types = array('jpg' => array('imagecreatefromjpeg', 'imagejpeg'),
     'gif' => array('imagecreatefromgif', 'imagegif'),
     'png' => array('imagecreatefrompng', 'imagepng'));
    $func = $types[$info['extension']][0];
    $src = $func($folder.$file);
    imagecopyresampled($dst, $src, 0, 0, 0, 0,$newsize[0], $newsize[1],$cursize[0], $cursize[1]);
    $func = $types[$info['extension']][1];
    $new_file = str_replace('.'.$info['extension'],'_thumb.'.$info['extension'],$file);
    return $func($dst, $folder.$new_file) ? $new_file : false;
  }
}
function setWidthHeight($width, $height, $maxWidth, $maxHeight){
  $ret = array($width, $height);
  $ratio = $width / $height;
  if ($width > $maxWidth || $height > $maxHeight) {
    $ret[0] = $maxWidth;
    $ret[1] = $ret[0] / $ratio;
    if ($ret[1] > $maxHeight) {
      $ret[1] = $maxHeight;
      $ret[0] = $ret[1] * $ratio;
    }
  }
  return $ret;
}
//Chuyển trang có thông báo
function transfer($msg,$page="index.php")
{
  $showtext = $msg;
  $page_transfer = $page;
  include("./templates/transfer_tpl.php");
  exit();
}
//Chuyển trang không thông báo
function redirect($url=''){
  echo '<script language="javascript">window.location = "'.$url.'" </script>';
  exit();
}
//Quay lại trang trước
function back($n=1){
  echo '<script language="javascript">history.go = "'.-intval($n).'" </script>';
  exit();
}
//Thay thế ký tự đặc biệt
function chuanhoa($s){
  $s = str_replace("'", '&#039;', $s);
  $s = str_replace('"', '&quot;', $s);
  $s = str_replace('<', '&lt;', $s);
  $s = str_replace('>', '&gt;', $s);
  return $s;
}
function themdau($s){
  $s = addslashes($s);
  return $s;
}
function bodau($s){
  $s = stripslashes($s);
  return $s;
}
//Show mảng
function dump($arr, $exit=1){
  echo "<pre>";
  var_dump($arr);
  echo "<pre>";
  if($exit) exit();
}
//Phân trang
function paging($r, $url='', $curPg=1, $mxR=5, $mxP=5, $class_paging='')
{
  if($curPg<1) $curPg=1;
  if($mxR<1) $mxR=5;
  if($mxP<1) $mxP=5;
  $totalRows=count($r);
  if($totalRows==0)
   return array('source'=>NULL, 'paging'=>NULL);
 $totalPages=ceil($totalRows/$mxR);
 if($curPg > $totalPages) $curPg=$totalPages;
 $_SESSION['maxRow']=$mxR;
 $_SESSION['curPage']=$curPg;
 $r2=array();
 $paging="";
    //-------------tao array------------------
 $start=($curPg-1)*$mxR;
 $end=($start+$mxR)<$totalRows?($start+$mxR):$totalRows;
    #echo $start;
    #echo $end;
 $j=0;
 for($i=$start;$i<$end;$i++)
   $r2[$j++]=$r[$i];
    //-------------tao chuoi------------------
 $curRow = ($curPg-1)*$mxR+1;
 if($totalRows>$mxR)
 {
   $start=1;
   $end=1;
   $paging1 ="";
   for($i=1;$i<=$totalPages;$i++)
   {
    if(($i>((int)(($curPg-1)/$mxP))* $mxP) && ($i<=((int)(($curPg-1)/$mxP+1))* $mxP))
    {
     if($start==1) $start=$i;
     if($i==$curPg){
            $paging1.=" <span>".$i."</span> ";//dang xem
          }
          else
          {
            $paging1 .= " <a href='".$url."&curPage=".$i."'  class=\"{$class_paging}\">".$i."</a> ";
          }
          $end=$i;
        }
      }//tinh paging
      //$paging.= "Go to page :&nbsp;&nbsp;" ;
      #if($curPg>$mxP)
      #{
        $paging .=" <a href='".$url."' class=\"{$class_paging}\" >&laquo;</a> "; //ve dau
        #$paging .=" <a href='".$url."&curPage=".($start-1)."' class=\"{$class_paging}\" >&#8249;</a> "; //ve truoc
        $paging .=" <a href='".$url."&curPage=".($curPg-1)."' class=\"{$class_paging}\" >&#8249;</a> "; //ve truoc
      #}
        $paging.=$paging1;
      #if(((int)(($curPg-1)/$mxP+1)*$mxP) < $totalPages)
      #{
        #$paging .=" <a href='".$url."&curPage=".($end+1)."' class=\"{$class_paging}\" >&#8250;</a> "; //ke
        $paging .=" <a href='".$url."&curPage=".($curPg+1)."' class=\"{$class_paging}\" >&#8250;</a> "; //ke
        $paging .=" <a href='".$url."&curPage=".($totalPages)."' class=\"{$class_paging}\" >&raquo;</a> "; //ve cuoi
      #}
      }
      $r3['curPage']=$curPg;
      $r3['source']=$r2;
      $r3['paging']=$paging;
    #echo '<pre>';var_dump($r3);echo '</pre>';
      return $r3;
    }
    function paging_home($r, $url='', $curPg=1, $mxR=5, $mxP=5, $class_paging='')
    {
      if($curPg<1) $curPg=1;
      if($mxR<1) $mxR=5;
      if($mxP<1) $mxP=5;
      $totalRows=count($r);
      if($totalRows==0)
       return array('source'=>NULL, 'paging'=>NULL);
     $totalPages=ceil($totalRows/$mxR);
     if($curPg > $totalPages) $curPg=$totalPages;
     $_SESSION['maxRow']=$mxR;
     $_SESSION['curPage']=$curPg;
     $r2=array();
     $paging="";
    //-------------tao array------------------
     $start=($curPg-1)*$mxR;
     $end=($start+$mxR)<$totalRows?($start+$mxR):$totalRows;
    #echo $start;
    #echo $end;
     $j=0;
     for($i=$start;$i<$end;$i++)
       $r2[$j++]=$r[$i];
    //-------------tao chuoi------------------
     $curRow = ($curPg-1)*$mxR+1;
     if($totalRows>$mxR)
     {
       $start=1;
       $end=1;
       $paging1 ="";
       for($i=1;$i<=$totalPages;$i++)
       {
        if(($i>((int)(($curPg-1)/$mxP))* $mxP) && ($i<=((int)(($curPg-1)/$mxP+1))* $mxP))
        {
         if($start==1) $start=$i;
         if($i==$curPg){
            $paging1.=" <span>".$i."</span> ";//dang xem
          }
          else
          {
            $paging1 .= " <a href='".$url."&p=".$i."'  class=\"{$class_paging}\">".$i."</a> ";
          }
          $end=$i;
        }
      }//tinh paging
      //$paging.= "Go to page :&nbsp;&nbsp;" ;
      #if($curPg>$mxP)
      #{
        $paging .=" <a href='".$url."' class=\"{$class_paging}\" >&laquo;</a> "; //ve dau
        #$paging .=" <a href='".$url."&curPage=".($start-1)."' class=\"{$class_paging}\" >&#8249;</a> "; //ve truoc
        $paging .=" <a href='".$url."&p=".($curPg-1)."' class=\"{$class_paging}\" >&#8249;</a> "; //ve truoc
      #}
        $paging.=$paging1;
      #if(((int)(($curPg-1)/$mxP+1)*$mxP) < $totalPages)
      #{
        #$paging .=" <a href='".$url."&curPage=".($end+1)."' class=\"{$class_paging}\" >&#8250;</a> "; //ke
        $paging .=" <a href='".$url."&p=".($curPg+1)."' class=\"{$class_paging}\" >&#8250;</a> "; //ke
        $paging .=" <a href='".$url."&p=".($totalPages)."' class=\"{$class_paging}\" >&raquo;</a> "; //ve cuoi
      #}
      }
      $r3['curPage']=$curPg;
      $r3['source']=$r2;
      $r3['paging']=$paging;
      $r3['total']=$totalRows;
    #echo '<pre>';var_dump($r3);echo '</pre>';
      return $r3;
    }
//Phân trang nằm giữa
    function paging_giua($r, $url='', $curPg=1, $mxR=5, $maxP=5, $class_paging='')
    {
      if($curPg<1) $curPg=1;
      if($mxR<1) $mxR=5;
      if($maxP<1) $maxP=5;
      $totalRows=count($r);
      if($totalRows==0)
        return array('source'=>NULL, 'paging'=>NULL);
      $totalPages=ceil($totalRows/$mxR);
      if($curPg > $totalPages) $curPg=$totalPages;
      $_SESSION['maxRow']=$mxR;
      $_SESSION['curPage']=$curPg;
      $r2=array();
      $paging="";
        //-------------tao array------------------
      $start=($curPg-1)*$mxR;
      $end=($start+$mxR)<$totalRows?($start+$mxR):$totalRows;
        #echo $start;
        #echo $end;
      $j=0;
      for($i=$start;$i<$end;$i++)
        $r2[$j++]=$r[$i];
      if($totalRows>$mxR){
        //-------------tao chuoi------------------
        $from = $curPg - 2;
        $to = $curPg + 2;
        if($curPg <= $totalPages && $curPg >= $totalPages-1){$from = $totalPages - 4;}
        if ($from <=0) { $from = 1;   $to = 5; }
        if ($to > $totalPages) { $to = $totalPages; }
        for($j = $from; $j <= $to; $j++) {
         if ($j == $curPg){
           $paging1.=" <span>".$j."</span> ";
         }
         else{
          $paging1 .= " <a class='paging transitionAll' href='".$url."&p=".$j."'>".$j."</a> ";
        }
        } //for
        $paging .=" <a href='".$url."' >&laquo;</a> "; //ve dau
                #$paging .=" <a href='".$url."&curPage=".($start-1)."' class=\"{$class_paging}\" >&#8249;</a> "; //ve truoc
                $paging .=" <a href='".$url."&p=".($curPg-1)."' >&#8249;</a> "; //ve truoc
            #}
                $paging.=$paging1;
            #if(((int)(($curPg-1)/$mxP+1)*$mxP) < $totalPages)
            #{
                #$paging .=" <a href='".$url."&curPage=".($end+1)."' class=\"{$class_paging}\" >&#8250;</a> "; //ke
                $paging .=" <a href='".$url."&p=".($curPg+1)."' >&#8250;</a> "; //ke
                $paging .=" <a href='".$url."&p=".($totalPages)."' >&raquo;</a> "; //ve cuoi
              }
              $r3['curPage']=$curPg;
              $r3['source']=$r2;
              $r3['paging']=$paging;
              $r3['total']=$totalRows;
        #echo '<pre>';var_dump($r3);echo '</pre>';
              return $r3;
            }
//Cắt chuỗi
            function catchuoi($chuoi,$gioihan){
// nếu độ dài chuỗi nhỏ hơn hay bằng vị trí cắt
// thì không thay đổi chuỗi ban đầu
              if(strlen($chuoi)<=$gioihan)
              {
                return $chuoi;
              }
              else{
/*
so sánh vị trí cắt
với kí tự khoảng trắng đầu tiên trong chuỗi ban đầu tính từ vị trí cắt
nếu vị trí khoảng trắng lớn hơn
thì cắt chuỗi tại vị trí khoảng trắng đó
*/
if(strpos($chuoi," ",$gioihan) > $gioihan){
  $new_gioihan=strpos($chuoi," ",$gioihan);
  $new_chuoi = substr($chuoi,0,$new_gioihan)."...";
  return $new_chuoi;
}
// trường hợp còn lại không ảnh hưởng tới kết quả
$new_chuoi = substr($chuoi,0,$gioihan)."...";
return $new_chuoi;
}
}
function stripUnicode($str){
  if(!$str) return false;
  $unicode = array(
   'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
   'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
   'd'=>'đ',
   'D'=>'Đ',
   'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
   'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
   'i'=>'í|ì|ỉ|ĩ|ị',
   'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
   'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
   'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
   'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
   'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
   'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
   'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
 );
  foreach($unicode as $khongdau=>$codau) {
    $arr=explode("|",$codau);
    $str = str_replace($arr,$khongdau,$str);
  }
  return $str;
}// Doi tu co dau => khong dau
function utf8convert($str) {
  if(!$str) return false;
  $utf8 = array(
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
    'd'=>'đ|Đ',
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
    'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    ''=>'`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\“|\”|\:|\;|_',
  );
  foreach($utf8 as $ascii=>$uni)
    $str = preg_replace("/($uni)/i",$ascii,$str);
  return $str;
}
function changeTitle($str){
 $str = stripUnicode($str);
 $str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
 $str = strtolower($str);
 $str = trim($str);
 $str = str_replace("-"," ",$str);
 $str=preg_replace('/[^a-zA-Z0-9\ ]/','',$str);
 $str = str_replace("  "," ",$str);
 $str = str_replace(" ","-",$str);
 return $str;
} 
function changeTitleImage($str)
{
  $str = stripUnicode($str);
  $str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
  $str = trim($str);
  $str = str_replace("  "," ",$str);
  $str = str_replace(" ","-",$str);
  return $str;
}
//Lấy dường dẫn hiện tại
function getCurrentPageURL() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_NAME"]=="locahost") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  $pageURL = explode("&p=", $pageURL);
  return $pageURL[0];
}
function getCurrentPageURL_AMP() { //Hàm thêm mới - để thêm mới /amp/ vào đường link trong đường link hiện tại
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_NAME"]=="locahost") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/amp".$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"]."/amp".$_SERVER["REQUEST_URI"];
  }
  $pageURL = explode("&p=", $pageURL);
  return $pageURL[0];
}
function getCurrentPage() {
  $pageURL = 'http';
  if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
  $pageURL .= "://";
  if ($_SERVER["SERVER_NAME"]=="locahost") {
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $pageURL;
}
function seo_entities($str) {
  $res_2 = htmlentities($str, ENT_QUOTES, "UTF-8");
  $res_2 = str_replace("'","&#039;",$str);
  $res_2 = str_replace('"','&quot;',$str);
  return $res_2;
}
function replace_img_src($img_tag) {
  $doc = new DOMDocument();
  $doc->loadHTML(mb_convert_encoding($img_tag, 'HTML-ENTITIES', 'UTF-8'));
  $tags = $doc->getElementsByTagName('img');
  foreach ($tags as $tag) {
    $old_src = $tag->getAttribute('src');
    list($width, $height, $type, $attr) = getimagesize($old_src);
    $tag->setAttribute('height', $height);
    $tag->setAttribute('width', $width);
  }
  return $doc->saveHTML();
}
function ampify($html='') {
    # Replace img, audio, and video elements with amp custom elements
  $html = replace_img_src($html); 
  $html = str_ireplace(array('<img','<video','/video>','<audio','/audio>'),array('<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'),$html);
    # Add closing tags to amp-img custom element
  $html = preg_replace('/<amp-img(.*?)\/?>/','<amp-img$1 layout="responsive" width="700" height="500"></amp-img>',$html);
    # Whitelist of HTML tags allowed by AMP
  $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
    # replace style to w,h
  $html = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $html);
  return $html;
}

//Tạo hình ảnh kahcs
function thumb_simple($src_img, $new_w, $new_h){
  $src_img->fit($new_w, $new_h, function ($constraint) {
    $constraint->upsize();
  });
  return $src_img;
}
function thumb_ratio($src_img, $new_w, $new_h){
  $src_img->resize($new_w, $new_h, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
  });
  return $src_img;
}
function thumb_bgratio($src_img, $new_w, $new_h){
  $src_img->resize($new_w, $new_h, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
  });
  // $img_thumb = Image::canvas($new_w, $new_h, 'rgba(255,255,255,1)');
  $img_thumb = Image::canvas($new_w, $new_h);
  $img_thumb->insert($src_img, 'center');
  return $img_thumb;
}
function create_thumb($file, $width, $height, $folder,$file_name,$zoom_crop='1',$ext_thumb='jpeg',$dong='0'){
   $type = end(explode('.',$file_name));
   $name = basename($file_name, '.'.$type);
   $name = changeTitleImage($name);
   $file_name = $name.'.'.$type;
   $new_w = $width;
   $new_h = $height;

   $image_url = $folder.$file;
   $array = getimagesize($image_url);
   if ($array)
   {
     list($image_w, $image_h) = $array;
   }
   else
   {
    die("NO IMAGE $image_url");
  }
  $src_w=$image_w;
  $src_h=$image_h;

  $src_img = Image::make($image_url);

  $quant = 90;
  $myExpType = (!empty($ext_thumb))? $ext_thumb: 'JPEG';
  $new_file=$name.'-'.fns_Rand_digit(0,9,4).'_'.round($width).'x'.
  round($height).'.'.$myExpType;
  $pathto = $folder.$new_file;
  if ($zoom_crop==1) {
    $IMG = thumb_simple($src_img, $new_w, $new_h);
  }
  if ($zoom_crop==2) {
    $IMG = thumb_bgratio($src_img, $new_w, $new_h);
  }
  if ($zoom_crop==3) {
    $IMG = thumb_ratio($src_img, $new_w, $new_h);
  }

  if($dong == 1){
    $new_w = $this->width;
    $new_h = $this->height;

    // $img_thumb = Image::make((__DIR__).'/Upload/hinhanh/watermark.png');
    $img_thumb = Image::make((__DIR__)."/".$_SESSION['dong']);

    $img_thumb->resize(round($new_w/2,0), round($new_h/2,0), function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });
    $img_thumb->opacity(100);

    $IMG->insert($img_thumb, 'bottom-right', 5, 5);

    $IMG->save($pathto, $quant);
  }else{
    //$img->save('public/foo', 80, 'jpg');
    $IMG->save($pathto, $quant);
  }
  return $new_file;
  }
function create_thumb_old($file, $width, $height, $folder,$file_name,$zoom_crop='1'){
  $ext = end(explode('.',$file_name));
  $name = basename($file_name, '.'.$ext);
  $name=changeTitleImage($name);
  $file_name = $name.'.'.$ext;
// ACQUIRE THE ARGUMENTS - MAY NEED SOME SANITY TESTS?
  $new_width   = $width;
  $new_height   = $height;
  if ($new_width && !$new_height) {
    $new_height = floor ($height * ($new_width / $width));
  } else if ($new_height && !$new_width) {
    $new_width = floor ($width * ($new_height / $height));
  }
  $image_url = $folder.$file;
  $origin_x = 0;
  $origin_y = 0;
// GET ORIGINAL IMAGE DIMENSIONS
  $array = getimagesize($image_url);
  if ($array)
  {
    list($image_w, $image_h) = $array;
  }
  else
  {
   die("NO IMAGE $image_url");
 }
 $width=$image_w;
 $height=$image_h;
// ACQUIRE THE ORIGINAL IMAGE
 $image_ext = trim(strtolower(end(explode('.', $image_url))));
 switch(strtoupper($image_ext))
 {
   case 'JPG' :
   case 'JPEG' :
   $image = imagecreatefromjpeg($image_url);
   $func='imagejpeg';
   break;
   case 'PNG' :
   $image = imagecreatefrompng($image_url);
   $func='imagepng';
   break;
   case 'GIF' :
   $image = imagecreatefromgif($image_url);
   $func='imagegif';
   break;
   default : die("UNKNOWN IMAGE TYPE: $image_url");
 }
// scale down and add borders
 if ($zoom_crop == 3) {
  $new_height = $new_width*$height/$width;
 //  $final_height = $height * ($new_width / $width);
 //  if ($final_height > $new_height) {
 //     $new_width = $width * ($new_height / $height);
 // } else {
 //     $new_height = $final_height;
 // }
}
  // create a new true color image
$canvas = imagecreatetruecolor ($new_width, $new_height);
imagealphablending ($canvas, false);
  // Create a new transparent color for image
$color = imagecolorallocatealpha ($canvas, 255, 255, 255, 127);
  // Completely fill the background of the new image with allocated color.
imagefill ($canvas, 0, 0, $color);
  // scale down and add borders
if ($zoom_crop == 2) {
  $final_height = $height * ($new_width / $width);
  if ($final_height > $new_height) {
   $origin_x = $new_width / 2;
   $new_width = $width * ($new_height / $height);
   $origin_x = round ($origin_x - ($new_width / 2));
 } else {
   $origin_y = $new_height / 2;
   $new_height = $final_height;
   $origin_y = round ($origin_y - ($new_height / 2));
 }
}
  // Restore transparency blending
imagesavealpha ($canvas, true);
if ($zoom_crop > 0) {
  $src_x = $src_y = 0;
  $src_w = $width;
  $src_h = $height;
  $cmp_x = $width / $new_width;
  $cmp_y = $height / $new_height;
    // calculate x or y coordinate and width or height of source
  if ($cmp_x > $cmp_y) {
   $src_w = round ($width / $cmp_x * $cmp_y);
   $src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);
 } else if ($cmp_y > $cmp_x) {
   $src_h = round ($height / $cmp_y * $cmp_x);
   $src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);
 }
    // positional cropping!
 if ($align) {
   if (strpos ($align, 't') !== false) {
    $src_y = 0;
  }
  if (strpos ($align, 'b') !== false) {
    $src_y = $height - $src_h;
  }
  if (strpos ($align, 'l') !== false) {
    $src_x = 0;
  }
  if (strpos ($align, 'r') !== false) {
    $src_x = $width - $src_w;
  }
}
imagecopyresampled ($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
} else {
        // copy and resize part of an image with resampling
  imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
}
$ext = end(explode('.',$file_name));
$file_name = basename($file_name, '.'.$ext);
$new_file=$file_name.fns_Rand_digit(0,9,4).'_'.round($new_width).'x'.round($new_height).'.'.$image_ext;
// SHOW THE NEW THUMB IMAGE
if($func=='imagejpeg') $func($canvas, $folder.$new_file,100);
else $func($canvas, $folder.$new_file,floor ($quality * 0.09));
// else $func($canvas, $folder.$new_file,100);
return $new_file;
}
//Lấy chuỗi ngẫu nhiên
function ChuoiNgauNhien($sokytu){
  $chuoi="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789";
  $giatri="";
  for ($i=0; $i < $sokytu; $i++){
   $vitri = mt_rand( 0 ,strlen($chuoi) );
   $giatri= $giatri . substr($chuoi,$vitri,1 );
 }
 return $giatri;
}
function convert_number_to_words($number) {
  $hyphen      = ' ';
  $conjunction = '  ';
  $separator   = ' ';
  $negative    = 'âm ';
  $decimal     = ' phẩy ';
  $dictionary  = array(
    0                   => 'Không',
    1                   => 'Một',
    2                   => 'Hai',
    3                   => 'Ba',
    4                   => 'Bốn',
    5                   => 'Năm',
    6                   => 'Sáu',
    7                   => 'Bảy',
    8                   => 'Tám',
    9                   => 'Chín',
    10                  => 'Mười',
    11                  => 'Mười Một',
    12                  => 'Mười Hai',
    13                  => 'Mười Ba',
    14                  => 'Mười Bốn',
    15                  => 'Mười Lăm',
    16                  => 'Mười Sáu',
    17                  => 'Mười Bảy',
    18                  => 'Mười Tám',
    19                  => 'Mười Chín',
    20                  => 'Hai Mươi',
    30                  => 'Ba Mươi',
    40                  => 'Bốn Mươi',
    50                  => 'Năm Mươi',
    60                  => 'Sáu Mươi',
    70                  => 'Bảy Mươi',
    80                  => 'Tám Mươi',
    90                  => 'Chín Mươi',
    100                 => 'Trăm',
    1000                => 'Ngàn',
    1000000             => 'Triệu',
    1000000000          => 'Tỷ',
    1000000000000       => 'Nghìn Tỷ',
    1000000000000000    => 'Ngàn Triệu Triệu',
    1000000000000000000 => 'Tỷ Tỷ'
  );
  if (!is_numeric($number)) {
    return false;
  }
  if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
    // overflow
    trigger_error(
      'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
      E_USER_WARNING
    );
    return false;
  }
  if ($number < 0) {
    return $negative . convert_number_to_words(abs($number));
  }
  $string = $fraction = null;
  if (strpos($number, '.') !== false) {
    list($number, $fraction) = explode('.', $number);
  }
  switch (true) {
    case $number < 21:
    $string = $dictionary[$number];
    break;
    case $number < 100:
    $tens   = ((int) ($number / 10)) * 10;
    $units  = $number % 10;
    $string = $dictionary[$tens];
    if ($units) {
      $string .= $hyphen . $dictionary[$units];
    }
    break;
    case $number < 1000:
    $hundreds  = $number / 100;
    $remainder = $number % 100;
    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
    if ($remainder) {
      $string .= $conjunction . convert_number_to_words($remainder);
    }
    break;
    default:
    $baseUnit = pow(1000, floor(log($number, 1000)));
    $numBaseUnits = (int) ($number / $baseUnit);
    $remainder = $number % $baseUnit;
    $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
    if ($remainder) {
      $string .= $remainder < 100 ? $conjunction : $separator;
      $string .= convert_number_to_words($remainder);
    }
    break;
  }
  if (null !== $fraction && is_numeric($fraction)) {
    $string .= $decimal;
    $words = array();
    foreach (str_split((string) $fraction) as $number) {
      $words[] = $dictionary[$number];
    }
    $string .= implode(' ', $words);
  }
  return $string;
}
/*
function yahoo($nick_yahoo='nina',$icon='1'){
  $link = '<a href="ymsgr:sendIM?"'.$nick_yahoo.'"><img src="http://opi.yahoo.com/online?u="'.$nick_yahoo.'"&amp;m=g&amp;t="'.$icon.'""></a>';
  return $link;
}
function check_yahoo($nick_yahoo='nina'){
  $file = @fopen("http://opi.yahoo.com/online?u=".$nick_yahoo."&m=t&t=1","r");
  $read = @fread($file,200);
  if($read==false || strstr($read,"00"))
    $img = '<img src="../images/yahoo_offline.png" />';
  else
    $img = '<img src="../images/yahoo_online.png" />';
  return '<a href="ymsgr:sendIM?'.$nick_yahoo.'">'.$img.'</a>';
}
function skype($nick_skype='nina',$icon='1'){
  $link = '<a href="skype:"'.$nick_skype.'"?call><img src="http://mystatus.skype.com/bigclassic/"'.$nick_skype.'""></a>';
  return $link;
}
function check_skype($nick_skype='nina'){
  if(strlen(@file_get_contents("http://mystatus.skype.com/bigclassic/".$nick_skype))>2000)
  $img = '<img src="../images/skype_online.png" />';
  else
    $img = '<img src="../images/skype_offline.png" />';
  return '<a href="skype:'.$nick_skype.'?call">'.$img.'</a>';
}
function doc3so($so)
{
    $achu = array ( " không "," một "," hai "," ba "," bốn "," năm "," sáu "," bảy "," tám "," chín " );
    $aso = array ( "0","1","2","3","4","5","6","7","8","9" );
    $kq = "";
    $tram = floor($so/100); // Hàng trăm
    $chuc = floor(($so/10)%10); // Hàng chục
    $donvi = floor(($so%10)); // Hàng đơn vị
    if($tram==0 && $chuc==0 && $donvi==0) $kq = "";
    if($tram!=0)
    {
        $kq .= $achu[$tram] . " trăm ";
        if (($chuc == 0) && ($donvi != 0)) $kq .= " lẻ ";
    }
    if (($chuc != 0) && ($chuc != 1))
    {
            $kq .= $achu[$chuc] . " mươi";
            if (($chuc == 0) && ($donvi != 0)) $kq .= " linh ";
    }
    if ($chuc == 1) $kq .= " mười ";
    switch ($donvi)
    {
        case 1:
            if (($chuc != 0) && ($chuc != 1))
            {
                $kq .= " mốt ";
            }
            else
            {
                $kq .= $achu[$donvi];
            }
            break;
        case 5:
            if ($chuc == 0)
            {
                $kq .= $achu[$donvi];
            }
            else
            {
                $kq .= " năm ";
            }
            break;
        default:
            if ($donvi != 0)
            {
                   $kq .= $achu[$donvi];
            }
            break;
    }
    if($kq=="")
    $kq=0;
    return $kq;
}
function doctien($number)
{
$donvi=" đồng ";
$tiente=array("nganty" => " nghìn tỷ ","ty" => " tỷ ","trieu" => " triệu ","ngan" =>" nghìn ","tram" => " trăm ");
$num_f=$nombre_format_francais = number_format($number, 2, ',', ' ');
$vitri=strpos($num_f,',');
$num_cut=substr($num_f,0,$vitri);
$mang=explode(" ",$num_cut);
$sophantu=count($mang);
switch($sophantu)
{
    case '5':
            $nganty=doc3so($mang[0]);
            $text=$nganty;
            $ty=doc3so($mang[1]);
            $trieu=doc3so($mang[2]);
            $ngan=doc3so($mang[3]);
            $tram=doc3so($mang[4]);
            if((int)$mang[1]!=0)
            {
                $text.=$tiente['ngan'];
                $text.=$ty.$tiente['ty'];
            }
            else
            {
                $text.=$tiente['nganty'];
            }
            if((int)$mang[2]!=0)
                $text.=$trieu.$tiente['trieu'];
            if((int)$mang[3]!=0)
                $text.=$ngan.$tiente['ngan'];
            if((int)$mang[4]!=0)
                $text.=$tram;
            $text.=$donvi;
            return  $text;
    break;
    case '4':
            $ty=doc3so($mang[0]);
            $text=$ty.$tiente['ty'];
            $trieu=doc3so($mang[1]);
            $ngan=doc3so($mang[2]);
            $tram=doc3so($mang[3]);
            if((int)$mang[1]!=0)
                $text.=$trieu.$tiente['trieu'];
            if((int)$mang[2]!=0)
                $text.=$ngan.$tiente['ngan'];
            if((int)$mang[3]!=0)
                $text.=$tram;
            $text.=$donvi;
            return $text;
    break;
    case '3':
            $trieu=doc3so($mang[0]);
            $text=$trieu.$tiente['trieu'];
            $ngan=doc3so($mang[1]);
            $tram=doc3so($mang[2]);
            if((int)$mang[1]!=0)
                $text.=$ngan.$tiente['ngan'];
            if((int)$mang[2]!=0)
                $text.=$tram;
            $text.=$donvi;
            return $text;
    break;
    case '2':
            $ngan=doc3so($mang[0]);
            $text=$ngan.$tiente['ngan'];
            $tram=doc3so($mang[1]);
            if((int)$mang[1]!=0)
                $text.=$tram;
            $text.=$donvi;
            return $text;
    break;
    case '1':
            $tram=doc3so($mang[0]);
            $text=$tram.$donvi;
            return $text;
    break;
    default:
        echo "Xin lỗi số quá lớn không thể đổi được";
    break;
}
}
function doc_so($so)
{
    $so = preg_replace("([a-zA-Z{!@#$%^&*()_+<>?,.}]*)","",$so);
    if (strlen($so) <= 21)
    {
        $kq = "";
        $c = 0;
        $d = 0;
        $tien = array ( "", " nghìn", " triệu", " tỷ", " nghìn tỷ", " triệu tỷ", " tỷ tỷ" );
        for ($i = 0; $i < strlen($so); $i++)
        {
            if ($so[$i] == "0")
                $d++;
            else break;
        }
        $so = substr($so,$d);
        for ($i = strlen($so); $i > 0; $i-=3)
        {
            $a[$c] = substr($so, $i, 3);
            $so = substr($so, 0, $i);
            $c++;
        }
        $a[$c] = $so;
        for ($i = count($a); $i > 0; $i--)
        {
            if (strlen(trim($a[$i])) != 0)
            {
                if (doc3so($a[$i]) != "")
                {
                    if (($tien[$i-1]==""))
                    {
                        if (count($a) > 2)
                            $kq .= " không trăm lẻ ".doc3so($a[$i]).$tien[$i-1];
                        else $kq .= doc3so($a[$i]).$tien[$i-1];
                    }
                    else if ((trim(doc3so($a[$i])) == "mười") && ($tien[$i-1]==""))
                    {
                        if (count($a) > 2)
                            $kq .= " không trăm ".doc3so($a[$i]).$tien[$i-1];
                        else $kq .= doc3so($a[$i]).$tien[$i-1];
                    }
                    else
                    {
                    $kq .= doc3so($a[$i]).$tien[$i-1];
                    }
                }
            }
        }
        return $kq;
    }
    else
    {
        return "Số quá lớn!";
    }
}
function send_face($link){
  global $d,$messger,$company;
  require_once _lib.'facebook_php_sdk/facebook.php';
    $facebook = new Facebook(array(
       'appId' => "209039099832913",
       'secret' => "49bb953ad9a69e4c02fd2b102b8b378b",
    ));
    //============================================
      $id_page="150370142303464";
      $token="EAACZBHrVKKlEBAHZCuAWY08jQ6ZCNvvrzXgVca2ZBEHmRWDqLqMPuaHcOhZB9kfeZBG37z7ADdsiZBh5UnKcDHeqRBOjEJn5kQH5YwG33mjloOvMiaatIwEmE9qjTOQjb6X4fFJ6ZC9o5seQML90EesrgKyP5J11qXUa6hzDe43xgiuq2Yk5r0CcHqpZBReZA8khgZD";
    //============================================
      try{
        $api = $facebook->api($id_page .'/feed', 'POST', array(
          access_token => $token,
          link => $link,
          message => '',//tieu de status
         ));
        $messger=1;
      }catch(Exception $e){
        $messger=0;
        echo $e->getMessage();
      }
    echo ($messger);
    die;
}
*/
?>