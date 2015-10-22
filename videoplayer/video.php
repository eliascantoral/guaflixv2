<input type="text" id="current" value="">
<div id="canvasplayer" align="center">
    <link href="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/style/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/lib/jquery.min.js">
    </script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
                    <div id="video-controller" class="row message">
                        <div class="col-md-3">
                            <a href="<?php echo $objectlink;?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/back.png">
                            </a>                            
                        </div>
                        <div class="col-md-6" id="video-controller-back">
                        </div>
                        <div class="col-md-3"></div>
                    </div>     
    <div id="jp_container_1" class="jp-video jp-video-full" role="application" aria-label="media player" align="left">
            <div class="jp-type-single">
                    <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                    <div class="jp-gui">
                            <div class="jp-interface">
                                    <div class="jp-progress" id="progressbar">
                                            <div class="jp-seek-bar">
                                                    <div class="jp-play-bar"></div>
                                            </div>
                                    </div>
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                <div class="jp-controls-holder">
                                    <div class="jp-controls">
                                        <button class="jp-play" role="button" tabindex="0">play</button>
                                        <button class="jp-stop" role="button" tabindex="0">stop</button>
                                    </div>
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" role="button" tabindex="0">mute</button>
                                        <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                        <div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div>
                                    </div>
                                    <div class="jp-toggles">
                                        <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                        <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                    </div>
                                </div>
                                <div class="jp-details"><div class="jp-title" aria-label="title">&nbsp;</div></div>
                            </div>
                    </div>
                    <div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank"> Flash plugin</a>.</div></div>
    </div>   
    
</div>


<script>
        var controlvisible = false;
        var mousex=0;
        var mousey=0;
        var mousexp=0;
        var mouseyp=0;
	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				title: "<?php echo $title;?>",
				m4v: "<?php echo $url;?>"
			}).jPlayer("play");
		},
		swfPath: "<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/dist/jplayer",
		supplied: "webmv, ogv, m4v",
		size: {
			width: "100%",
			height: "100%",
			cssClass: "jp-video-full"
		},
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
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