<?php

function front($title) {
    
	include 'front.php';
	
	define("DB_HOST", "localhost");     // Define MySQL hostname (usually localhost)
	define("DB_NAME", "dbName");        // Define the database name
	define("DB_USER", "dbUsername");    // Define the username to access the database
	define("DB_PASS", "cbPassword");    // Define the password to access the database
	
}

function slider() {

//--Values that can be edited-----------------------------------------------

$pause = 6;  // time that each slide stands still (is paused - in seconds)
$slide = 1.5; // animation/slide time (in seconds)
$duration = $pause + $slide;  // total animation time (pause+slide times)
    
//------------------Retrieve the slides from the database-------------------
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Status defined for active or inactive slides - order defined for ability to change slide display order
$sql = "SELECT * FROM slider WHERE status='1' ORDER BY `order` asc";  
$result = mysqli_query($conn, $sql);

$num_slides = mysqli_num_rows($result);  // Counts the number of slides in database
$full_width = ($num_slides + 1) * 100;  // Calculate the percentage width of all active images side by side (ex. 4 slides +1 is 500%)
$loops = ($num_slides * 2) + 1;  // Calculate number of loops to print out keyframes

$animation_time = round( ($num_slides * $duration), 1 );  // Total animation time for all slides
$pause_inc = round( (($pause / $animation_time) * 100), 1 );  // Calculate the percentage increment for the pause animation based on number of slides
$slide_inc = round( (($slide / $animation_time) * 100), 1 );  // Calculate the percentage increment for the slide animation based on number of slides
$bg_size = round ( (100 / ($num_slides +1 )), 4 );  // Calculate the percentage width of a single slide
	
//------------------STYLE---------------------------------------------------
	?>
<style>
		
@keyframes slidy { <?php

	$step = 0;
	$movement = 0;
	echo "\n";    
    
	// Loop to print out each line of the keyframes based on the number of slides in the animation
	for ( $s=0; $s<$loops; $s++ ) {
		
		if ( $s == ($loops-1) ) { $step = 100; }
		
		echo $step . '% { left: ' . $movement . '%; }';
		echo "\n";				
		
		if ( $s % 2 ) { $step += $slide_inc; $movement -= 100; }
		else { $step += $pause_inc; }
	} ?>
}
	
	
@-webkit-keyframes slidy {<?php

	$step = 0;
	$movement = 0;
	echo "\n";
	
    // Loop to print out each line of the keyframes based on the number of slides in the animation
	for ( $s=0; $s<$loops; $s++ ) {
		
		if ( $s == ($loops-1) ) { $step = 100; }
		
		echo $step . '% { left: ' . $movement . '%; }';
		echo "\n";				
		
		if ( $s % 2 ) { $step += $slide_inc; $movement -= 100; }
		else { $step += $pause_inc; }
	} ?>
}
	
div#slider figure { 
	position: relative;
	width: <?=$full_width?>%;
	margin: 0;
	left: 0;
	text-align: center;
	font-size: 20px;
	animation: <?=$animation_time?>s slidy ease-in-out infinite;
	-webkit-animation: <?=$animation_time?>s slidy ease-in-out infinite;
}

div#slider figure div.bg {
	width: <?=$bg_size?>%;
	height: 700px;
	float: left;	
	background-repeat: no-repeat !important;
	background-position: center !important;
}

</style>
	<?php
	
//--------------------------------------------------------------------------------------------------------------------------------------------
	
	$z=0;
    ?>
    <section class="content1">   
    <div class="back">
		
		
		<div id="slider">		
			<figure>				
				<?php while ( $row = mysqli_fetch_assoc($result) ) {
					if ($z==0) {  // Save the info for the first slide to also print it as the last slide for smooth transition
						$image2 = $row['image'];            // Slider Image (filename)
						$title = $row['title'];             // Caption Title
						$description = $row['description']; // Caption Description
						$button = $row['button'];           // Caption Button (not always visable)
						$link = $row['link'];               // Button Link
						$action1 = "href='$link'";
						
						$z++;
					}
					$image = $row['image'];
					$link = $row['link'];
					$action = "href='$link'";
					
                    //-----------------html Printout for each slide---------------------------------------------------------------
					?>
					<div class="bg" style="background: url('images/slider/<?=$image?>');">  <!--  Location defined for images -->
						<div class="slideInfo">
							<h1><?=$row['title']?></h1>
							<?=$row['description']?>
                                <!--if button is not defined in the database...  It will not be displayed-->
								<a <?=$action?>><div <?php if ( $row['button'] == "" ) { echo "style='visibility: hidden;'"; } ?> class="slideButton"><?=$row['button']?></div></a>							
						</div>						
					</div>                    
                    <?php
                    //------------------------------------------------------------------------------------------------------------
                    
                }
                
                //-----------------html Printout for last slide (same as the first slide for animation reset)---------------------
                
                ?>				
				<div class="bg" style="background: url('images/slider/<?=$image2?>');">  <!--  Location defined for images -->
                    <div class="slideInfo">
                        <h1><?=$title?></h1>
                        <?=$description?>						
							<a <?=$action1?>><div <?php if ( $button == "" ) { echo "style='visibility: hidden;'"; } ?> class="slideButton"><?=$button?></div></a>						
                    </div>
                </div>
                
                //----------------------------------------------------------------------------------------------------------------
			</figure>
		</div>
	</div>    
	</section>
    <?php
}

function back() {
	include 'back.php';
}


?>