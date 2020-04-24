<?php
    include ("ajax_config.php");
    $v_bang =  (string)magic_quote(trim(strip_tags($_POST['bang"'])));
    $v_type =  (string)magic_quote(trim(strip_tags($_POST['type'])));
    $v_value =  (string)magic_quote(trim(strip_tags($_POST['value'])));
    $v_id =  (int)$_POST['id'];
    if($v_id > 0){
        $d->reset();
        $d->setTable($v_bang);
        $d->setWhere("id", $v_id);
        $d->update(array($v_type = > $v_value));
        // echo $sql;
    }
?>
