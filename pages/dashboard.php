<?php
include('../header.php');
require_once '../services/include/APIHandler.php';
?>

<?php
$result = CallAPI('GET', 'map_user_module');
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

<section  class="bg-secondary">
    <div class="container">
        <p><?php echo $message; ?></p>
        <?php
        for ($counter = 0, $count_modules = count($result_array->user_modules); $counter < $count_modules; $counter++)
        {
            $user_module = $result_array->user_modules[$counter];
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . $user_module->link; ?>">
                    <i class="<?php echo $user_module->fa_icon; ?>" aria-hidden="true"></i>
                    <h3><?php echo $user_module->name; ?></h3>
                    <p><?php echo $user_module->description; ?></p>
                </a>
            </div>
        </div>
        <?php
        }
        ?>
        <!--<div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'flash/customizer.php' ?>">
                    <i class="fa fa-4x fa-cloud" aria-hidden="true"></i>
                    <h3>New Order</h3>
                    <p>Update your user account information from here</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/saved-orders.php' ?>">
                    <i class="fa fa-4x fa-save" aria-hidden="true"></i>
                    <h3>Saved Orders</h3>
                    <p>Update your user account information from here</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/profile.php' ?>">
                    <i class="fa fa-4x fa-edit" aria-hidden="true"></i>
                    <h3>Edit Profile</h3>                
                    <p>Update your user account information from here</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/cart.php' ?>">
                    <!--<img src="../images/pass-icon.png" alt="">--
                    <i class="fa fa-4x fa-shopping-cart" aria-hidden="true"></i>
                    <h3>Shopping Cart</h3>
                    <p>Update your user account information from here</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/designs.php' ?>">
                    <i class="fa fa-4x fa-cloud" aria-hidden="true"></i>
                    <h3>View Designs</h3>
                    <p>View your designs and add/edit them here.</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/templates.php' ?>">
                    <i class="fa fa-4x fa-cloud" aria-hidden="true"></i>
                    <h3>View Templates</h3>
                    <p>View your templates and add/edit them here.</p>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . 'pages/themes.php' ?>">
                    <i class="fa fa-4x fa-cloud" aria-hidden="true"></i>
                    <h3>View Themes</h3>
                    <p>View your themes and add/edit them here.</p>
                </a>
            </div>
        </div>-->
    </div>
</section>

<?php include('../footer.php'); ?>

<style type="text/css">
    
    .module-block {
        background: #fff;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 1px 1px 1px #d9d9d9;
    }
    
    .module-block.center {
        text-align: center;
        min-height: 260px;
    }
    
    .module-block img {
        margin-bottom: 0;
    }
    
    .module-block.center h3 {
        text-align: center;
        padding: 0;
        margin-bottom: 15px;
        padding: 15px 0;
    }
    
    .module-block h3 {
        color: #4e4e4e;
    }
    
    .module-block h3 {
        position: relative;
        padding: 6px 0 6px 50px;
        line-height: 30px;
    }
    
    .module-block.center p {
        text-align: center;
    }
    
    .body-wrap p {
        line-height: 22px;
        margin-bottom: 20px;
        color: #939393;
    }
    
    .module-block p {
        margin-bottom: 0 !important;
    }
    
    .module-block.center h3::after {
         background-color: #CFEFA8;
        content: '';
        position: absolute;
        left: 50%;
        top: calc(50% + 30px);
        height: 4px;
        border-radius: 2px;
        width: 20px;
        -webkit-transform: translateX(-50%) translateY(-50%) scaleX(1);
        -ms-transform: translateX(-50%) translateY(-50%) scaleX(1);
        transform: translateX(-50%) translateY(-50%) scaleX(1);
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
    }
    .module-block.center:hover h3::after {
        -webkit-transform: translateX(-50%) translateY(-50%) scaleX(2);
        -ms-transform: translateX(-50%) translateY(-50%) scaleX(2);
        transform: translateX(-50%) translateY(-50%) scaleX(2);
        width: 40px;
    }

    
</style>