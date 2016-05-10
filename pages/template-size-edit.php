<?php
include('../header.php');
require_once '../services/include/APIHandler.php';


$edit_mode = false;
$data = [];
$template_size_id = 0;
$template_size_name = '';
$template_size_description = '';
$template_size_width = 0;
$template_size_height = 0;
$template_size_image_path = '';

if (isset($_GET['id']) && ($_GET['id']) > 0)
{
    $template_size_id = $_GET['id'];
    $page_title = 'Edit Template Size';
    $edit_mode = true;
}
else
{
    $template_size_id = 0;
    $page_title = 'Add Template Size';
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
    //$template_size_id = $_GET['id'];// Has been set above
    $template_size_name = filter_var($_POST['template_size_name'], FILTER_SANITIZE_STRING);
    $template_size_description = filter_var($_POST['template_size_description'], FILTER_SANITIZE_STRING);
    $template_size_width = $_POST['template_size_width'];
    $template_size_height = $_POST['template_size_height'];
    $template_size_image_path = filter_var($_POST['template_size_image_path'], FILTER_SANITIZE_STRING);
    
    if ($template_size_image_path == '')
    {
        // Set this to something default here.
        $template_size_image_path = 'app/images/theme/business-card.jpg';
    }
    
    $data = [];    
    $data['template_size_id'] = $template_size_id;
    $data['template_size_name'] = $template_size_name;
    $data['template_size_description'] = $template_size_description;
    $data['template_size_width'] = $template_size_width;
    $data['template_size_height'] = $template_size_height;
    $data['image_path'] = $template_size_image_path;
    
    $result = CallAPI('POST', 'template_size', $data);
    $result_array = json_decode($result);
    $message = $result;
}
else
{
    if ($template_size_id > 0)
    {       
        $data['template_size_id'] = $template_size_id;

        $result = CallAPI('GET', 'template_size', $data);
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
                
                $template_size_name = $result_array->themes[0]->name;
                $template_size_description = $result_array->themes[0]->description;
                $template_size_image_path = $result_array->themes[0]->image_path;
                
                $message = $template_size_image_path;
            }
        }
        else
        {
            $message = 'There is some problem while fetching the data.';
        }
    }
    else
    {
        $message = 'This is a new theme.';
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
                    <label class="sr-only" for="form-template-size-name">Template Size Name</label>
                    <input type="text" name="template_size_name" placeholder="Template Size Name..." class="form-control" value="<?php echo $template_size_name; ?>"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-template-size-description">Template Size Description</label>
                    <textarea type="text" name="template_size_description" placeholder="Give the template size a description..." class="form-control"><?php echo $template_size_description ?></textarea>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-template-size-width">Template Size Width</label>
                    <input type="number" name="template_size_width" placeholder="Give the theme a description..." class="form-control" value="<?php echo $template_size_width; ?>"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-template-size-height">Template Size Height</label>
                    <input type="number" name="template_size_height" placeholder="Give the theme a description..." class="form-control" value="<?php echo $template_size_height; ?>"/>
                </div>
            </div>
            <div id="image-part" class="col-lg-6">
                <div class="full-width">
                    <input type="file" name="upload"/>
                    <input name="template_size_image_path" value="<?php echo base_url() . $template_size_image_path ?>" class="form-control" readonly/>
                </div>
                <img id="image" src="<?php echo base_url() . $template_size_image_path ?>"/>
            </div>
        </div>
    </form>
</section>
<?php include('../footer.php'); ?>