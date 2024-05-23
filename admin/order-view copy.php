<?php include("function.php");
$order_id=$_GET["id"];
$order_status=get_order_status($connect, $order_id);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="cake, cake kitchen, birthday cake, birthday, cakes, wedding cake, anivessary cakes, chocolate cakes, celebration"
    />
    <meta
      name="description"
      content="Indulge in heavenly delights with our artisanal cakes at Cake Kitchen. Discover a symphony of flavors expertly crafted for every occasion. Order online for delivery or visit our bakery for a slice of pure bliss!"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>Matrix Admin Lite Free Versions Template by WrapPixel</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/images/favicon.png"
    />
    <!-- Custom CSS -->
    <link
      rel="stylesheet"
      type="text/css"
      href="assets/extra-libs/multicheck/multicheck.css"
    />
    <link
      href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
    <link href="dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>

.modal-confirm {
	color: #434e65;
	width: 525px;
}
.modal-confirm .modal-content {
	padding: 20px;
	font-size: 16px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	background: #47c9a2;
	border-bottom: none;
	position: relative;
	text-align: center;
	margin: -20px -20px 0;
	border-radius: 5px 5px 0 0;
	padding: 35px;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 36px;
	margin: 10px 0;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px;
}
.modal-confirm .close {
	position: absolute;
	top: 15px;
	right: 15px;
	color: #fff;
	text-shadow: none;
	opacity: 0.5;
}
.modal-confirm .close:hover {
	opacity: 0.8;
}
.modal-confirm .icon-box {
	color: #fff;
	width: 95px;
	height: 95px;
	display: inline-block;
	border-radius: 50%;
	z-index: 9;
	border: 5px solid #fff;
	padding: 15px;
	text-align: center;
}
.modal-confirm .icon-box i {
	font-size: 64px;
	margin: -4px 0 0 -4px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #eeb711 !important;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border-radius: 30px;
	margin-top: 10px;
	padding: 6px 20px;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #eda645 !important;
	outline: none;
}
.modal-confirm .btn span {
	margin: 1px 3px 0;
	float: left;
}
.modal-confirm .btn i {
	margin-left: 1px;
	font-size: 20px;
	float: right;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
.hh-grayBox {
	background-color: #F8F8F8;
	margin-bottom: 20px;
	padding: 35px;
  margin-top: 20px;
}
.pt45{padding-top:45px;}
.order-tracking{
	text-align: center;
	width: 33.33%;
	position: relative;
	display: block;
}
.order-tracking .is-complete{
	display: block;
	position: relative;
	border-radius: 50%;
	height: 30px;
	width: 30px;
	border: 0px solid #AFAFAF;
	background-color: #f7be16;
	margin: 0 auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
	z-index: 2;
}
.order-tracking .is-complete:after {
	display: block;
	position: absolute;
	content: '';
	height: 14px;
	width: 7px;
	top: -2px;
	bottom: 0;
	left: 5px;
	margin: auto 0;
	border: 0px solid #AFAFAF;
	border-width: 0px 2px 2px 0;
	transform: rotate(45deg);
	opacity: 0;
}
.order-tracking.completed .is-complete{
	border-color: #27aa80;
	border-width: 0px;
	background-color: #27aa80;
}
.order-tracking.completed .is-complete:after {
	border-color: #fff;
	border-width: 0px 3px 3px 0;
	width: 7px;
	left: 11px;
	opacity: 1;
}
.order-tracking p {
	color: #A4A4A4;
	font-size: 16px;
	margin-top: 8px;
	margin-bottom: 0;
	line-height: 20px;
}
.order-tracking p span{font-size: 14px;}
.order-tracking.completed p{color: #000;}
.order-tracking::before {
	content: '';
	display: block;
	height: 3px;
	width: calc(100% - 40px);
	background-color: #f7be16;
	top: 13px;
	position: absolute;
	left: calc(-50% + 20px);
	z-index: 0;
}
.order-tracking:first-child:before{display: none;}
.order-tracking.completed:before{background-color: #27aa80;}

</style>
  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
      <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header" data-logobg="skin5">
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="index.php">
              <!-- Logo icon -->
              <b class="logo-icon ps-2">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img
                  src="assets/images/logo-icon.png"
                  alt="homepage"
                  class="light-logo"
                  width="25"
                />
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text ms-2">
                <!-- dark Logo text -->
                <img
                  src="assets/images/logo-text.png"
                  alt="homepage"
                  class="light-logo"
                />
              </span>
              <!-- Logo icon -->
              <!-- <b class="logo-icon"> -->
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

              <!-- </b> -->
              <!--End Logo icon -->
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
              ><i class="ti-menu ti-close"></i
            ></a>
          </div>
          <!-- ============================================================== -->
          <!-- End Logo -->
          <!-- ============================================================== -->
          <div
            class="navbar-collapse collapse"
            id="navbarSupportedContent"
            data-navbarbg="skin5"
          >
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-start me-auto">
              <li class="nav-item d-none d-lg-block">
                <a
                  class="nav-link sidebartoggler waves-effect waves-light"
                  href="javascript:void(0)"
                  data-sidebartype="mini-sidebar"
                  ><i class="mdi mdi-menu font-24"></i
                ></a>
              </li>

              <!-- Search -->
              <!-- ============================================================== -->
              <!-- <li class="nav-item search-box">
                <a
                  class="nav-link waves-effect waves-dark"
                  href="javascript:void(0)"
                  ><i class="mdi mdi-magnify fs-4"></i
                ></a>
                <form class="app-search position-absolute">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search &amp; enter"
                  />
                  <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                </form>
              </li> -->
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
              <!-- ============================================================== -->
              <!-- Comment -->
              <!-- ============================================================== -->
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="mdi mdi-bell font-24"></i>
                </a>
                <!-- <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider" /></li>
                  <li>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </li>
                </ul> -->
              </li>
              <!-- ============================================================== -->
              <!-- End Comment -->
              <!-- ============================================================== -->
              <!-- ============================================================== -->
              <!-- Messages -->
              <!-- ============================================================== -->
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle waves-effect waves-dark"
                  href="#"
                  id="2"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="font-24 mdi mdi-comment-processing"></i>
                </a>
                <ul
                  class="
                    dropdown-menu dropdown-menu-end
                    mailbox
                    animated
                    bounceInDown
                  "
                  aria-labelledby="2"
                >
                  <ul class="list-style-none">
                    <li>
                      <div class="">
                        <!-- Message -->
                        <a href="javascript:void(0)" class="link border-top">
                          <div class="d-flex no-block align-items-center p-10">
                            <span
                              class="
                                btn btn-success btn-circle
                                d-flex
                                align-items-center
                                justify-content-center
                              "
                              ><i class="mdi mdi-calendar text-white fs-4"></i
                            ></span>
                            <div class="ms-2">
                              <h5 class="mb-0">Event today</h5>
                              <span class="mail-desc"
                                >Just a reminder that event</span
                              >
                            </div>
                          </div>
                        </a>

                      </div>
                    </li>
                  </ul>
                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- End Messages -->
              <!-- ============================================================== -->

              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
              <li class="nav-item dropdown">
                <a
                  class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                    pro-pic
                  "
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <img
                    src="assets/images/users/1.jpg"
                    alt="user"
                    class="rounded-circle"
                    width="31"
                  />
                </a>
                <ul
                  class="dropdown-menu dropdown-menu-end user-dd animated"
                  aria-labelledby="navbarDropdown"
                >
                  <a class="dropdown-item" href="profile.php"
                    ><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a
                  >
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php"
                    ><i class="fa fa-power-off me-1 ms-1"></i> Logout</a
                  >

                </ul>
              </li>
              <!-- ============================================================== -->
              <!-- User profile and search -->
              <!-- ============================================================== -->
            </ul>
          </div>
        </nav>
      </header>
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="index.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-view-dashboard"></i
                  ><span class="hide-menu">Dashboard</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="orders.php?search=all"
                  aria-expanded="false"
                  ><i class="mdi mdi-chart-bar"></i
                  ><span class="hide-menu">Orders</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="invoices.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-currency-usd"></i
                  ><span class="hide-menu">Invoices</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="product.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-chart-bubble"></i
                  ><span class="hide-menu">Products</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="customers.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-border-inside"></i
                  ><span class="hide-menu">Customers</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="category.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-blur-linear"></i
                  ><span class="hide-menu">Category</span></a
                >
              </li>

              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="payments.php"
                  aria-expanded="false"
                  ><i class="mdi mdi-database"></i
                  ><span class="hide-menu">Payments</span></a
                >
              </li>

            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Order Details</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Library
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
          <!-- ============================================================== -->
          <!-- Start Page Content -->
          <!-- ============================================================== -->
          <div class="row">
            <div class="col-12">
              <div class="card ">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 ">
                    <?php
                    if($order_status== 0){
                      echo '<button id="confirm_order" order_id="'.$order_id.'" type="button" class="btn btn-primary btn-sm">
                      <span class="fas fa-check1"></span>
                      Confirm Order
                    </button>
                      &nbsp;
                      <button id="cancel_order" type="button" class="btn btn-danger btn-sm">
                        <span class="fas fa-times"></span>
                        Cancel Order
                      </button>&nbsp;';
                      echo get_invoice_status($connect, $order_id);
                    }
                    if($order_status== 1){
                      echo '<button type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Confirmed
                    </button>
                      &nbsp;
                      <button id="dispatch_order" order_id="'.$order_id.'" type="button" class="btn btn-primary btn-sm" text-white>
                        <span class="fas fa-times1"></span>
                        Dispatch Order
                      </button>&nbsp;';
                      echo get_invoice_status($connect, $order_id);
                    }
                    if($order_status== 2){
                      echo '<button  type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Confirmed
                    </button>
                      &nbsp;
                      <button  type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Dispatched
                    </button>
                      &nbsp;
                      <button id="deliver_order" type="button" order_id="'.$order_id.'" class="btn btn-primary btn-sm text-white">
                      <span class="fas fa-check1"></span>
                      Deliver Order
                    </button>
                      &nbsp;
                      ';
                      echo get_invoice_status($connect, $order_id);
                    }
                    if($order_status== 3){
                      echo '<button  type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Confirmed
                    </button>
                      &nbsp;
                      <button  type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Dispatched
                    </button>
                      &nbsp;
                      <button  type="button" class="btn btn-success btn-sm text-white">
                      <span class="fas fa-check"></span>
                      Delivered
                    </button>
                      &nbsp;
                      ';
                      echo get_invoice_status($connect, $order_id);
                    }
                    if($order_status== 4){
                      echo '<button type="button" class="btn btn-danger btn-sm">
                      <span class="fas fa-check1"></span>
                      Order Cancelled
                    </button>
                      &nbsp;
                      ';
                      // echo get_invoice_status($connect, $order_id);
                    }
                    if($order_status== 5){
                      echo '<button type="button" class="btn btn-warning btn-sm">
                      <span class="fas fa-check1"></span>
                      Draft Order
                    </button>
                      &nbsp;
                      ';
                      // echo get_invoice_status($connect, $order_id);
                    }
                     ?>





                    </div>
                    <div class="col-md-6">
                    <button
                        type="button"
                        class="btn btn-default btn-sm "
                      >
                      <span class="fas fa-print"></span>
                        Print Order
                      </button>
                    </div>
                  </div>


                </div>
              </div>
              <!-- <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Basic Datatable</h5>

                </div>
              </div> -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title text-center">CAKE ORDER </h3>
                  <div class=" ">
                   <div class="row d-flex justify-content-center align-items-center h-100">
                     <div class="col-12 col-lg-12 col-xl-12">
                       <div class="card" style="border-radius: 10px;">
                         <!-- <div class="card-header px-4 py-5">
                           <h5 class="text-muted mb-0">Thanks for your Order, <span style="color: #a8729a;">Anna</span>!</h5>
                         </div> -->
                        <div class="col-md-12 p-4">
                          <div class="d-flex justify-content-between pt-2">
                            <p class="fw-bold mb-0">John Munaa</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Total</span> $898.00</p>
                          </div>

                          <div class="d-flex justify-content-between pt-2">
                            <p class="text-muted mb-0">Invoice Number : 788152</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Discount</span> $19.00</p>
                          </div>


                          <div class="d-flex justify-content-between">
                            <p class="text-muted mb-0">Invoice Date : 22 Dec,2019</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">GST 18%</span> 123</p>
                          </div>

                          <div class="d-flex justify-content-between mb-5">
                            <p class="text-muted mb-0">Recepits Voucher : 18KU-62IIK</p>
                            <p class="text-muted mb-0"><span class="fw-bold me-4">Delivery Charges</span> Free</p>
                          </div>

                        </div>
                         <div class="card-body p-4">
                           <h4 class="card-title">Order Details</h4>
                           <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                             <p class="lead fw-normal mb-0" style="color: #a8729a;">Receipt</p>
                             <p class="small text-muted mb-0">Receipt Voucher : 1KAU9-84UIL</p>
                           </div> -->
                           <?php
                           $statement=$connect->prepare("SELECT * FROM orderline o INNER JOIN product p ON p.product_id=o.product_id WHERE order_id=:order_id");
                           $statement->execute(array(":order_id"=>$order_id));
                           $count=0;
                           foreach($statement->fetchAll() as $row){
                            echo '
                            <div class="card shadow-0 border mb-4">
                             <div class="card-body">
                               <div class="row">
                                 <div class="col-md-2">
                                   <img height="80px" src="pic/img.jpg"
                                     class="" alt="Phone">
                                 </div>
                                 <div class="col-md-5">
                                   <p class="text-muted mb-0"><b>'.$row["product_name"].'</b><br>
                                   '.$row["product_desc"].'<br><br>
                                   </p>
                                 </div>
                                 <div class="col-md-5 ">
                                   <p class="text-muted mb-0 "><b>Additional Info</b><br>'.$row["custom_desc"].'</p>
                                 </div>

                               </div>


                             </div>
                           </div>
                            ';
                           }
                           ?>



                         </div>
                         <div class="card-footer border-0 px-4 py-5"
                           style="background: white;">
                           <div class="row">
                             <div class="col-md-6">
                              <p>Total Cost: 6,500</p>
                              <p>Deposit: 3,000</p>
                              <p>Outstanding Balance: 3,500</p>
                             </div>
                             <div class="col-md-6">

                             </div>
                           </div>
                           <?php echo order_tracking($connect, $order_id) ?>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- End PAge Content -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Right sidebar -->
          <!-- ============================================================== -->
          <!-- .right-sidebar -->
          <!-- ============================================================== -->
          <!-- End Right sidebar -->
          <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
          All Rights Reserved by Matrix-admin. Designed and Developed by
          <a href="https://www.wrappixel.com">WrapPixel</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <div id="myModal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="icon-box">
					<i class="fas fa-check"></i>
				</div>

			</div>
			<div class="modal-body text-center">
				<h4>Order Confirmed!</h4>
				<p>Order has been confirmed successfully.</p>
				<button class="btn btn-success" data-dismiss="modal"><span>Generate Invoice &nbsp;</span> <i class="fas fa-list"></i></button>
			</div>
		</div>
	</div>
</div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script>
      /****************************************
       *       Basic Table                   *
       ****************************************/
       $(document).on('click', '#confirm', function(e){
         e.preventDefault();
         $("#myModal").modal('show');
       });
       $(document).on('click', '#confirm_order', function(e){
         e.preventDefault();
         var order_id = $(this).attr("order_id");
         var btn_action = "confirm_order";
         if(confirm("You are confirming order no "+ order_id)){
           $.ajax({
             url:"order_action.php",
             method:"POST",
             data:{order_id:order_id, btn_action:btn_action},
             dataType:"html",
             success:function(data)
             {
               location.reload();
             }
            })

         }
         else {
           return false;
         }
       });
       $(document).on('click', '#dispatch_order', function(e){
         e.preventDefault();
         var order_id = $(this).attr("order_id");
         var btn_action = "dispatch_order";
         if(confirm("You are dispatching order no "+ order_id)){
           $.ajax({
             url:"order_action.php",
             method:"POST",
             data:{order_id:order_id, btn_action:btn_action},
             dataType:"html",
             success:function(data)
             {
               location.reload();
             }
            })

         }
         else {
           return false;
         }
       });

       $(document).on('click', '#deliver_order', function(e){
         e.preventDefault();
         var order_id = $(this).attr("order_id");
         var btn_action = "deliver_order";
         if(confirm("You are dispatching order no "+ order_id)){
           $.ajax({
             url:"order_action.php",
             method:"POST",
             data:{order_id:order_id, btn_action:btn_action},
             dataType:"html",
             success:function(data)
             {
               location.reload();
             }
            })

         }
         else {
           return false;
         }
       });
    </script>
  </body>
</html>
