<?php include('../header.php'); ?>
<section class="bg-secondary">
    <div class="container">
        
        <div class="row">
            <div class="col-md-3">
                <div class="circle c1 img-circle">
                    <h4 class="blue">Free Plan</h4>
                    <span class="icon blue"><i class="fa fa-dollar"></i></span>
                    <span class="price-large blue">0</span>
                    <span class="price-small">00</span>
                    <p>Great for starters</p>
                    <button type="button" class="btn btn-info">Choose</button>
                </div>
            </div>            
            <div class="col-md-3">
                <div class="circle c2 img-circle">
                <h4 class="yellow">Single Plan</h4>
                    <span class="icon yellow"><i class="fa fa-dollar"></i></span>
                    <span class="price-large yellow">0</span>
                    <span class="price-small">99</span>
                    <p>Great for single use</p>
                    <button type="button" class="btn btn-warning">Choose</button>
                </div>
            </div>            
            <div class="col-md-3">
                <div class="circle c3 img-circle">
                    <h4 class="green">Monthly Plan</h4>
                    <span class="icon green"><i class="fa fa-dollar"></i></span>
                    <span class="price-large green">9</span>
                    <span class="price-small">99</span>
                    <p>Great for small companies</p>
                    <button type="button" class="btn btn-success">Choose</button>
                </div>
            </div>            
            <div class="col-md-3">
                <div class="circle c4 img-circle">
                    <h4 class="red">Yearly Plan</h4>
                    <span class="icon red"><i class="fa fa-dollar"></i></span>
                    <span class="price-large red">99</span>
                    <span class="price-small">99</span>
                    <p>Great for Enterprise</p>
                    <button type="button" class="btn btn-danger">Choose</button>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class='package col-md-3'>
                  <div class='name'>Free</div>
                  <div class='price'>$0 / per download </div>
                  <div class='trial'>Available for a month</div>
                  <hr>
                  <ul>
                      <li>
                          <strong>8</strong>
                          team members
                      </li>
                      <li>
                          <strong>6</strong>
                          team playlists
                      </li>
                      <li>
                          <strong>Unlimited</strong>
                          public playlists
                      </li>
                  </ul>
            </div>
            <div class='package col-md-3'>
                <div class='name'>Limited</div>
                <div class='price'>$0.99 / per download </div>
                <div class='trial'>Available for a month</div>
                <hr>
                <ul>
                    <li>
                        <strong>8</strong>
                        team members
                    </li>
                    <li>
                        <strong>6</strong>
                        team playlists
                    </li>
                    <li>
                        <strong>Unlimited</strong>
                        public playlists
                    </li>
                </ul>
            </div>
            <div class='package brilliant col-md-3'>
                <div class='name'>Brilliant</div>
                <div class='price'>$9.99 / per month</div>
                <div class='trial'>Free 30 day trial</div>
                <hr>
                <ul>
                    <li>
                        <strong>Unlimited</strong>
                        team members
                    </li>
                    <li>
                        <strong>Unlimited</strong>
                        team playlists
                    </li>
                    <li>
                        <strong>Unlimited</strong>
                        public playlists
                    </li>
                    <li>
                        Team analytics
                    </li>
                    <li>
                        Send files
                    </li>
                </ul>
            </div>
            <div class='package col-md-3'>
                <div class='name'>Basic</div>
                <div class='price'>$99.99 / per year</div>
                <div class='trial'>Totally free</div>
                <hr>
                <ul>
                    <li>
                        <strong>5</strong>
                        team members
                    </li>
                    <li>
                        <strong>3</strong>
                        team playlists
                    </li>
                    <li>
                        <strong>Unlimited</strong>
                        public playlists
                    </li>
                </ul>
            </div>
        </div>
        
    </div>
</section>

