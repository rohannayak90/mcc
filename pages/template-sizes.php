<?php 
include('../header.php');
require_once '../services/include/APIHandler.php';
?>

<?php
$result = CallAPI('GET', 'template_size');
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
        //$message = $result;//_array;
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
        <h2 class="text-center">All Your Template Sizes</h2>        
        <p><?php echo $message; ?></p>
    </div>
    <div class="container">
        <input type="text" name="search" placeholder="Search..." class="form-control col-md-10">
        <a href="template-size-edit.php" class="btn btn-primary btn-xl pull-right">ADD NEW</a>
    </div>
    <div id="showcase" class="container">
        <div class="grid">
        <?php
        //print_r($result_array);
        for ($counter = 0, $count_images = count($result_array->template_sizes); $counter < $count_images; $counter++)
        {
            $template_size = $result_array->template_sizes[$counter];
            ?>
            <figure class="effect-lily col-md-3 col-sm-6">
                <img src="<?php echo base_url() . $template_size->image_path; ?>" alt="img12"/>
                <figcaption>
                    <div>
                        <h2><?php echo $template_size->name; ?></h2>
                        <p><?php echo $template_size->description; ?></p>
                    </div>
                    <a href="themplate-size-edit.php?id=<?php echo $template_size->id; ?>">View more</a>
                </figcaption>			
            </figure>
            
            <?php
        }
        ?>
            </div>
    </div>
</section>

<?php include('../footer.php'); ?>