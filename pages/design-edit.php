<?php
include('../header.php');
$page_title = 'Add/Edit Design';
?>
<section class="bg-secondary">
    <div class="container">
        <h2 class="text-center col-lg-10">Add/Edit Design</h2>
        <a href="" class="btn btn-primary col-lg-2">SAVE CHANGES</a>
    </div>
    <hr>
    <div class="container">
        <div id="form-part" class="col-lg-6">
            <form>
                <div class="form-group">
                    <label class="sr-only" for="form-design-name">Design Name</label>
                    <input type="text" name="form_design_name" placeholder="Design Name..." class="form-control"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="form-design-description">Design Description</label>
                    <textarea type="text" name="form_design_description" placeholder="Give the design a description..." class="form-control"></textarea>
                </div>
            </form>
        </div>
        <div id="image-part" class="col-lg-6">
            <img src="../app/images/design/poster.jpg"/>
        </div>
    </div>
</section>
<?php include('../footer.php'); ?>