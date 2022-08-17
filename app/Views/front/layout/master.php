<!DOCTYPE html>
<html lang="zxx">

<head>
  <!-- Basic Page Needs
    ================================================== -->
  <title>Atomic Arts Intranet</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Escape Room Game">
  <meta name="author" content="Dan Fisher">
  <meta name="keywords" content="escape, room, quest, real, game, life, puzzle, real-life">
  <!-- Favicons
    ================================================== -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/front/img/favicons/favicons.png') ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets/img/favicons/favicons.png')?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('assets/img/favicons/favicons.png')?>">
  <!-- Mobile Specific Metas
    ================================================== -->
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <!-- Google Web Fonts
    ================================================== -->
  <link href="https://fonts.googleapis.com/css?family=Anton%7CHind:400,700%7CMontserrat:400,700" rel="stylesheet">
  <!-- CSS
    ================================================== -->
  <!-- Vendor CSS -->
  <link href="<?php echo base_url('assets/front/vendor/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/vendor/animate/animate.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/vendor/aos/aos.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/font-icon/simple-line-icons/css/simple-line-icons.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/font-icon/ionicons/css/ionicons.min.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/vendor/magnific-popup/magnific-popup.css') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/front/vendor/slick/slick.css') ?>" rel="stylesheet">
  <!-- Template CSS-->
  <link href="<?php echo base_url('assets/front/css/style.css') ?>" rel="stylesheet">
  <!-- Booked CSS-->
  <link href="<?php echo base_url('assets/front/css/booked.css') ?>" rel="stylesheet">
  <!-- Custom CSS-->
  <link href="<?php echo base_url('assets/front/css/custom.css') ?>" rel="stylesheet">
  <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">

  <?= $this->renderSection("style") ?>
</head>
                   <?php 
					 $class= "" ;
					if(!empty(session()->get('lang'))  && strtoupper(session()->get('lang')) == 'DE'):
					  $class = "sec_de" ;
					endif;
					?>		
							
