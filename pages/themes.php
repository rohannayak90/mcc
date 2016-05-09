<?php 
include('../header.php');
require_once '../services/include/APIHandler.php';
?>

<?php
$result = CallAPI('GET', 'theme');
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
    $message = 'There is some problem while fetching the data. ' . $result;
}
?>

<link rel="stylesheet" href="<?php echo base_url() . 'css/showcase.css'?>" type="text/css">

<section class="bg-secondary">
    <div class="container">
        <h2 class="text-center">All Your Themes</h2>        
        <p><?php echo $message; ?></p>
    </div>
    <div class="container">
        <input type="text" name="search" placeholder="Search..." class="form-control col-md-10">
        <a href="theme-edit.php" class="btn btn-primary btn-xl pull-right">ADD NEW</a>
    </div>
    <div id="showcase" class="container">
        <div class="grid">
        <?php
        //print_r($result_array);
        for ($counter = 0, $count_images = count($result_array->themes); $counter < $count_images; $counter++)
        {
            $theme = $result_array->themes[$counter];
            ?>
            <figure class="effect-lily col-md-3 col-sm-6">
                <img src="<?php echo base_url() . $theme->image_path; ?>" alt="img12"/>
                <figcaption>
                    <div>
                        <h2><?php echo $theme->name; ?></h2>
                        <p><?php echo $theme->description; ?></p>
                    </div>
                    <a href="theme-edit.php?id=<?php echo $theme->id; ?>">View more</a>
                </figcaption>			
            </figure>
            
            <?php
        }
        ?>
            </div>
    </div>
</section>