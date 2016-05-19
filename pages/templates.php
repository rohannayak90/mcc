<?php

$page_title = 'Templates';
include('../header.php');
require_once('../services/include/APIHandler.php');
?>

<?php

$data = [];    
$data['template_id'] = 0;

$result = CallAPI('POST', 'get_template', $data);
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
        <h2 class="text-center">All Your Templates</h2>        
        <p><?php echo $message; ?></p>
    </div>
    <div class="container">
        <input type="text" name="search" placeholder="Search..." class="col-md-10">
        <a href="template-edit.php" class="btn btn-primary btn-xl pull-right">ADD NEW</a>
    </div>
    <div id="showcase" class="container">
        <div class="grid">
        <?php
        //print_r($result_array);
        for ($counter = 0, $count_images = count($result_array->templates); $counter < $count_images; $counter++)
        {
            $template = $result_array->templates[$counter];
            ?>
            
            <figure class="effect-lily col-md-3 col-sm-6">
				<img src="<?php echo base_url() . $template->image_path; ?>" alt="img12"/>
				<figcaption>
					<div>
						<h2><?php echo $template->name; ?></h2>
						<p><?php echo $template->description; ?></p>
					</div>
                    <a href="template-edit.php?id=<?php echo $template->id; ?>">View more</a>
				</figcaption>			
            </figure>
            
            <?php
        }
        ?>
        </div>
    </div>
</section>