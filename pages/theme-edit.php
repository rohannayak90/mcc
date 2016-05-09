<?php
include('../header.php');
require_once '../services/include/APIHandler.php';


$edit_mode = false;
$data = [];
$theme_id = 0;
$theme_name = '';
$theme_description = '';
$theme_image_path = '';

if (isset($_GET['id']) && ($_GET['id']) > 0)
{
    $theme_id = $_GET['id'];
    $page_title = 'Edit Theme';
    $edit_mode = true;
}
else
{
    $theme_id = 0;
    $page_title = 'Add Theme';
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
    //$theme_id = $_GET['id'];// Has been set above
    $theme_name = filter_var($_POST['theme_name'], FILTER_SANITIZE_STRING);
    $theme_description = filter_var($_POST['theme_description'], FILTER_SANITIZE_STRING);
    $theme_image_path = filter_var($_POST['theme_image_path'], FILTER_SANITIZE_STRING);
    
    if ($theme_image_path == '')
    {
        // Set this to something default here.
        $theme_image_path = 'app/images/theme/business-card.jpg';
    }
    
    $data = [];    
    $data['theme_id'] = $theme_id;
    $data['theme_name'] = $theme_name;
    $data['theme_description'] = $theme_description;
    $data['image_path'] = $theme_image_path;
    
    $result = CallAPI('POST', 'theme', $data);
    $result_array = json_decode($result);
    $message = $result;
}
else
{
    if ($theme_id > 0)
    {       
        $data['theme_id'] = $theme_id;

        $result = CallAPI('GET', 'theme', $data);
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
                
                $theme_name = $result_array->themes[0]->name;
                $theme_description = $result_array->themes[0]->description;
                $theme_image_path = $result_array->themes[0]->image_path;
                
                $message = $theme_image_path;
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
                        <label class="sr-only" for="form-theme-name">Theme Name</label>
                        <input type="text" name="theme_name" placeholder="Theme Name..." class="form-control" value="<?php echo $theme_name; ?>"/>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="form-theme-description">theme Description</label>
                        <textarea type="text" name="theme_description" placeholder="Give the theme a description..." class="form-control"><?php echo $theme_description ?></textarea>
                    </div>

            </div>
            <div id="image-part" class="col-lg-6">
                <div class="full-width">
                    <input type="file" name="upload"/>
                    <input name="theme_image_path" value="<?php echo base_url() . $theme_image_path ?>" class="form-control" readonly/>
                </div>
                <img id="image" src="<?php echo base_url() . $theme_image_path ?>"/>
            </div>
        </div>
    </form>
</section>
<?php include('../footer.php'); ?>