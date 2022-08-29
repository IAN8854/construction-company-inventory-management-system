<?php
session_start();
require './include/db.php';
if (!isset($_SESSION['accountid'])) {
    header("LOCATION: adminlogin.php");
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>INVENTORY MANAGEMENT SYSTEM</title>
        <link rel="shortcut icon" type="image/png" href=""/>
        <script src="bootstrap/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="design/bootstrap/js/bootstrap.bundle.min.js"></script>
        <link href="design/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/simple-sidebar.css" rel="stylesheet">
        <link rel="stylesheet" href="fontawesome/css/font-awesome.css">
        <script src="sweetalertresources/sweetalert.js"></script>
        <style>
            #body{
                overflow: auto;
                height: 700px;
            }
            #body::-webkit-scrollbar {
                width: 2px;
            }
            #body::-webkit-scrollbar-track {
                background: #f1f1f1; 
            }

            /* Handle */
            #body::-webkit-scrollbar-thumb {
                background: #888; 
            }

            /* Handle on hover */
            #body::-webkit-scrollbar-thumb:hover {
                background: #555; 
}
.content{
    margin-top: 50px;

}   
.col-lg-10{
       -webkit-box-shadow: 3px 3px 5px 6px #696969;  /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
  -moz-box-shadow:    3px 3px 5px 6px #696969;  /* Firefox 3.5 - 3.6 */
  box-shadow:         3px 3px 5px 6px #696969;  
  padding: 0px;
  border-radius: 10px;
}
        </style>
    </head>
    <body onload="loaddata()" class="bg-secondary">
        <div class="row content">
            <div class="col-lg-1"></div>
            <div class="col-lg-10 bg-light">
                
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
            <a class="navbar-brand bg-white" href="#"><img src="img/sett.png" width="35px;" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="product.php"><span class="fa fa-download"></span> Product In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productout.php"><span class="fa fa-upload"></span> Product Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sales.php"><span class="fa fa-bar-chart"></span> Sales</a>
                    </li>                  
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    
                    <a href="logout.php" class="btn btn-outline-danger text-white my-2 my-sm-0">Logout <span class="fa fa-sign-out"></span></a>
                </form>
            </div>
        </nav>
        <div class="" style="">
            <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-plus"></span> Add Category</button>
                                    <input class="form-control form-control-sm" style="width: 50%;" placeholder="Search Category" id="searchcategory">
                                </div>
                                <div class="card-body bg-light pt-1" id="body">
                                    <div class="bg-info p-2 text-white"><span class="fa fa-list"></span> Categories</div>
                                    <div class="" id="showcategory"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header bg-light text-white">
                                    <button type="button" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#productmodal"><span class="fa fa-plus"></span> Add Product</button>
                                    <input class="form-control form-control-sm" style="width:50%" placeholder="Search Product" id="searchproduct">
                                </div>
                                <div class="card-body bg-light p-0 border-0" id="body">
                                    <div class="bg-info p-2 text-white"><span class="fa fa-list"></span> Product List</div>
                                    <div id="showproduct"></div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form method="post" action="" enctype="multipart/form-data" id="mycatform"> 
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
          <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-list"></span> Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <label hidden for="">Image</label>
          <input hidden type="file" name="catimage" class="form-control" id="catimage" />
          <label for="">Category Name</label>
          <input type="text" id="categoryname" class="form-control form-control-sm" placeholder="">
      </div>
      <div class="modal-footer">
          <button type="button" id="uploadcatimage" onclick="savecategory()" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-save"></span> Save</button>
      </div>
    </div>
  </form>
  </div>
</div>

<!--product modal-->
<div class="modal fade" id="productmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form method="post" action="" enctype="multipart/form-data" id="myform"> 
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
          <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-list"></span> Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <label hidden for="">Product Image</label>
          <input hidden type="file" name="file" class="form-control form-control-sm" id="file" />
          <label for="">Product Description</label>
          <input type="text" id="productdescription" class="form-control form-control-sm" placeholder="">
          <label for="">Stock In</label>
          <input type="text" id="quantity" class="form-control form-control-sm" placeholder="">
          <label for="">Regular Price</label>
          <input type="text" id="price" class="form-control form-control-sm" placeholder="">
          <label for="">Sell Price</label>
          <input type="text" id="sellprice" class="form-control form-control-sm" placeholder="">
          <label for="">Category</label>
          <div id="selectcategory"></div>
      </div>
      <div class="modal-footer">
          <button id="uploadimage" type="button" onclick="saveproduct()" class="btn btn-primary" data-dismiss="modal"><span class="fa fa-save"></span> Save</button>
      </div>
    </div>
      </form>
      
  </div>
