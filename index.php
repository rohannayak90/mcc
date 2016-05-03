    <?php include('header.php'); ?>
    
    <?php
    
    $show_header = false;
    $banner_header = '';
    $description = '';
    $link = '';
    $link_text = '';
    $style_with_header_background = '';
    
    if ($_SERVER['REQUEST_URI'] == $SERVER_FOLDER)
    {
        $show_header = true;
        $style_with_header_background = 'background-image: url(' . base_url() . 'images/introduction.png)';
        $banner_header = 'Set Your <br/><strong>DESIGN</strong> APART.';
        $description = 'Create your own designs. Start for free.';
        $link = base_url() . 'flash/customizer.php';
        $link_text = 'GET STARTED';
    }
    
    ?>
    
    <header style="<?php echo $style_with_header_background; ?>">
        <div class="header-content">
            <div class="header-content-inner">
                <?php
                if ($banner_header != '')
                    echo '<h1>' . $banner_header . '</h1>';
                if ($banner_header != '' && $description != '')
                    echo '<hr>';
                if ($description != '')
                    echo '<p>' . $description . '</p>';                
                if ($link_text != '')
                    echo '<a href="' . $link . '" class="btn btn-primary btn-xl page-scroll">' . $link_text . '</a>';
                ?>
                
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Perfect Designs!</h2>
                    <hr class="light">
                    <p class="text-faded">
                        Start designing anything you want, as we have everything you will need at your finger tips. So just let the magic happen.
                    </p>
                    <a href="javascript:void(0)" class="btn btn-default btn-xl">Get Started!</a>
                </div>
            </div>
        </div>
    </section>
    
    <section id="services" class="bg-secondary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-diamond wow bounceIn text-primary"></i>
                        <h3>Thousand Templates</h3>
                        <p class="text-muted">Our templates are updated regularly so you don't have to make everything from scratch.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-paper-plane wow bounceIn text-primary" data-wow-delay=".1s"></i>
                        <h3>Range of Icons</h3>
                        <p class="text-muted">We have a large set of images and icons that you can just add and get going.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-newspaper-o wow bounceIn text-primary" data-wow-delay=".2s"></i>
                        <h3>Image Filters</h3>
                        <p class="text-muted">We have built-in image editing tools that will make your images stand out on your designs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-4x fa-heart wow bounceIn text-primary" data-wow-delay=".3s"></i>
                        <h3>Font Collection</h3>
                        <p class="text-muted">We have added a large set of fonts into our application, so that you get your designs on your own taste.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="portfolio" class=""><!-- class="no-padding" -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Creations From Our Friends</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row no-gutter">
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/1.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/2.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/3.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/4.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/5.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a href="javescript:void(0)" class="portfolio-box">
                        <img src="images/portfolio/6.jpg" class="img-responsive" alt="">
                        <div class="portfolio-box-caption">
                            <div class="portfolio-box-caption-content">
                                <div class="project-category text-faded">
                                    Category
                                </div>
                                <div class="project-name">
                                    Project Name
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="bg-secondary">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Heard Enough?</h2>
                <p>
                    Reading wouldn't be enough. Nothing beats trying on your own.
                    <br>
                    Get started now. Check out for free.
                </p>
                <a href="javascript:void(0)" class="btn btn-primary btn-xl wow tada">Start Now!</a>
            </div>
        </div>
    </section>
    
    <?php include('footer.php'); ?>
    
    