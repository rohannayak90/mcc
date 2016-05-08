<?php 
include('../header.php');
require_once '../services/include/APIHandler.php';
?>

<?php
$result = CallAPI('GET', 'design');
$result_array = json_decode($result);
$message = $result;

if ($result_array)
{
    if (isset($result_array->error) && $result_array->error == 1)
    {
        $message = $result_array->message;
    }
    else
    {
        $message = 'Data fetching successful.';
        //$message = $result_array;
    }
}
else
{    
    //$message = 'There is some problem while fetching the data.';
}
?>

<section class="bg-secondary">
    <div class="container">
        <h2 class="text-center">All Your Designs</h2>        
        <p><?php echo $message; ?></p>
    </div>
    <div>
        <input type="text" name="search" placeholder="Search..." class="form-control">
        <a href="design-edit.php" class="btn btn-primary btn-xl">ADD NEW</a>
    </div>
    <div id="showcase" class="container">
        <div class="grid">
        <?php
        //print_r($result_array);
        for ($counter = 0, $count_images = count($result_array->designs); $counter < $count_images; $counter++)
        {
            ?>
            
					<figure class="effect-lily col-md-3 col-sm-6">
						<img src="<?php echo $result_array->designs[$counter]->image_path; ?>" alt="img12"/>
						<figcaption>
							<div>
								<h2><?php echo $result_array->designs[$counter]->name; ?></h2>
								<p><?php echo $result_array->designs[$counter]->description; ?></p>
							</div>
							<a href="design-edit.php?id=<?php echo $result_array->designs[$counter]->id; ?>">View more</a>
						</figcaption>			
					</figure>
            
            <?php
        }
        ?>
            </div>
    </div>
</section>
<style type="text/css">
     .grid {
	position: relative;
	margin: 0 auto;
	padding: 1em 0 4em;
	max-width: 1000px;
	list-style: none;
	text-align: center;
}

/* Common style */
.grid figure {
	position: relative;
	float: left;
	overflow: hidden;
	margin: 10px 1%;
	min-width: 320px;
	max-width: 480px;
	max-height: 360px;
	width: 48%;
	background: #3085a3;
	text-align: center;
	cursor: pointer;
}

.grid figure img {
	position: relative;
	display: block;
	min-height: 100%;
	max-width: 100%;
	opacity: 0.8;
}

.grid figure figcaption {
	padding: 2em;
	color: #ff0000;
	text-transform: uppercase;
	font-size: 1.25em;
	-webkit-backface-visibility: hidden;
	backface-visibility: hidden;
}

.grid figure figcaption::before,
.grid figure figcaption::after {
	pointer-events: none;
}

.grid figure figcaption,
.grid figure figcaption > a {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

/* Anchor will cover the whole item by default */
/* For some effects it will show as a button */
.grid figure figcaption > a {
	z-index: 1000;
	text-indent: 200%;
	white-space: nowrap;
	font-size: 0;
	opacity: 0;
}

.grid figure h2 {
	word-spacing: -0.15em;
	font-weight: 300;
}

.grid figure h2 span {
	font-weight: 800;
}

.grid figure h2,
.grid figure p {
	margin: 0;
}

.grid figure p {
	letter-spacing: 1px;
	font-size: 68.5%;
}

/* Individual effects */

/*---------------*/
/***** Lily *****/
/*---------------*/

figure.effect-lily img {
	max-width: none;
	width: -webkit-calc(100% + 50px);
	width: calc(100% + 50px);
	opacity: 0.7;
	-webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
	transition: opacity 0.35s, transform 0.35s;
	-webkit-transform: translate3d(-40px,0, 0);
	transform: translate3d(-40px,0,0);
}

figure.effect-lily figcaption {
	text-align: left;
}

figure.effect-lily figcaption > div {
	position: absolute;
	bottom: 0;
	left: 0;
	padding: 2em;
	width: 100%;
	height: 50%;
}

figure.effect-lily h2,
figure.effect-lily p {
	-webkit-transform: translate3d(0,40px,0);
	transform: translate3d(0,40px,0);
}

figure.effect-lily h2 {
	-webkit-transition: -webkit-transform 0.35s;
	transition: transform 0.35s;
}

figure.effect-lily p {
	/*color: rgba(255,255,255,0.8);*/
	opacity: 0;
	-webkit-transition: opacity 0.2s, -webkit-transform 0.35s;
	transition: opacity 0.2s, transform 0.35s;
}

figure.effect-lily:hover img,
figure.effect-lily:hover p {
	opacity: 1;
}

figure.effect-lily:hover img,
figure.effect-lily:hover h2,
figure.effect-lily:hover p {
	-webkit-transform: translate3d(0,0,0);
	transform: translate3d(0,0,0);
}

figure.effect-lily:hover p {
	-webkit-transition-delay: 0.05s;
	transition-delay: 0.05s;
	-webkit-transition-duration: 0.35s;
	transition-duration: 0.35s;
}
</style>
<?php include('../footer.php'); ?>