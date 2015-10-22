<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $userlist =  get_objectuser($post->ID);
    
   ?>
<div class="alert alert-success message" id="okmessage-objectadmin" role="alert"></div>
    <div class="alert alert-danger message" id="nokmessage-objectadmin" role="alert"></div>
    <input type="hidden" id="answer-message-objectadmin">
    <h3>Lista de usuarios</h3>
    <button type="button" class="btn btn-success">Agregar</button>
    <button type="button" class="btn btn-danger" disabled="disabled">Eliminar</button>
    <button type="button" class="btn btn-info" disabled="disabled">Enviar correo</button>
    <button type="button" class="btn btn-default">Resumen</button>
    <br><br>
    <table class="table table-bordered table-hover">
        <thead>
            <tr align="center">
                <td>No</td>
                <td>Nombre</td>
                <td>Metodo de acceso</td>
                <td>Fecha de acceso</td>
                <td>Fecha finaliza</td>
                <td>Controles</td>
            </tr>
        </thead>
        <tbody>
            <?php for($i=0;$i<sizeof($userlist[1]);$i++){?>
            <tr>
                <td><?php echo $i+1;?></td>
                <td><?php echo $userlist[1][$i]['fname']." ".$userlist[1][$i]['lname'];?></td>
                <td><?php echo $userlist[1][$i]['paymethod'];?></td>
                <td><?php echo date("d/m/Y G:i:s",$userlist[1][$i]['paytime']);?></td>
                <td><?php echo $userlist[1][$i]['timedead']!=0? date("d/m/Y G:i:s",$userlist[1][$i]['timedead']):"-";?></td>
                <td align="center">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <a href="#" class="progressuser" rel="<?php echo $userlist[1][$i][0]?>"><img src="<?php echo get_template_directory_uri(); ?>/images/progress.png" width="25px" title="Progreso de usuario"></a>
                            <a href="#" class="mailuser" rel="<?php echo $userlist[1][$i][0]?>"><img src="<?php echo get_template_directory_uri(); ?>/images/email.png" width="25px" title="Enviar correo"></a>
                            <a href="#" class="deleteuser" rel="<?php echo $userlist[1][$i][0]?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" width="25px" title="Eliminar subscripción"></a>
                        </div>
                    </form>
                    
                </td>
            </tr>
            <?php }?>
        </tbody>
        <tfoot></tfoot>
    </table>
<!--------Progress Modal--------->    
    <div id="progressmodal" class="modal fade">
     <div class="modal-dialog modal-lg"">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title">Progreso</h4>
         </div>
         <div class="modal-body" id="progressmodal-container">
           
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->   

<!--------Message modal--------->    
    <div id="messagemodal" class="modal fade">
     <div class="modal-dialog modal-lg"">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title">Progreso</h4>
         </div>
         <div class="modal-body" id="messagemodal-container">
           
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-primary" data-dismiss="modal" id="formmail-send">Enviar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    
<!-------Delete modal------------>
<div id="deletemodal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">¿Dar de baja usuario?</h4>
      </div>
      <div class="modal-body">
          <p>¿Esta seguro que desea dar de baja al usuario <span id="deletemodal-container"></span>?</p>
      </div>
      <div class="modal-footer">
          <button type="button" id="deletemodal-button" class="btn btn-danger">Eliminar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>   
        <input type="hidden" id="deletemodal-userid" value="">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php //var_dump($userlist);?>

    <script>
        $(".progressuser").click(function(event){
            event.preventDefault();
            var user = $(this).attr("rel");
            ajax_async("101", "&userid="+user+"&courseid=<?php echo $post->ID;?>", false, 'progressmodal-container');
            $("#progressmodal").modal();
        });
        
        $(".mailuser").click(function(event){
            event.preventDefault();
            var user = $(this).attr("rel");
            ajax_async("102", "&userid="+user+"&courseid=<?php echo $post->ID;?>", false, 'messagemodal-container');
            
            $("#messagemodal").modal();
        });
        $("#formmail-send").click(function(event){
            event.preventDefault();
            var maillist = $("#maillist").val();
            var message = encodeURIComponent($("#mailmessage").val());
            ajax_async("103", "&maillist="+maillist+"&courseid=<?php echo $post->ID;?>"+"&message="+message, false, 'deletemodal-container');  
            
        });
        
        $(".deleteuser").click(function(event){
            event.preventDefault();
            var user = $(this).attr("rel");
            $("#deletemodal-userid").val(user);
            ajax_async("104", "&userid="+user+"&courseid=<?php echo $post->ID;?>", false, 'deletemodal-container');   
            $("#deletemodal").modal();
        });        
        $("#deletemodal-button").click(function(event){
            var user = $("#deletemodal-userid").val(user);
            ajax("105", "&userid="+user+"&courseid=<?php echo $post->ID;?>", false, 'answer-message-objectadmin'); 
            var answer = $("#answer-message-objectadmin").val();
            var obj = jQuery.parseJSON( answer );
            if( obj.r == 1 ){
                show_message('okmessage-objectadmin',obj.d);
            }else{
                show_message('nokmessage-objectadmin',obj.d);
            }
        });
    </script>
    
    