<body class="<?=$class?>">

           
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
  <div class="site-wrapper">
    <div id="js-preloader-overlay" class="preloader-overlay">
      <div id="js-preloader" class="preloader"></div>
    </div>
    <!-- Overlay -->
    <div class="site-overlay"></div>
    <!-- Overlay / End -->
    <!-- Header -->
    <?php
    $router = service('router');
    $route  = $router->getMatchedRoute();
    ?>
    <header id="header" class="header">
      <!-- Logo - Image Based -->
      <div class="header__logo header__logo--img">
        <a href="<?php echo base_url(); ?>">
          <img src="<?php echo base_url('assets/front/img/flirt-logo-new.png')?>" class="img_logo" alt="Escape room">
          <!--<h4><span class="letter-color">T</span>he <span class="letter-e">E</span>scape <span class="letter-r">R</span>oom</h4>-->
        </a>
      </div>
      <!-- Logo - Image Based / End -->
      <!-- Main Navigation -->
      <nav class="main-nav">
        <ul class="main-nav__list">
          <li class="<?php if (empty($route)) {
                        echo " active";
                      } ?>"><a href="<?php echo base_url(); ?>"><?php echo lang('t.home') ?></a></li>
          <li class="<?php if (isset($route[0]) && $route[0] == "about") {
                        echo " active";
                      } ?>"><a href="<?php echo base_url('about') ?>"><?php echo lang('t.about') ?></a></li>
          <li class="<?php if (isset($route[0]) && $route[0] === "how-it-works") {
                        echo " active";
                      } ?>"><a href="<?php echo base_url('how-it-works') ?>"><?php echo lang('t.how-it-works') ?>?</a></li>
          <li class="<?php if (isset($route[0]) && $route[0] === "adventures") {
                        echo " active";
                      } ?>"><a href="<?php echo base_url('adventures') ?>"><?php echo lang('t.adventures') ?></a></li>
          <li class="<?php if (isset($route[0]) && $route[0] === "contact") {
                        echo " active";
                      } ?>"><a href="<?php echo base_url('contact') ?>"><?php echo lang('t.contact') ?></a></li>
        </ul>
      </nav>
      <!-- Main Navigation / End -->
      <!--    <div class="header__spacer"></div> -->
      <!-- Secondary Navigation -->
      <?php if (!isUserLoggedIn()) : ?>
        <nav class="header__nav header__nav--secondary">
          <!-- CTA Button -->
          <a href="<?php echo base_url('register'); ?>" class="btn btn-outline-secondary nav-btn">
            <span class="nav-btn__label"><?php echo lang('t.register') ?></span>
            <i class="nav-btn__icon icon-calendar"></i>
          </a>
          <!-- CTA Button / End -->
          <!-- Secondary Nav -->
          <ul class="nav-secondary">
            <!-- Search Form Toggler -->
            <li class="nav-secondary__search">
              <div class="search-form-control js-search-form-control">
                <div class="search-form-toggler"></div>
                <i class="icon-magnifier search-form-toggler__icon"></i>
              </div>
            </li>
            <!-- Search Form Toggler / End -->
            <!-- Account -->

            <li class="nav-secondary__login">
              <a href="<?php echo base_url('login') ?>">
                <i class="icon-user"></i>
                <span class="link-label"><?php echo lang('t.login') ?></span>
              </a>
            </li>
			
          </ul>
			
          <!-- Secondary Nav / End -->
        </nav>
      <?php else : ?>
        <nav class="header__nav header__nav--secondary">
          <!-- Secondary Nav -->
          <ul class="nav-secondary">
            <!-- Search Form Toggler -->
            <li class="nav-secondary__search">
              <div class="search-form-control js-search-form-control">
                <div class="search-form-toggler"></div>
                <i class="icon-magnifier search-form-toggler__icon"></i>
              </div>
            </li>
            <!-- Search Form Toggler / End -->
            <!-- Account -->

            <li class="nav-secondary__login">
              <a href="<?php echo base_url('user/dashboard') ?>">
                <i class="icon-user"></i>
                <span class="link-label"><?php echo lang('t.dashboard') ?></span>
              </a>
            </li>

          </ul>
          <!-- Secondary Nav / End -->
        </nav>
      <?php endif; ?>
   
				<div class="dropdown flex-md-grow-1 flex-xl-grow-0 show">
					<button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<?php if(empty(session()->get('lang'))){
								echo "EN";
							}else{
								echo strtoupper(session()->get('lang'));
							}
						 ?>
						 
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-5px, 34px, 0px);">
						<a class="dropdown-item" href="<?php echo base_url('lang/en'); ?>">EN</a>
						<a class="dropdown-item" href="<?php echo base_url('lang/de'); ?>">DE</a>
					</div>
				</div>
		
      <!-- Secondary Navigation / End -->
      <!-- Mobile Burger Menu Icon -->
      <a id="header-mobile__toggle" class="burger-menu-icon">
        <span class="burger-menu-icon__line"></span>
        <span class="burger-menu-icon__line"></span>
        <span class="burger-menu-icon__line"></span>
      </a>
      <!-- Mobile Burger Menu Icon / End -->
    </header>
    <!-- Header / End -->
    <div class="main-panel" id="main-app">
      <?= $this->renderSection("content") ?>
    </div>
    <!-- Footer
    ================================================== -->
    <footer id="footer" class="footer">
      <!-- Footer Widget -->
      <div class="footer-widgets">
        <div class="container">
          <div class="row footer-widgets__row footer-widgets__row--is-numbered">
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <!-- Widget: Address -->
              <div class="widget widget--footer">
                <div class="widget__header">
                  <h4 class="widget__title"><?php echo lang('t.our-address') ?></h4>
                </div>
                <div class="widget__content">
                  <address>
                    <p>
                      Escape Room<br>
                      Suite 100<br>
                      North Downtown, NY 82153
                    </p>
                    <p>
                      <?php echo lang('t.email') ?>: <a href="mailto:">info@escape.com</a><br>
                      Tel: <a href="tel:+1 800 900 1248">+1 800 900 1248</a>
                    </p>
                  </address>
                </div>
              </div>
              <!-- Widget: Address / End -->
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <!-- Widget: Links -->
              <div class="widget widget--footer widget_nav_menu">
                <div class="widget__header">
                  <h4 class="widget__title"><?php echo lang('t.useful-links') ?></h4>
                </div>
                <div class="widget__content">
                  <ul>
                    <li><a href="<?php echo base_url('about') ?>"><?php echo lang('t.about') ?></a></li>
                    <li><a href="<?php echo base_url('how-it-works') ?>"><?php echo lang('t.how-it-works') ?></a></li>
                    <li><a href="<?php echo base_url('terms-and-conditions')?>"><?php echo lang('t.terms-conditions-1') ?></a></li>
                    <li><a href="<?php echo base_url('privacy-policy')?>"><?php echo lang('t.privacy-policy-1') ?></a></li>
                    <li><a href="<?php echo base_url('contact') ?>"><?php echo lang('t.contact-1') ?></a></li>
                    <!--<li class="<? //php if(isset($route[0]) && $route[0]==="features_faqs")
                                    ?>"><a href="<? //php echo base_url('features_faqs')
                                                  ?>">FAQ's</a></li>-->
                    <li><a href="<?php echo base_url('faqs') ?>"><?php echo lang('t.faq-s') ?></a></li>
                  </ul>
                </div>
              </div>
              <!-- Widget: Links / End -->
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <!-- Widget: Social Links -->
              <div class="widget widget--footer widget-social">
                <div class="widget__header">
                  <h4 class="widget__title"><?php echo lang('t.social-links') ?></h4>
                </div>
                <div class="widget__content">
                  <ul class="social-links social-links--circle">
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-yelp"></i></a>
                    </li>
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-youtube"></i></a>
                    </li>
                    <li class="social-links__item">
                      <a class="social-links__link" href="#"><i class="fab fa-google"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Widget: Social Links / End -->
            </div>
          </div>
        </div>
      </div>
      <!-- Footer Widgets / End -->
      <!-- Footer Copyright -->
      <div class="footer-copyright">
        <div class="container">
          <!-- Logo - Image Based 
          <div class="footer__logo footer__logo--img">
            <a href="index.html"><img src="assets/img/footer-logo.png" srcset="assets/img/footer-logo@2x.png 2x" alt="Escapium Logo"></a>
          </div>-->
          <!-- Logo - Image Based / End -->
          <div class="footer-copyright__txt">
            Copyright &copy; <?php echo date('Y'); ?> &nbsp;|&nbsp; All Rights Reserved. <br>
			Website by <a href="nexustechies.com" target="_blank">Nexus Techies</a>
          </div>
        </div>
      </div>
      <!-- Footer Copyright / End -->
    </footer>
    <!-- Footer / End -->
    <!-- Search Form -->
    <i class="js-search-form-close search-form-close icon-close"></i>
    <form action="<?=base_url('adventures');?>" class="search-form-overlay">
      <div class="search-input">
        <input type="text" name="name" class="input-search" placeholder="<?php echo lang('t.enter-your-search') ?>">
        <button type="submit" class="submit">
          <i class="icon-arrow-right"></i>
        </button>
      </div>
    </form>
    <!-- Search Form / End -->
  </div><!-- .site-wrapper -->
  <!-- Javascript Files
    ================================================== -->
  <!-- Vendors JS -->
  <script src="<?php echo base_url('assets/front/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/front/vendor/jquery/jquery-migrate.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/front/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script defer src="<?php echo base_url('assets/front/font-icon/font-awesome/js/all.min.js') ?>"></script>
  <script src="//maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
  <script src="<?php echo base_url('assets/front/vendor/gmap3/dist/gmap3.min.js') ?>"></script>
  <!-- Core JS -->
  <script src="<?php echo base_url('assets/front/js/core.js') ?>"></script>
  <!-- Template JS -->
  <script src="<?php echo base_url('assets/front/js/init.js') ?>"></script>
  <!-- <script src="<?php echo base_url('assets/common/js/custom.js') ?>"></script>-->
  <script src="<?php echo base_url('assets/front/js/custom.js') ?>"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <!----Spefic page script----->
  <?= $this->renderSection("script") ?>
</body>

</html>

<style>
  li.nav__logout {
    list-style: none !important;
    width: 20% !important;
    text-align: right !important;
  }

  li.nav__logout a {
    color: #000 !important;
    font-weight: 700;
  }
</style>