<style type="text/css">    
    .wrapper {
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -190px 0 0 -468px;
      font-family: 'Open Sans', sans-serif;
      font-weight: 400;
      color: #9f9f9f;
      font-size: 15px;
    }
    .package {
      box-sizing: border-box;
      width: 301px;
      height: 380px;
      border: 3px solid #e8e8e8;
      border-radius: 7px;
      display: inline-block;
      padding: 24px;
      text-align: center;
      float: left;
      -webkit-transition: margin-top 0.5s linear;
      transition: margin-top 0.5s linear;
      position: relative;
      margin-right: 11px;
    }
    .package:hover {
      margin-top: -30px;
      -webkit-transition: margin-top 0.3s linear;
      transition: margin-top 0.3s linear;
    }
    .name {
      color: #565656;
      font-weight: 300;
      font-size: 3rem;
      margin-top: -5px;
    }
    .price {
      margin-top: 7px;
      font-weight: bold;
    }
    .price::after {
      /*content: " / month per user";*/
      font-weight: normal;
    }
    .package hr {
      background-color: #dedede;
      border: none;
      height: 1px;
    }
    .trial {
      font-size: .9rem;
      font-weight: 600;
      padding: 2px 21px 2px 21px;
      color: #33c4b6;
      border: 1px solid #e4e4e4;
      display: inline-block;
      border-radius: 15px;
      background-color: white;
      position: relative;
      bottom: -20px;
    }
    .package ul {
      list-style: none;
      padding: 0;
      text-align: left;
      margin-top: 29px;
    }
    .package li {
      margin-bottom: 15px;
    }
    .checkIcon {
      font-family: "FontAwesome";
      content: "\f00c";
    }
    .package li::before {
      font-family: "FontAwesome";
      content: "\f00c";
      font-size: 1.3rem;
      color: #33c4b6;
      margin-right: 3px;
    }
    .brilliant {
      border-color: #33c4b6;
    }
    /* Triangle */
    .brilliant::before {
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 64px 64px 0 0;
      border-color: #3bc6b8 transparent transparent transparent;
      position: absolute;
      left: 0;
      top: 0;
      content: "";
    }
    .brilliant::after {
      font-family: "FontAwesome";
      content: "\f00c";
      color: white;
      position: absolute;
      left: 9px;
      top: 6px;
      text-shadow: 0 0 2px #37c5b6;
      font-size: 1.4rem;
    }

    
    
    
    
    
    @charset "utf-8";
	
	* {
	padding:0; 
	margin:0; 
	border:0;
}
body {
   background: #d5d5d5;
	font-family:trebuchet MS;
	color:#6B6B6B;
   border: 0 none;
   margin: 0;
	font-size:13px;
   padding: 0;
}
#wrapper{
  padding: 60px 0px;
}
.container{}
.row{}
.circle{
  background: #ffffff;
  padding: 35px;
  text-align: center;
  height: 250px;
  width: 250px;
  border: 8px solid #F2F2F2;
    
    transition: all 0.5s;
  -moz-transition: all 0.5s; /* Firefox 4 */
  -webkit-transition: all 0.5s; /* Safari and Chrome */
  -o-transition: all 0.5s; /* Opera */
 
}
.circle h4{
  margin: 0;
  padding: 0;
}
.circle p{}
.circle span{}
.circle span.icon{
}
.circle span.icon i{
  font-size: 48px;
}
.circle span.price-large{
  font-size: 68px
}
.price-small{
  font-size: 24px 
}

.c1:hover{
  background: #39b3d7;
  color: #ffffff;
}
.c1 .blue{
  color: #39b3d7;
}
.c1:hover .blue{
  color: #ffffff;
}

.c2:hover{
  background: #ed9c28;
  color: #ffffff;
}
.c2 .yellow{
  color: #ed9c28;
}
.c2:hover .yellow{
  color: #ffffff;
}

.c3:hover{
  background: #47a447;
  color: #ffffff;
}
.c3 .green{
  color: #47a447;
}
.c3:hover .green{
  color: #ffffff;
}

.c4:hover{
  background: #d2322d;
  color: #ffffff;
}
.c4 .red{
  color: #d2322d;
}
.c4:hover .red{
  color: #ffffff;
}
</style>

<?php include('../footer.php'); ?>