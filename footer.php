
</div>
    <div class="clear"></div>
    <br><br>
    <footer id="footer" role="contentinfo" class="footer container-fluid">
        <div class="container">
            <div class="row"  align="center">
                <div class="col-md-4">
                                    <a class="navbar-brand" href="<?php echo get_home_url(); ?>">
                                        <?php $thelogo = get_option( 'logo' );
                                            if($thelogo){
                                                echo '<img alt="Brand" src="'.$thelogo.'" height="100%">';
                                            }else{
                                                echo '<img alt="Brand" src="'.get_template_directory_uri().'/images/logomin.png" height="100%">';
                                            }
                                        ?>
                                        </a>
                </div>
                <div class="col-md-4 hidden-sm hidden-xs">
                    <address>
                      <strong>MyAppSoftware, S.A.</strong><br>
                      6a. Av. 7-39, Zona 10. Edif. Las Brisas, Of. 401 "A"<br>
                      Guatemala, Guatemala 01010<br>
                      <abbr title="Phone">T:</abbr> (502) 5555-5555
                    </address>

                    <address>
                      <strong>Contactenos</strong><br>
                      <a href="mailto:hola@myappsoftware.com">hola@myappsoftware.com</a>
                    </address>
                </div>
                <div class="col-md-4">                                    
                    <?php $fb = get_option( 'facebook_url' );?>
                    <a href="<?php echo $fb?$fb:'https://www.facebook.com/Myappsoftware-460703957463259';?>" target="_blank"><img alt="Facebook" src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" height="35px"></a>
                    <br>
                    <br>
                    <?php $tw = get_option( 'twitter_url' );?>
                    <a href="<?php echo $tw?$tw:'https://twitter.com/myappsoftware';?>" target="_blank"><img alt="Twitter" src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" height="35px"></a>
                </div>                  
            </div>       
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>

<script>

$(document).ready(function(){
  $(".owl-carousel").owlCarousel({
    loop:true,
    margin:10,
    autopay: true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:5,
            loop:true
        }
    }      
      
  }); 
});
$(".owl-carousel-control-back").click(function(event){
    event.preventDefault();
    var rel = $(this).attr( "rel" );
    //alert(rel);
    var owl = $("#"+rel).data('owlCarousel');;
    owl.prev();
});  
$(".owl-carousel-control-next").click(function(event){
    event.preventDefault();
    var rel = $(this).attr( "rel" );
    //alert(rel);
    var owl = $("#"+rel).data('owlCarousel');;
    owl.next();
}); 

        function ajax_loading(){            
            $("#ajax_loader").modal({
                backdrop: 'static'
            });
        }
        function ajax_end(){
            $("#ajax_loader").modal('hide')
        }
	function show_message(where, message){
		$("#"+where).text(message);
		$("#"+where).show("fast");
		setTimeout(function(){$("#"+where).hide("fast");},5000)
	}
	$("#search_form").submit(function(){		
		var text = document.getElementById("search_text").value;
		if(text == ""){
			event.preventDefault();			
		}
	});
	
	
	function ajax_(action, data, update, dest){
                ajax_loading();
		$.ajax({
		  async:false, 
		  cache:false,
		  dataType:"html", 
		  type: 'POST',   
		  url: "<?php echo get_variable("ajax");?>",
		  data: "action="+ action + data, 
		  success:  function(respuesta){				
			if(update){
				if(dest==""){
					location.reload();
				}else{
					
					 window.location.assign(dest);
				}
				
			}else if(dest!=""){
                $("#"+dest).val(respuesta);
			}
			ajax_end();
		  },
		  beforeSend:function(){                      
			
		  },
		  error:function(objXMLHttpRequest){$("#"+dest).val("Error...");ajax_end();console.log(objXMLHttpRequest);}
		});
		
	}
	function ajax_async(action, data, update, dest){		
		$.ajax({
		  async:true, 
		  cache:false,
		  dataType:"html", 
		  type: 'POST',   
		  url: "<?php echo get_variable("ajax");?>",
		  data: "action="+ action + data, 
		  success:  function(respuesta){				
			if(update){
				if(dest==""){
					location.reload();
				}else{
					
					 window.location.assign(dest);
				}
				
			}else if(dest!=""){	
				document.getElementById(dest).innerHTML="";		
				document.getElementById(dest).innerHTML=respuesta;
			}
			$("#"+dest).removeClass("ajax_loader");
		  },
		  beforeSend:function(){
                        $("#"+dest).html("");
			$("#"+dest).addClass("ajax_loader");
		  },
		  error:function(objXMLHttpRequest){$("#"+dest).removeClass("ajax_loader");console.log(objXMLHttpRequest);}
		});
		
	}
</script>