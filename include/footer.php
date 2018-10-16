<section id="footerHolder">
	<div class="newsletter">
		<ul>
			<li>Newsletter</li>
			<li>
				<form name="signup" id="signup" method="post">
					<input type="text" id="signup_email" name="signup_email" placeholder="Your email address" class="textBox" value="">
					<input type="button" name="submit" value="Sign up" class="signUp_btn">
				</form>
				<p>
			  <div class="callout callout-danger errorDiv" > <span id="errormessage" style="text-align:center;"></span> </div>
				  <span style="color:008000;" id="thankyou"></span>
				 </p>
			</li>
		</ul>
	</div>
	<div class="footer">
                <div class="container">
                    <div class="footer_blurb">
                        <div class="blurb_title">Products</div>
                        <ul>
						<?php 
						$prod_sql 	=	"SELECT * from   tbl_applications WHERE is_active=1 and is_delete=1 order by sortorder asc";
						$prod_arr=	$objTypes->fetchAll($prod_sql);
						if(isset($prod_arr) && sizeof($prod_arr) > 0){
							foreach ($prod_arr as $prod_v){ 
								if(strstr(strtolower($prod_v['title']),'hauraton')){
									$url = base_url.'hauraton';
								}else{
									$url = base_url.'applications/'.$objTypes->prepare_url(stripslashes($prod_v['title'])).'-'.$prod_v['id'];
								}
							?>
							<li><a href="<?=$url?>"><?=$prod_v['title'];?></a></li>
						<?php } } ?>								
                        </ul>
                    </div>
                       <div class="footer_blurb">
                        <div class="blurb_title">Infocenter</div>
                        <ul>
                            <li><a href="<?=base_url?>press-release">Press Release</a></li>
                            <li><a href="<?=base_url?>news-events">News & Events</a></li>
                            <li><a href="<?=base_url?>gallery">Gallery</a></li>
                            <li><a href="<?=base_url?>clients">Our Clients</a></li>
                            <li><a href="<?=base_url?>faq">FAQ's</a></li>
                            <li><a href="<?=base_url?>downloads">Downloads</a></li>
                        </ul>
                    </div>
                       <div class="footer_blurb">
                        <div class="blurb_title">Others</div>
                        <ul>
                            <li><a href="<?=base_url?>about-us">About Us</a></li>
                            <li><a href="<?=base_url?>investor-relations">Investor Relations</a></li>
                            <li><a href="javascript:;">Piping Guideline </a></li>
                            <li><a href="<?=base_url?>careers-landing">Careers</a></li>
                        </ul>
                    </div>
                    <div class="footer_blurb">
                        <div class="blurb_title">Contact Us</div>
                        <p>"ASTRAL HOUSE" 207/1,</p>
                        <p>Bh. Rajpath Club</p>
                        <p>Off. S.G. Highway,</p>
                        <p>Ahmedabad-380 059 India.</p>
                        <p>Phone: +91-79-66212000</p>
                            <p>email: <a href="mailto:info@astralpipes.com">info@astralpipes.com</a></p>
                         <!--div class="map">
                            <iframe id="gmap_canvas" src="https://maps.google.com/maps?q=Indonesian Island sail&t=&z=9&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div-->
                    </div>
                </div>
            </div>	
		<div class="footer_bottom">
			<div class="container">
				<div class="creadit"><a href="javascript:;">&copy; <?=date("Y")?>-<?=date("Y", strtotime("+1 year"))?> ASTRAL POLYTECHNIK LIMITED. ALL RIGHTS RESERVED.</a></div>
				<div class="created_by">
					<a href="https://bcwebwise.com" target="_blank"><img src="<?=base_url?>assets/images/bcww-fish.png" alt="https://bcwebwise.com"></a>
				</div>
			</div>
			<div class="footerClose open">
				<img src="<?=base_url?>assets/images/footer-close.jpg" alt="Close Circle">
				<div class="ft_close">Open</div>
				<div class="arrow"><img src="<?=base_url?>assets/images/footer-arrow.png" alt="Footer Arrow"></div>
			</div>
		</div>
</section>
	
    <section id="search_con">
		<div class="container">
			<div class="error_log" style="color:red;"></div>
			<form name="search" id="searchdata" method="post" action="<?=base_url?>search">
	          <input type="text" name="search_data" id="search_data" class="search_txtBox" placeholder="Search">
			</form>
			<div class="closeSearch">X</div>
		</div>
	</section>
    
    
	<div class="enq_button">
		<a href="<?=base_url?>enquiry">
			<img src="<?=base_url?>assets/images/icon-chat.png" alt="">
			<span>Interested?
			<br /> Enquire Now</span>
		</a>
	</div>