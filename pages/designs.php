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
    $message = 'There is some problem while fetching the data. ' . $result;
}
?>

<link rel="stylesheet" href="<?php echo base_url() . 'css/showcase.css'?>" type="text/css">

<section class="bg-secondary">
    <div class="container">
        <h2 class="text-center">Your Designs</h2>        
        <p><?php echo $message; ?></p>
    </div>
    <div class="container">
        <input type="text" name="search" placeholder="Search..." class="col-md-10">
        <a href="design-edit.php" class="btn btn-primary btn-xl pull-right">ADD NEW</a>
    </div>
    <div id="showcase" class="container">
        <div class="grid">
        <?php
        //print_r($result_array);
        for ($counter = 0, $count_images = count($result_array->designs); $counter < $count_images; $counter++)
        {
            $design = $result_array->designs[$counter];
            ?>
            
            <figure class="effect-lily col-md-3 col-sm-6">
                <img src="<?php echo base_url() . $design->image_path; ?>" alt="img12"/>
                <figcaption>
                    <div>
                        <h2><?php echo $design->name; ?></h2>
                        <p><?php echo $design->description; ?></p>
                    </div>
                    <a href="design-edit.php?id=<?php echo $design->id; ?>">View more</a>
                </figcaption>
            </figure>
            
            <?php
        }
        ?>
            </div>
    </div>
</section>

<?php include('../footer.php'); ?>