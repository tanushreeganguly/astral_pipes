<header>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": " https://www.astralpipes.com",
  "logo": "http://182.76.98.113/astral-pipes/assets/images/logo-desktop.png"
  },{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "https://www.astralpipes.com",
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "1800 233 7957",
    "contactType": "customer service",
   
    "areaServed": "iN"
</script>
	
		<div class="headerCon">
			<div class="hd_top">
                 
                  <div class="search">
						<img src="<?=base_url?>assets/images/icon-search.png" alt="Search">
					</div>
                    
                          
                           
                           
                           
				<div class="top_leftDetails">
					<ul class="topleftC">
						<li><a href="#">Become A Dealer</a></li>
						<li><a href="#">GST Details</a></li>
					</ul>
				</div>
				<a href="tel:18002337957" class="displaymoblockH">
                <picture>
                 <source media="(max-width: 1157px)" srcset="<?=base_url?>assets/images/icon-phone-white.png">
	 					<img src="<?=base_url?>assets/images/icon-phone.png" alt="Phone Number" align="absmiddle"></picture>
 		            Toll Free: 1800 233 7957</a>
				<a href="https://api.whatsapp.com/send?phone=919099666666" target="_blank" class="whats_icon"></a>
				<a href="mailto:info@astralpipes.com" target="_blank" class="email_icon"></a>
				<a href="https://www.facebook.com/pages/Astral-Poly-Technik-Ltd/186873938039882" target="_blank" class="fb_icon"></a>
				<a href="https://twitter.com/AstralPipes" target="_blank" class="tw_icon"></a>
				<a href="https://www.youtube.com/channel/UCfcxsolIKB6RReU45xxlAfQ" target="_blank" class="yt_icon"></a>
				<a href="https://www.instagram.com/astral_pipes/" target="_blank" class="insta_icon"></a>
				<a href="https://www.linkedin.com/company/astral-poly-technik-ltd-/" target="_blank" class="linkd_icon"></a>
			</div>

			<div class="hd_bottom">
            <div class="res_top">
				<div class="logo">
					<a href="<?=base_url;?>">
						<picture>
			                 <source media="(max-width:480px)" srcset="<?=base_url?>assets/images/logo-desktop.png">
                                    <source media="(max-width:1157px)" srcset="<?=base_url?>assets/images/logo-tab.png">
                                    
							<img src="<?=base_url?>assets/images/logo-desktop.png" alt="Astral pipes">
						</picture>
					</a>
				</div>
                 <div id="nav-icon1">
                            <span></span>
                             <span></span>
                             <span></span>
                  </div>
                </div>
             	<nav>
                 <div class="mobileMenuClose"><img src="<?=base_url?>assets/images/close-menu-mob.png" alt=""></div>
                
					<ul class="slimmenu">
						<li><a href="<?=base_url?>about-us">About us</a></li>
						
                        <li class="product_subnav"><a href="javascript:;">Products </a>
							<ul class="prod_sub_menu">
                              <div class="sub_nav_con">
                      <div class="sub_nav_list">
                      
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
								
                                </div>
                                   

							<div class="sub_img_ref">
								<?php
								if(isset($prod_arr) && sizeof($prod_arr) > 0){
								  foreach($prod_arr as $prod_v){
									?>
								<img src="<?=base_url?>uploads/astral_defines_images/<?php echo $prod_v['thumbnail'];?>" alt="<?php echo stripslashes($prod_v['title']);?>">
								<?php }}?>
							  </div>
					  
                      
                       </div>
							</ul>
						</li>
						<li><a href="javascript:;">Infocenter</a>
                        <ul>
                        <li><a href="<?=base_url?>press-release">Press Release</a></li>						
						<li><a href="<?=base_url?>news-events">News &amp; Events</a></li>						
						<li><a href="<?=base_url?>gallery">Gallery</a></li>						
						<li><a href="<?=base_url?>clients">Our Clients</a></li>						
						<li><a href="<?=base_url?>faq">FAQs</a></li>						
						<li><a href="<?=base_url?>downloads">Downloads</a></li>						
							</ul>
                            </li>
						<li><a href="<?=base_url?>investor-relations">Investor Relations</a></li>
						<li><a href="javascript:;">Piping Guidelines</a></li>
						<li><a href="<?=base_url?>careers-landing">Careers</a></li>
						<li><a href="<?=base_url?>contact-us">Contact us</a></li>
					</ul>
					
				</nav>
			</div>

		</div>
	
</header>
<div class="gutter"></div>
        