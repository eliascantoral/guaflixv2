<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<input type="hidden" id="singleojbectajax">
<script>
    $(".objectplay").click(function(){
        $("#object-container").hide("fast");
        $("#object-play").show("fast");
        //ajax_async("201", "&objectid=<?php echo $post->ID;?>", false, "object-play");
        ajax_("201", "&objectid=<?php echo $post->ID;?>", false, "singleojbectajax");
        var content = $("#singleojbectajax").val();
        //alert(content);
        $("#object-play").html(content);               
    });
</script>