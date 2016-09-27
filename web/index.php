<?php require_once "includes/header.php" ?>


	<style>
		.work-wrap i {
			font-size: 48px;
			height: 110px;
			width: 110px;
			margin: 3px;
			border-radius: 100%;
			line-height: 110px;
			text-align: center;
			background: #ffffff;
			/*color: #c52d2f;*/
			border: 3px solid #ffffff;
			box-shadow: inset 0 0 0 5px #f2f2f2;
			-webkit-box-shadow: inset 0 0 0 5px #f2f2f2;
			-webkit-transition: 500ms;
			-moz-transition: 500ms;
			-o-transition: 500ms;
			transition: 500ms;
			padding: 28px;
			margin-bottom: 25px;
		}

		.category {
			margin-top: 15px;
			line-height: 22px;
			padding-bottom: 20px;
		}


		/* SLIDER STYLES */

		.slider-wrapper{
			position:relative;
			overflow:hidden;

			width:100%;
			height: auto;
			margin: auto;

			/*background:#1b1b1b;*/

			/*border:1px solid #000;*/
			box-shadow:0 3px 5px #666;
		}

		.slider{
			position:relative;
			width: 100%;
			/*	height:400px; when responsive, comment this out */
			margin:0 auto;
			height: auto;
		}

		.slide-caption {
			font: 300 45px 'Titillium Web', Sans-Serif;
			color: #fdfdfd;
			line-height:100%
		}

		.slide-feat {
			font: 100 25px 'Titillium Web', Sans-Serif;
			line-height:100%;
			color: #f0f0f0;
		}

		.slide-caption-bg {
			font: 400 35px 'Titillium Web', Sans-Serif;
			color: #fdfdfd;
			padding: 5px 8px;
			padding-bottom: 140px;
			width: 700px;
			line-height:100%;
			background: rgba(0,0,0, 0.6);
		}

		.slide-feat-bg {
			font: 100 25px 'Titillium Web', Sans-Serif;
			line-height:100%;
			padding: 5px 8px;
			color: #f0f0f0;
			backgound: rgba(0,0,0, 0.5);
		}

		.th-mobile {
			display: none !important;
		}

		@media screen and (min-width: 200px) and (max-width: 600px) {
			.slide-caption-bg {
				padding-bottom: 40px;
			}
			/*.slide-caption-bg, .slide-feat-bg, .slide-feat, .slide-caption {
				display: none !important;
			}

			.th-mobile {
				display: block !important;
			}

			.slide .p {
				display: none !important;
			}

			.slide-text {
				font-size: 35px;;
			}*/
		}
	</style>
	
	<div class="container">
		
	</div>
	<section id="fh5co-hero" class="js-fullheight">
		<!--<div class="flexslider js-fullheight">
			<ul class="slides">
		   	<li style="background-image: url(images/slide_1.jpg);">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<h2>Start Your Startup With This Template</h2>
		   					<p><a href="#" class="btn btn-primary btn-lg">Get started</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(images/slide_2.jpg);">
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<h2>Take Your Business To The Next Level</h2>
		   					<p><a href="#" class="btn btn-primary btn-lg">Get started</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(images/slide_3.jpg);">
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner">
		   					<h2>We Think Different That Others Can't</h2>
		   					<p><a href="#" class="btn btn-primary btn-lg">Get started</a></p>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		  	</ul>
	  	</div>-->

		<div class="slider-wrapper">
			<div class="responisve-container">
				<div class="slider">
					<div class="fs_loader"></div>
					<div class="slide">
						<img src="images/travel.jpg" data-position="0,0" data-in="fade" data-delay="0" data-out="fade" />

						<p 		class="slide-caption-bg"
								  data-position="140,215" data-in="top" data-step="0" data-out="top" data-ease-in="">Travelhub Transportation Services</p>

						<p 		class="slide-feat-bg"
								  data-position="190,225" data-in="bottom" data-step="2" data-delay="500"><i class="icon-caret-right"></i> Offers software products and services</p>
						<p 		class="slide-feat-bg"
								  data-position="220,225" data-in="bottom" data-step="2" dataspecial="cycle" data-delay="3000" data-out="bottom"><i class="icon-caret-right"></i> Online marketing and customer acquisition schemes</p>
						<p 		class="slide-feat-bg"
								  data-position="250,225" data-in="bottom" data-step="2" dataspecial="cycle" data-delay="5500" data-out="bottom"><i class="icon-caret-right"></i> Travel logistics and smooth customer experience</p>
						<p 		class="slide-feat-bg"
								  data-position="280,225" data-in="bottom" data-step="2" dataspecial="cycle" data-delay="7500" data-out="bottom"><i class="icon-caret-right"></i> Online booking, agents and multiple ticketing channels</p>
					</div>
					<div class="slide">
						<img src="images/slide-bg.jpg" data-position="0,0" data-in="fade" data-delay="0" data-out="fade" />
						<img 	src="images/laptop1.png"
								width="580" height="450"
								data-position="132,950" data-in="bottom" data-delay="1800" data-out="bottom">

						<img src="images/tablet.png" width="220" data-position="238,890" data-in="right" data-delay="3000" data-out="right" />
						<img src="images/phone.png" data-position="315,1430" data-in="left" data-delay="3000" data-out="left" />

						<p 		class="slide-caption"
								  data-position="140,215" data-in="top" data-step="1" data-out="top" data-ease-in="easeOutBounce">Our Travel Technologies</p>

						<p 		class="slide-feat"
								  data-position="190,225" data-in="right" data-step="2" data-delay="500"><i class="icon-caret-right"></i> E-Ticketing Software</p>
						<p 		class="slide-feat"
								  data-position="220,225" data-in="left" data-step="2" dataspecial="cycle" data-delay="3000"><i class="icon-caret-right"></i> Courier Management Software</p>
						<p 		class="slide-feat"
								  data-position="250,225" data-in="right" data-step="2" dataspecial="cycle" data-delay="5000" data-out="none"><i class="icon-caret-right"></i> Online Booking API</p>
						<p 		class="slide-feat"
								  data-position="280,225" data-in="left" data-step="2" dataspecial="cycle" data-delay="7000" data-out="none"><i class="icon-caret-right"></i> ERP Software</p>
						<p 		class="slide-feat"
								  data-position="360,225" data-in="bottom" data-step="2" data-delay="9000" data-out="none"><i class="icon-caret-right"></i> and there's more...</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div id="fh5co-about-section" class="fh5co-light-grey-section">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading animate-box">
					<h2>TRAVELHUB</h2>
					<p>We are a travel agency focused on road travel logistics and related services. We have a technology team which develops and manages business applications for our clients. </p>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-services-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading animate-box">
					<h2>Our Services</h2>
					<p>Travelhub plays a part in most travel related activities and logistics. Here are some of the major services we offer.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-ticket"></i>
						<div class="desc">
							<h3>Ticketing Software</h3>
							<p>Travelhub has a real-time comprehensive and robost ticketing platform which delivers a seemless operation and unification for ticketing
							activities in the office, online and other ticketing channels</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-server"></i>
						<div class="desc">
							<h3>Administration</h3>
							<p>Administration task got easier with our structured admin backend. While giving each park total control of it's transport activities,
							department heads or managers still have the privilege to control it's activities </p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-laptop"></i>
						<div class="desc">
							<h3>ERP Software</h3>
							<p>We offer Enterprise Resource Planning specifically built for trasnport companies. With the unified collection of software, you can
							efficiently manage, run and monitor your entire business activities. Yes! All of it.</p>
							<p></p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-tablet"></i>
						<div class="desc">
							<h3>SEO Monitoring</h3>
							<p>Internet is the next big thing. But getting your business online doesn't guarantee that potential customers will see it at all or easily.
							However, you can let us worry about that since part of what we do is giving your business the cyber space it deserves.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-line-chart"></i>
						<div class="desc">
							<h3>Online Marketing</h3>
							<p>Our marketing team keeps devising new and creative ways to let the internet community know the uniqueness of your business, leveraging
							all the existing online marketing platforms, channels and strategy. Moreover, you can monitor the growth!</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="services">
						<i class="icon-bus"></i>
						<div class="desc">
							<h3>Misc, Travel Logistics</h3>
							<p>We offer various vehicle charter services, car hire, and more importantly, organize travels for religious groups, NYSC members, tourists etc; as a way
								of increasing your customer base. Plus other related travel logistics that will improve your business.<p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fh5co-work-section" class="fh5co-light-grey-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading animate-box">
					<h2>Latest Products</h2>
					<p>Our development team are always working on a new project to further improve your business actvities. </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 animate-box">
					<div class="item-grid text-center">
						<div class="v-align">
							<div class="v-align-middle work-wrap">
								<h3 class="title">Courier Management</h3>
								<i class="icon-truck"></i>
								<div class="category">This application profiles the entire process of taking an order, costing, tracking and collection.
									It can also be interfaced with a weighting machine for a classy courier service.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="item-grid text-center">
						<div class="v-align">
							<div class="v-align-middle work-wrap">
								<h3 class="title">Fleet Management</h3>
								<i class="icon-bus"></i>
								<div class="category">Keeps all details and information pertaining to all company vehicles. Measures each vehicle performance,
								expenses, revenue, profit or lose. It also flag vehicles for periodic maintenance.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 animate-box">
					<div class="item-grid text-center">
						<div class="v-align">
							<div class="v-align-middle work-wrap">
								<h3 class="title">Vehicle Rental Software</h3>
								<i class="icon-cab"></i>
								<div class="category">Takes all vehicle rental request both online and from the office. Displays available vehicles for renting
								and gives information on the location and status of rented vehicles.</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-center animate-box hidden">
					<p><a href="products.html" class="btn btn-primary with-arrow">View All Products <i class="icon-arrow-right"></i></a></p>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-testimony-section" class="hidden">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading animate-box">
					<h2>Clients Feedback</h2>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-offset-0 to-animate">
					<div class="wrap-testimony animate-box">
						<div class="owl-carousel-fullwidth">
							<div class="item">
								<div class="testimony-slide active text-center">
									<figure>
										<img src="images/person1.jpg" alt="user">
									</figure>
									<blockquote>
										<p>"Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean."</p>
									</blockquote>
									<span>Athan Smith, via <a href="#" class="twitter">Twitter</a></span>
								</div>
							</div>
							<div class="item">
								<div class="testimony-slide active text-center">
									<figure>
										<img src="images/person2.jpg" alt="user">
									</figure>
									<blockquote>
										<p>"Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean."</p>
									</blockquote>
									<span>Nathalie Kosley, via <a href="#" class="twitter">Twitter</a></span>
								</div>
							</div>
							<div class="item">
								<div class="testimony-slide active text-center">
									<figure>
										<img src="images/person3.jpg" alt="user">
									</figure>
									<blockquote>
										<p>"Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean."</p>
									</blockquote>
									<span>Yanna Kuzuki, via <a href="#" class="twitter">Twitter</a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-blog-section" class="fh5co-light-grey-section hidden">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading animate-box">
					<h2>Recent from Blog</h2>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-6 animate-box">
					<a href="#" class="item-grid">
						<div class="image" style="background-image: url(images/image_1.jpg)"></div>
						<div class="v-align">
							<div class="v-align-middle">
								<h3 class="title">We Create Mobile App</h3>
								<h5 class="date"><span>June 23, 2016</span> | <span>4 Comments</span></h5>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-6 col-sm-6 animate-box">
					<a href="#" class="item-grid">
						<div class="image" style="background-image: url(images/image_2.jpg)"></div>
						<div class="v-align">
							<div class="v-align-middle">
								<h3 class="title">Geographical App</h3>
								<h5 class="date"><span>June 22, 2016</span> | <span>10 Comments</span></h5>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-md-12 text-center animate-box">
					<p><a href="#" class="btn btn-primary with-arrow">View More Post <i class="icon-arrow-right"></i></a></p>
				</div>
			</div>
		</div>
	</div>

	<div id="fh5co-pricing-section" class="hidden">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading animate-box">
					<h2>Pricing</h2>
					<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
				</div>
			</div>
			<div class="row">
				<div class="pricing">
					<div class="col-md-3 animate-box">
						<div class="price-box">
							<h2 class="pricing-plan">Starter</h2>
							<div class="price"><sup class="currency">$</sup>9<small>/month</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
							<a href="#" class="btn btn-select-plan btn-sm">Select Plan</a>
						</div>
					</div>

					<div class="col-md-3 animate-box">
						<div class="price-box">
							<h2 class="pricing-plan">Basic</h2>
							<div class="price"><sup class="currency">$</sup>27<small>/month</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
							<a href="#" class="btn btn-select-plan btn-sm">Select Plan</a>
						</div>
					</div>

					<div class="col-md-3 animate-box">
						<div class="price-box popular">
							<h2 class="pricing-plan pricing-plan-offer">Pro <span>Best Offer</span></h2>
							<div class="price"><sup class="currency">$</sup>74<small>/month</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
							<a href="#" class="btn btn-select-plan btn-sm">Select Plan</a>
						</div>
					</div>

					<div class="col-md-3 animate-box">
						<div class="price-box">
							<h2 class="pricing-plan">Unlimited</h2>
							<div class="price"><sup class="currency">$</sup>140<small>/month</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
							<a href="#" class="btn btn-select-plan btn-sm">Select Plan</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php include_once "includes/footer.php"; ?>
	</div>
	
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Owl Carousel -->
	<!--<script src="js/owl.carousel.min.js"></script>-->
	<!-- Flexslider -->
	<!--<script src="js/jquery.flexslider-min.js"></script>-->
	<script src="js/jquery.fractionslider.min.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript">
		$(window).load(function(){
			$('.slider').fractionSlider({
				'fullWidth': 			true,
				'delay':				0,
				'pager': 				false,
				'responsive': 			true,
				'dimensions': 			"1700,650",
				'increase': 			false,
				'pauseOnHover': 		true
			});

		});
	</script>
	<!-- MAIN JS -->

	</body>
</html>

