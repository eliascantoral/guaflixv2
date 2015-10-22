<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
Template Name: Ajax page
*/
//var_dump($_POST);
    if(isset($_POST["action"])){
        switch ($_POST["action"]){
            case "0":{//Login
                if(isset($_POST["user"]) && isset($_POST["pass"])){
                    include_once 'function/logic.php';
                    $result = try_login($_POST["user"], $_POST["pass"]);
                    if($result){
                        echo json_encode(array('r'=>1,'d'=>$result));
                    }else{
                        echo json_encode(array('r'=>0,'d'=>"Usuario o contraseña incorrectos."));
                        
                    }
                }
                break;}
            case "1":{////Change pass
                if(isset($_POST["old"]) && isset($_POST["new"])){
                    include_once 'function/logic.php';
                    $result = user_changepassword($_POST['old'], $_POST['new']);
                    if($result[0]){
                        echo json_encode(array('r'=>1,'d'=>$result[1]));
                    }else{
                        echo json_encode(array('r'=>0,'d'=>"No se pudo modificar la contraseña. ". $result[1]));
                    }
                }
                break;}
                
            case "101":{//////user object progress 
                if(isset($_POST["userid"]) && isset($_POST["courseid"])){
                    include_once 'functions/logic.php';
                    $userlog = get_userobjectlog($_POST['userid'], $_POST['courseid']);
                    if($userlog[0]){
                        //var_dump($userlog);
                        ?>
<table class="table table-striped table-hover table-responsive">
    <thead>
        <tr>
            <td>No.</td>
            <td>Fecha Hora</td>           
            <td>Descripci&oacute;n</td>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0;$i<sizeof($userlog[1]);$i++){?>
            <tr>
                <td><?php echo $i+1;?></td>
                <td><?php echo date("d/m/Y G:i:s",$userlog[1][$i]['time']);?></td>
                <td><?php $description = json_decode($userlog[1][$i]['description']);
                    echo "Acción ".$description->a." en posici&oacute;n ".$description->p;
                ?></td>
            </tr>       
        <?php }?>     
    </tbody>
</table>
                            <?php
                    }else{
                        echo "Error. Por favor intente nuevamente.";
                    }
                }
                break;}
            case "102":{//////get user data....
                if(isset($_POST["userid"]) && isset($_POST["courseid"])){
                    include_once 'functions/logic.php';
                    $users = explode(",", $_POST["userid"]);
                    $userlist = array();
                    for($i=0;$i<sizeof($users);$i++){
                        $userdata = get_useralldata($users[$i]);
                        if($userdata[0]){
                            array_push($userlist, $userdata[1]);
                        }                        
                    }   
                    $arraymail = "";
                    ?>
<form id="mailform-object" class="form-horizontal">
    <div class="form-group">
        <label class="col-md-2 control-label">Usuario(s)</label>
        <div class="col-md-10">          
            <textarea  class="form-control" disabled="true"><?php for($i=0;$i<sizeof($userlist);$i++){
                                                                            echo $userlist[$i][0]."(".$userlist[$i][2]."), ";
                                                                            $arraymail.=$userlist[$i][3].","; 
                                                            }?></textarea>
            <input type="hidden" id="maillist" value="<?php echo $arraymail;?>">            
        </div>        
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="mailmessage">Mensaje</label>
        <div class="col-md-10">
            <textarea  class="form-control"id="mailmessage"></textarea>
        </div>
    </div>
</form>
                        <?php
                }
                break;}
            case "103":{////send mail consumo de ses
                
                break;}
            case "104":{//// get user name
                    if(isset($_POST["userid"]) && isset($_POST["courseid"])){
                        include_once 'functions/logic.php';
                        $users = explode(",", $_POST["userid"]);
                        $userlist = array();
                        for($i=0;$i<sizeof($users);$i++){
                            $userdata = get_useralldata($users[$i]);
                            if($userdata[0]){
                                array_push($userlist, $userdata[1]);
                            }                        
                        }
                        for($i=0;$i<sizeof($userlist);$i++){
                            echo $userlist[$i][0]."(".$userlist[$i][2]."), ";
                        }                        
                    }
                break;}
            case "105":{//// get user name
                    if(isset($_POST["userid"]) && isset($_POST["courseid"])){
                        include_once 'functions/logic.php';
                        if(unsubscribe_user_object($_POST['userid'], $_POST['courseid'])){
                            echo json_encode(array('r'=>1,'d'=>"Se a dado de baja al usuario."));
                        }else{
                            echo json_encode(array('r'=>1,'d'=>"Ocurrio un error, por favor intente nuevamente."));
                        }
                    }
                break;}
/****************************************************************************************************************************/                
            case "201":{//////play object
                if(isset($_POST["objectid"])){
                    include_once 'functions/logic.php';
                    ?>
                        <div id="canvasplayer" align="center">
                            <?php 
                            $post_id = $_POST["objectid"];
                            $wowza_server = get_field("servidor_wowza","option");
                            $url = get_field("video",$post_id);
                            $url = $url['url'];
                            //$url = str_replace("http://","",$url);
                            //$url = str_replace("https://","",$url);
                            //$url="rtmp://".$wowza_server.":1935/vods3/mp4:amazons3/".$url;
                            $array = explode('.', $url);
                            $extension = end($array);
                            $title = get_the_title($post_id);
                            $objectlink = get_permalink ($post_id);
                            switch($extension){
                                case 'mp4':{include_once("videoplayer/video.php");break;}
                                case 'mp3':{include_once("videoplayer/audio.php");break;}
                            }
                            ?>
                        </div>                        
                        <?php
                }
            }
            case "202":{
                if(isset($_POST["objectid"]) && isset($_POST["time"])){
                    
                }
            }
        }
    }


?>
