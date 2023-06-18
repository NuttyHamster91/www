<?php
session_start();
// CHECK FOR LOGGED IN USER //
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../index.php?id=8');
  exit;
}

// CHECK FOR CONFIG FILE //
$file = ('includes/config.php'); 
if (!file_exists($file)) {   
    header('Location: ../setup/firstrun.php');
    } else {}

if (is_null($_SESSION['avatar'])) {
    $_SESSION['avatar'] = "default/add-avatar.png";
} else {
    $_SESSION['avatar'] = $_SESSION['avatar'];
}

$id = $_SESSION['id'];
$sql = "SELECT dark_mode FROM users WHERE id = $id;";
$res = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($res);
        $dark = $row['dark_mode'];
        
?>

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu" 
data-color=<?if ($dark == "0"){ echo 'bg-gradient-x-orange-yellow';}else{ echo 'bg-gradient-x-blue-cyan';}?> data-col="2-columns">

<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light"> 
  <div class="navbar-wrapper">
    <div class="navbar-container content">
      <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide" data-toggle="dropdown" href="#"><i class="ficon ft-search"></i></a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text" placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x">   </i></div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>           
                <ul class="nav navbar-nav float-right">     
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                        <div class="arrow_box"><a class="dropdown-item" href="#"><i class="flag-icon flag-icon-gb"></i> English</a></div>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">             </i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                        <div class="arrow_box_right"><a class="dropdown-item" href="#"><i class="ft-book"></i> Read Mail</a><a class="dropdown-item" href="#"><i class="ft-bookmark"></i> Read Later</a><a class="dropdown-item" href="#"><i class="ft-check-square"></i> Mark all Read       </a></div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="" data-toggle="dropdown">             
                        <span class="avatar avatar-online"><img src="theme-assets/images/portrait/<? echo $_SESSION['avatar']?>" alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right"><a class="dropdown-item" href="#">
                                <span class="avatar avatar-online"><img src="theme-assets/images/portrait/<? echo $_SESSION['avatar']?>" alt="avatar"></span>
                                <span class="user-name text-bold-500 ml-1"><? echo $_SESSION['name']?></span></a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" 
                                href="user_details.php"><i class="ft-user"></i> Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                    <?$page=basename($_SERVER['PHP_SELF']);
                                    if ($dark == "0"){ echo '<a class="dropdown-item" 
                                        href="includes/functions.php?action=darkMode&p='.$page.'"><i class="ft-moon"></i> Go Dark</a>';}
                                    elseif ($dark == "1"){ echo '<a class="dropdown-item" 
                                        href="includes/functions.php?action=lightMode&p='.$page.'"><i class="ft-sun"></i> Go Light</a>';}
                                    ?>
                                <!--a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a>
                                <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>
                                <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a-->
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="logout.php"><i class="ft-power"></i> Logout</a>
                            </div>
                        </div>
                    </li>                    
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-hide <?if ($dark == "0"){ echo "menu-light";}else{ echo "menu-dark";}?> menu-accordion menu-shadow " 
data-scroll-to-active="true" data-img="theme-assets/images/backgrounds/04.jpg">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">      
            <li class="nav-item mr-auto"><a class="navbar-brand" href="dashboard.php">
                <img class="brand-logo" alt="Logo" src="theme-assets/images/ico/favicon.png"/>
                <h3 class="brand-text"><? echo COMPANY_NAME?></h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
        </ul>
    </div>
    <div class="navigation-background"></div>
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item"> 
            <a href="dashboard.php"><span class="menu-title" data-i18n=""><? echo ' Last Login: ' . $_SESSION['last_login'];?></span></a>
            </li>
            <li class="<?php if(basename($_SERVER['PHP_SELF'])=="dashboard.php"){echo "active";} ?>"> 
            <a href="dashboard.php"><i class="ft-home"></i><span class="menu-title" data-i18n="">Dashboard</span></a>
            </li>
          
            
            <!-- MENU FOR ADMIN --------------------------------------------------->


            <? if($_SESSION['admin'] == "yes") {
                echo '
                <li class="nav-item has-sub"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="">Customers</span></a>
                    <ul class="menu-content">
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="customer-create.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="customer-create.php">Create Customer</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="customer-view.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="customer-view.php">View Customers</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub"><a href="#"><i class="ft-file-text"></i><span class="menu-title" data-i18n="">Invoice & Quote</span></a>
                    <ul class="menu-content">
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="invoice-create.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="invoice-create.php">Create New +</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="invoice-list.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="invoice-list.php">View Invoices</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="quote-view.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="quote-view.php">View Quotes</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="invoice.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="sample-invoice.php" target="blank">Sample Invoice</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub"><a href="#"><i class="ft-package"></i><span class="menu-title" data-i18n="">Products</span></a>
                    <ul class="menu-content">
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="product-add.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="product-add.php">Create Product</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="product-view.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="product-view.php">View Products</a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item has-sub"><a href="#"><i class="ft-settings"></i><span class="menu-title" data-i18n="">Settings</span></a>
                    <ul class="menu-content">
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="settings.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="settings.php">General Settings</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="settings_logos.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="settings_logos.php">Logos</a>
                        </li>
                        <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="settings_testmail.php"){echo "active";}?>
                        <? echo '"><a class="menu-item" href="settings_testmail.php">Test Mail</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="files.php"){echo "active";}?>
                <? echo '"><a href="files1.php"><i class="ft-file"></i><span class="menu-title" data-i18n="">All Files</span></a>
                </li>
                <li class="nav-item"><a href="charts.html"><i class="ft-droplet"></i><span class="menu-title" data-i18n="">Other Pages</span></a>
          ';}?>
          

          <!-- MENU FOR USERS --------------------------------------------------->


          <? if($_SESSION['admin'] == "no") {
                echo '
                <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="timesheet.php"){echo "active";}?>
                <? echo '"><a href="timesheet.php"><i class="la la-file-text"></i><span class="menu-title" data-i18n="">Timesheet</span></a>
                </li>
                <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="user_details.php"){echo "active";}?>
                <? echo '"><a href="user_details.php"><i class="la la-user"></i><span class="menu-title" data-i18n="">Your Profile</span></a>
                </li>
                <li class="nav-item '?><? if(basename($_SERVER['PHP_SELF'])=="files.php"){echo "active";}?>
                <? echo '"><a href="files1.php"><i class="la la-upload"></i><span class="menu-title" data-i18n="">' .strtok($_SESSION['name'], " "). '\'s Drive</span></a>
                </li>
            ';}?>

            <!-- MENU FOR ALL USERS ---------------------------------------------->
            <li class="nav-item <? if(basename($_SERVER['PHP_SELF'])=="sites.php"){echo " active";}?>">
                    <a href="sites.php"><i class="ft-target"></i><span class="menu-title" data-i18n="">Site Addresses</span></a>
            </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

<?
if(isset($pVar) && (!empty($pVar))){
$pVar = $pVar;
} else {
$pVar = "Logged in as " . $_SESSION['name'];
}

 // extract the filename
 $title = basename($_SERVER['SCRIPT_FILENAME'], '.php');
 // replace dashes with whitespace
 $title = str_replace(['_','-'], ' ', $title);
 // check if the file is index, if so assign 'home' to the title instead of index
 if (strtolower($title) == 'index') {
 $title = 'home';
 }
 // capitalize all words
 $title = ucwords($title);



$PT = $title;
?>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" 
data-menu="vertical-menu" data-color="bg-chartbg" data-col="2-columns">

<div id="bodyCol" class="app-content content <?if ($dark == "0"){ echo "bg-warning";}else{ echo "bg-secondary";}?>" >
    <div class="content-wrapper">
        <div class="content-wrapper-before">
        </div>
        <div class="content-header row">
            <div class="content-header-left col-md-7 col-12 mb-1">
                <h2 class="content-header-title"><? echo $PT?><? echo '<br><br>' . $pVar?></h2>
            </div>
        </div>