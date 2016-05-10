<?php
include('../header.php');
require_once '../services/include/APIHandler';
?>

<?php
$result = CallAPI('GET', 'module');
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
        for ($counter = 0, $count_modules = count($result_array->modules); $counter < $count_modules; $counter++)
        {
            $module = $result_array->modules[$counter];
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="module-block center">
                <a href="<?php echo base_url() . $module->link; ?>">
                    <i class="<?php echo $module->fa_icon; ?>" aria-hidden="true"></i>
                    <h3><?php echo $module->name; ?></h3>
                    <p><?php echo $module->description; ?></p>
                </a>
            </div>
        </div>
        <?php
        }
        ?>        
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