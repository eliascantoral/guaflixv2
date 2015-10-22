<input type="hidden" id="current" value="">
<div id="canvasplayer" align="center">
    
                        <link href="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
                    <link href="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/circle.skin/circle.player.css" rel="stylesheet" type="text/css" >
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/jquery.jplayer.min.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/jquery.jplayer.inspector.min.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/jquery.transform2d.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/jquery.grab.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/mod.csstransforms.min.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/circle.player.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/circle/prettify-jPlayer.js"></script>      
                    <div id="video-controller" class="row">
                        <div class="col-md-3">
                            <a href="<?php echo $objectlink;?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/back.png">
                            </a>                            
                        </div>
                        <div class="col-md-6" id="video-controller-back">
                            <h2><?php echo $title;?></h2>
                        </div>
                        <div class="col-md-3"></div>
                    </div>    

                    

			<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
			<div id="jquery_jplayer_1" class="cp-jplayer"></div>

			<!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

			<div id="cp_container_1" class="cp-container">
				<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
					<div class="cp-buffer-1"></div>
					<div class="cp-buffer-2"></div>
				</div>
				<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
					<div class="cp-progress-1"></div>
					<div class="cp-progress-2"></div>
				</div>
				<div class="cp-circle-control"></div>
				<ul class="cp-controls">
					<li><a class="cp-play" tabindex="1">play</a></li>
					<li><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
				</ul>
			</div>                   
                    
                    

                    
                    
 
</div>


<script>
        var controlvisible = false;
        var mousex=0;
        var mousey=0;
        var mousexp=0;
        var mouseyp=0;
	var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
	{
		m4a: "<?php echo $url;?>"
	}, {
		cssSelectorAncestor: "#cp_container_1",
                canplay: function() {
                   $("#jquery_jplayer_1").jPlayer("play");
                },                
		swfPath: "../dist/jplayer",
		wmode: "window",
		keyEnabled: true
	});
        $("#jp_container_1").mousemove(function(event){
                mousex = event.clientX;
                mousey = event.clientY;
                $("#video-controller").show("slow");
                controlvisible = true;                
            }
        );
        var thetimer = setInterval(myTimer, 4000);
        function myTimer() {
            var d = new Date();
            if(controlvisible && (mousexp == mousex) && (mouseyp == mousey)){
                $("#video-controller").hide("slow");
                controlvisible = false; 
            }
            mousexp = mousex;
            mouseyp = mousey;  
            $("#current").val( $("#jquery_jplayer_1").data("jPlayer").status.currentTime);
        }
</script>