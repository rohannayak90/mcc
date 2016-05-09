<?php
include('../header.php');
require_once '../services/include/APIHandler.php';


$edit_mode = false;
$data = [];
$design_id = 0;
$design_name = '';
$design_description = '';
$design_image_path = '';

if (isset($_GET['id']) && ($_GET['id']) > 0)
{
    $design_id = $_GET['id'];
    $page_title = 'Edit Design';
    $edit_mode = true;
}
else
{
    $design_id = 0;
    $page_title = 'Add Design';
}

if (isset($_POST['upload']))
{
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $expensions= array("jpeg","jpg","png");
    
    if(in_array($file_ext,$expensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152){
        $errors[]='File size must be exactely 2 MB';
    }
    
    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"../app/images/".$file_name);
        echo "Success";
    }else{
        print_r($errors);
    }
}
else if (isset($_POST['save']))
{
    //$design_id = $_GET['id'];// Has been set above
    $design_name = filter_var($_POST['design_name'], FILTER_SANITIZE_STRING);
    $design_description = filter_var($_POST['design_description'], FILTER_SANITIZE_STRING);
    $design_image_path = filter_var($_POST['design_image_path'], FILTER_SANITIZE_STRING);
    
    if ($design_image_path == '')
    {
        // Set this to something default here.
        $design_image_path = '../app/images/design/business-card.jpg';
    }
    
    $data = [];    
    $data['design_id'] = $design_id;
    $data['design_name'] = $design_name;
    $data['design_description'] = $design_description;
    $data['image_path'] = $design_image_path;
    
    $result = CallAPI('POST', 'design', $data);
    $result_array = json_decode($result);
    $message = $result;
}
else
{
    if ($design_id > 0)
    {       
        $data['design_id'] = $design_id;

        $result = CallAPI('GET', 'design', $data);
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
                //$message = $result;
                
                $design_name = $result_array->designs[0]->name;
                $design_description = $result_array->designs[0]->description;
                $design_image_path = base_url() . $result_array->designs[0]->image_path;
            }
        }
        else
        {
            $message = 'There is some problem while fetching the data.';
        }
    }
    else
    {
        $message = 'This is a new design.';
    }
}


?>
<section class="bg-secondary">
    <form role="form" action="" method="post" class="login-form" enctype = "multipart/form-data">
        <div class="container">
            <h2 class="text-center"><?php echo $page_title; ?></h2>                        
        </div>
        <hr>
        <div class="container">
            <!--<a href="" class="btn btn-primary col-lg-2">SAVE CHANGES</a>-->
            <button type="submit" name="save" class="btn pull-right">SAVE CHANGES</button>
        </div>
        <div class="container">
            <p><?php echo $message; ?></p>
            <div id="form-part" class="col-lg-6">

                    <div class="form-group">
                        <label class="sr-only" for="form-design-name">Design Name</label>
                        <input type="text" name="design_name" placeholder="Design Name..." class="form-control" value="<?php echo $design_name; ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="form-design-description">Design Description</label>
                        <textarea type="text" name="design_description" placeholder="Give the design a description..." class="form-control"><?php echo $design_description ?></textarea>
                    </div>

            </div>
            <div id="image-part" class="col-lg-6">
                <div class="full-width">
                    <input type="file" name="upload"/>
                    <input name="design_image_path" value="<?php echo $design_image_path ?>" class="form-control" readonly/>
                </div>
                <img id="image" src="<?php echo $design_image_path ?>"/>
            </div>
        </div>
    </form>
</section>
<?php include('../footer.php'); ?>