</div>
<script>
//        filtering
$(document).ready(function(){
  $("#searchproduct").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#producttable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).ready(function(){
  $("#searchcategory").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#categorytable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

//end filter 1   
    
    
    
    
var catid = 0;
//function changeurl(url){
// var new_url="/simplicityapp/"+url;
// window.history.pushState("data","Title",new_url);
// document.title="unilever";
//}
            function saveproduct(){
            var filename = $('#file').val().replace(/C:\\fakepath\\/i, '');
            var productdescription = $('#productdescription').val();
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var categoryid = $('#categoryid').val();
            var sellprice = $('#sellprice').val();
            $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "sellprice" : sellprice,
                            "filename" : filename,
                            "productdescription" : productdescription,
                            "quantity" : quantity,
                            "price" : price,
                            "categoryid" : categoryid,
                            "saveproduct": '1'
                        },
                        success: function (x) {
                             Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully Saved',
                    showConfirmButton: false,
                    timer: 1500
                    
                });
                 loaddata();
                            
                        }
                    });
        }
        //
        function savecategory(){
            var filename = $('#catimage').val().replace(/C:\\fakepath\\/i, '');
            var categoryname = $('#categoryname').val();
            $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "categoryname" : categoryname,
                            "filename" : filename,
                            "savecategory": '1'
                        },
                        success: function (x) {
                            Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Successfully Saved',
                    showConfirmButton: false,
                    timer: 1500
                });
                loaddata();
                        }
                    });
        }
        //            load data
        function loaddata(){
            var categoryid = '';
            $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "showcategory": '1'
                        },
                        success: function (x) {
                            $('#showcategory').html(x);
                        }
                    });
                    
                    $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "categoryid" : categoryid,
                            "showproduct": '1'
                        },
                        success: function (x) {
                            $('#showproduct').html(x);
                        }
                    });
                    
                    $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "selectcategory": '1'
                        },
                        success: function (x) {
                            $('#selectcategory').html(x);
                        }
                    });
        }
        
        function showproduct(categoryid){
            catid = 1;
            var categoryid = categoryid;
            $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "categoryid" : categoryid,
                            "showproduct": '1'
                        },
                        success: function (x) {
                            $('#showproduct').html(x);
                        }
                    });
        }
        
        function removeproduct(productid) {
                var productid = productid;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "allquery.php",
                            async: false,
                            data: {
                                "productid": productid,
                                "removeproduct": '1'
                            },
                            success: function (x) {
                                Swal.fire(
                                        'Deleted!',
                                        'Record has been deleted.',
                                        'success'
                                        )
                                loaddata();
                            }
                        });

                    }
                })
            }
            
            function removecategory(categoryid) {
                var categoryid = categoryid;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "allquery.php",
                            async: false,
                            data: {
                                "categoryid": categoryid,
                                "removecategory": '1'
                            },
                            success: function (x) {
                                Swal.fire(
                                        'Deleted!',
                                        'Record has been deleted.',
                                        'success'
                                        )
                                loaddata();
                            }
                        });

                    }
                })
            }
        </script>
<script type="text/javascript"> 
//        upload image
$(document).ready(function() { 
            $("#uploadimage").click(function() { 
                var fd = new FormData(); 
                var files = $('#file')[0].files[0]; 
                fd.append('file', files); 
       
                $.ajax({ 
                    url: 'upload.php', 
                    type: 'post', 
                    data: fd, 
                    contentType: false, 
                    processData: false,
                }); 
            }); 
            //******
            $("#uploadcatimage").click(function() { 
                var fd = new FormData(); 
                var files = $('#catimage')[0].files[0]; 
                fd.append('file', files); 
       
                $.ajax({ 
                    url: 'uploadcatimage.php', 
                    type: 'post', 
                    data: fd, 
                    contentType: false, 
                    processData: false,
                }); 
            }); 
            //*********
        }); 
//
    </script>  
            </div>
        </div>
    </body>
</html>