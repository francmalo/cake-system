<?php
include("function.php");
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
    <title>Cake Kitchen</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/images/favicon.png"
    />
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
              <h4 class="page-title">Pricelist</h4>
              <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Categories
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
              <div class="card">
                <div class="card-body">
                  <button id="add-price" type="button" class="btn btn-success btn-sm text-white">
                    <span class="fas fa-plus"></span>
                    Add
                  </button>


                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Price List</h5>
                  <div class="table-responsive">
                    <table  id="zero_config"
                      class="table table-hover table-bordered ">
                      <thead class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Product Name</th>
                          <th>Weight</th>
                          <th>Price</th>
                          <th>On Offer</th>
                          <th>Offer Price</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th> </th>
                          <th> </th>


                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $statement=$connect->prepare("SELECT * FROM pricelist pr INNER JOIN product p ON p.product_id=pr.product_id ORDER BY p.product_name, pr.weight ASC");
                        $statement->execute();
                        $count=0;
                        foreach($statement->fetchAll() as $row){
                          $count++;
                          if($row["on_offer"]==1){
                            $status='<span  class="badge rounded-pill bg-success text-white">
                              Yes
                            </span>';

                          }
                          else{
                            $status='<span  class="badge rounded-pill bg-danger text-white">
                              No
                            </span>';

                          }
                          echo '<tr>
                            <td>'.$count.'</td>
                            <td>'.$row["product_name"].'</td>
                            <td>'.$row["weight"].' Kg</td>
                            <td>'.$row["price"].'</td>
                            <td>'.$status.'</td>
                            <td>'.$row["offer_price"].'</td>
                            <td>'.(($row["start_date"]==null) ? "" : date("d-m-Y", strtotime($row["start_date"]))).'</td>
                            <td>'.(($row["end_date"]==null) ? "" : date("d-m-Y", strtotime($row["end_date"]))).'</td>
                            <td> <button type="button" name="update" id="'.$row["pricelist_id"].'" class="btn btn-warning btn-xs update"><i class="fas fa-edit"></i> update</button></td>
                            <td><button type="button" name="delete" id="'.$row["pricelist_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["pricelist_status"].'"><i class="fas fa-trash"></i> delete</button></td>
                          ';
                        }
                         ?>

                      </tbody>
                      <tfoot class="thead-light">
                        <tr>
                          <th>#</th>
                          <th>Product Name</th>
                          <th>Weight</th>
                          <th>Price</th>
                          <th>On Offer</th>
                          <th>Offer Price</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th> </th>
                          <th> </th>
                        </tr>
                      </tfoot>
                    </table>
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
    <div class="modal fade" id="pricelistModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Price</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <span id="alert_action"></span>
        </div>
        <form id="pricelist_form" >
        <div class="form-group">
        <div class="input-group mb-3">
                    <span style="width:100px" class="input-group-text" id="basic-addon1">Product</i></span>
                    <select class="form-control  form-contrl-sm" name="product_id" required>
            <option value="">--select--</option>
            <?php echo fill_product_list($connect, "") ?>
          </select>
                    </div>


        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
            <div class="input-group mb-3">
                    <span style="width:100px" class="input-group-text" id="basic-addon1">Weight (Kg)</span>
                    <input type="number"  name="weight" class="form-control " placeholder="weight" value=""  aria-label="" aria-describedby="basic-addon1" required>
                    </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
            <div class="input-group mb-3">
                    <span style="width:100px" class="input-group-text" id="basic-addon1">Price (KES)</span>
                    <input type="number"  name="price" class="form-control " placeholder="price" value=""  aria-label="" aria-describedby="basic-addon1" required>
                    </div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group">
                <label for="">Is on Offer</label>
                <input type="checkbox" name="on_offer" id="is-on-offer" class="">
            </div>
        </div>
        <div class="row" id="offer-details" style="display:none">
        <div class="col-md-12">
            <div class="form-group">

            <div class="input-group mb-3">
                    <span style="width:120px" class="input-group-text" id="basic-addon1">Offer Price (KES)</span>
                    <input type="number"  name="offer_price" class="form-control  offer" placeholder="enter offer price" value=""  aria-label="" aria-describedby="basic-addon1">
                    </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">

            <div class="input-group mb-3">
                    <span style="width:120px" class="input-group-text" id="basic-addon1">Start Date</span>
                    <input type="date"  name="start_date" class="form-control  offer" placeholder="Start Date" value=""  aria-label="" aria-describedby="basic-addon1">
                    </div>
            </div>
            </div>
            <div class="col-md-12">

            <div class="form-group">
            <div class="input-group mb-3">
                    <span style="width:120px" class="input-group-text" id="basic-addon1">End Date</span>
                    <input type="date"  name="end_date" class="form-control  offer" placeholder="End Date" value=""  aria-label="" aria-describedby="basic-addon1">
                    </div>
            </div>
            </div>
        </div>

       </div>
      <div class="modal-footer">
        <input type="hidden" name="btn_action" value="add-pricelist">

        <button type="submit"  class="btn btn-primary">Add</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="pricelistModalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Price</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pricelistedit_form" >
        <span id="body-details"></span>
       </div>
      <div class="modal-footer">
        <input type="hidden" name="btn_action" value="edit-pricelist">

        <button type="submit"  class="btn btn-primary">Edit</button>
      </div>
      </form>
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
      $("#zero_config").DataTable();
      $(document).on('click', '#add-price', function(e){
        e.preventDefault();
        $('#pricelist_form')[0].reset();
        $("#pricelistModal").modal('show');
      });
      $(document).on('change', '#is-on-offer', function(e){
        e.preventDefault();
        if($(this).is(':checked')){
            $('#offer-details').css('display', 'block');
            $('.offer').prop('required', true);
        }
        else{
            $('#offer-details').css('display', 'none');
            $('.offer').prop('required', false);
        }
      });
      $(document).on('change', '#is-on-offer-edit', function(e){
        e.preventDefault();
        if($(this).is(':checked')){
            $('#offer-details-edit').css('display', 'block');
            $('.offer').prop('required', true);
        }
        else{
            $('#offer-details-edit').css('display', 'none');
            $('.offer').prop('required', false);
        }
      });

      $(document).on('submit','#pricelist_form', function(event){
  event.preventDefault();

  var form_data = $(this).serialize();
  $.ajax({
   url:"pricelist_action.php",
   method:"POST",
   data:form_data,
   dataType:"html",
   success:function(data)
   {
    if(data.trim()==1){
        $('#alert_action').fadeIn().html('<div class="alert alert-danger">Price already exists</div>');
    }
    else{
        location.reload();
    }
    // $('#category_form')[0].reset();
    // $('#categoryModal').modal('hide');
    // $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
    // $('#action').attr('disabled', false);
    //  location.reload();
   }
  })
 });
 $(document).on('submit','#pricelistedit_form', function(event){
  event.preventDefault();

  var form_data = $(this).serialize();
  $.ajax({
   url:"pricelist_action.php",
   method:"POST",
   data:form_data,
   dataType:"html",
   success:function(data)
   {
    // $('#category_form')[0].reset();
    // $('#categoryModal').modal('hide');
    // $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
    // $('#action').attr('disabled', false);
    //  location.reload();
   }
  })
 });

 $(document).on('click', '.update', function(){
  var pricelist_id = $(this).attr("id");
  var btn_action = 'fetch_single';
  $.ajax({
   url:"pricelist_action.php",
   method:"POST",
   data:{pricelist_id:pricelist_id, btn_action:btn_action},
   dataType:"html",
   success:function(data)
   {
    $('#pricelistModalEdit').modal('show');
    $('#body-details').html(data);
   }
  })
 });

 $(document).on('click', '.delete', function(){
  var pricelist_id = $(this).attr('id');
  var status = $(this).data("status");
  var btn_action = 'delete';
  if(confirm("Are you sure you want to change status?"))
  {
   $.ajax({
    url:"pricelist_action.php",
    method:"POST",
    data:{pricelist_id:pricelist_id, status:status, btn_action:btn_action},
    success:function(data)
    {
    // location.reload();
    }
   })
  }
  else
  {
   return false;
  }
 });
    </script>
  </body>
</html>
