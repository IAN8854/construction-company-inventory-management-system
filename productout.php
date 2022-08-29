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
        <link href="design/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/simple-sidebar.css" rel="stylesheet">
                
        <script src="bootstrap/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="design/bootstrap/js/bootstrap.bundle.min.js"></script>
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
                    <li class="nav-item ">
                        <a class="nav-link" href="product.php"><span class="fa fa-download"></span> Product In</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="productout.php"><span class="fa fa-upload"></span> Product Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sales.php"><span class="fa fa-bar-chart"></span> Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php"><span class="fa fa-info"></span> About Us</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    
                    <a href="logout.php" class="btn btn-outline-danger text-white my-2 my-sm-0">Logout <span class="fa fa-sign-out"></span></a>
                </form>
            </div>
        </nav>
        <div class="" style="">
            <div class="row">
                       
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                        <span class="fa fa-list"></span> Product List
                                    <input class="float-right" style="" onkeyup="myFunction()" placeholder="Search Product" id="searchproduct">
                                </div>
                                <div class="card-body bg-light" id="body">
                                    <div id="showproduct"></div>
                                </div>
                            </div>
                        </div>
                <div class="col-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                        <span class="fa fa-list-alt"></span> Purchases
                                        <input hidden="" class="float-right" type="date" id="mydate" onchange="mydate()" value="<?php echo date('Y-m-d');?>">
                                        <label class="float-right" for="">Date: <?php echo date('M d, Y');?></label>
                                        
                                </div>
                                <div class="card-body bg-light" id="body">
                                    <div id="showhistory"></div>
                                    <div id="showmodal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>

<script>
        function loaddata(){
            var dop = $('#mydate').val();
                    $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "showproductout": '1'
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
                            "dop" : dop,
                            "showhistory": '1'
                        },
                        success: function (x) {
                            $('#showhistory').html(x);
                        }
                    });
        }
     
        </script>
<script type="text/javascript"> 
    function updatepurchase(productoutid){
        var productoutid = productoutid;
        var updateqty = $('#updateqty').val();
        $.ajax({
                type: "POST",
                url: "allquery.php",
                async: false,
                data: {
                    "updateqty" : updateqty,
                    "productoutid" : productoutid,
                    "updatepurchase": '1'
                },
                success: function (x) {
                     loaddata();
                     myalert();
                }
            });
    }
    function updatequantity(productoutid){
        var productoutid = productoutid;
        $.ajax({
                type: "POST",
                url: "allquery.php",
                async: false,
                data: {
                    "productoutid" : productoutid,
                    "updatequantity": '1'
                },
                success: function (x) {
                     $('#showmodal').html(x);
                }
            });
    }
    function deleteout(productoutid){
        var productoutid = productoutid;
       Swal.fire({
            title: 'Are You Sure?',
            text: "You won't be able to revert this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes Delete It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                type: "POST",
                url: "allquery.php",
                async: false,
                data: {
                    "productoutid" : productoutid,
                    "deleteout": '1'
                },
                success: function (x) {
                    loaddata();
                }
            });

            }
        })  
    }
     function pay(){
        Swal.fire({
            title: 'Click "DONE!" For Next Transaction',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Done!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                type: "POST",
                url: "allquery.php",
                async: false,
                data: {
                    "pay": '1'
                },
                success: function (x) {
                    loaddata();
                }
            });

            }
        })
    }
    function myalert() {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
    function saveproductout(productid){
         var productid = productid;
         var quantity = $('#qty').val();
         $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "quantity" : quantity,
                            "productid" : productid,
                            "saveproductout": '1'
                        },
                        success: function (x) {
                            loaddata();
                            myalert();
                        }
                    });
    }
    function productout(productid){
        var productid = productid;
        $.ajax({
                        type: "POST",
                        url: "allquery.php",
                        async: false,
                        data: {
                            "productid" : productid,
                            "productout": '1'
                        },
                        success: function (x) {
                            $('#showmodal').html(x);
                        }
                    });
    }
    function mydate(){
        loaddata();
    }
    
    
    
    function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchproduct");
  filter = input.value.toUpperCase();
  table = document.getElementById("producttableout");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
    </script>   

            </div>
        </div>
    </body>
</html>