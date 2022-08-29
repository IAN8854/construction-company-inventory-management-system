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
        <link rel="stylesheet" href="fontawesome/css/font-awesome.css">
        <script src="sweetalertresources/sweetalert.js"></script>
        <script src="canvas.js"></script>
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
                            <li class="nav-item ">
                                <a class="nav-link" href="productout.php"><span class="fa fa-upload"></span> Product Out</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="sales.php"><span class="fa fa-bar-chart"></span> Sales</a>
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

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <span class="fa fa-bar-chart-o"></span> Sales Graph |
                                    
                                    <span><b>YEAR: </b></span>
                                    <select name="" id="myyear" onchange="myyear()" class="">
                                        <?php
                                        $currentyear = date('Y');
                                    for ($x = $currentyear; $x >= 2009; $x--) {
                                        echo '<option value="'.$x.'">'.$x.'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="card-body bg-light">
                                    <div id="showsalesgraph"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <span class="fa fa-bar-chart-o"></span> Sales Report |
                                    <span><b>FROM: </b></span>
                                    <input class="" type="date" id="mydatefrom" onchange="mydate()" value="<?php echo date('Y-m-d'); ?>">
                                    <span><b>TO: </b></span>
                                    <input class="" type="date" id="mydateto" onchange="mydate()" value="<?php echo date('Y-m-d'); ?>">
                                    <span><b>TAX (%): </b></span>
                                    <input class="" type="number" id="tax">
                                    <button onclick="searchreport()">Search</button>
                                </div>
                                <div class="card-body bg-light" id="">
                                    <div id="showhistory"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function myyear(){
                        loaddata();
                    }
                    function loaddata() {
                        var myyear = $('#myyear').val();
                        $.ajax({
                            type: "POST",
                            url: "allquery.php",
                            async: false,
                            data: {
                                "myyear" : myyear,
                                "showsalesgraph": '1'
                            },
                            success: function (x) {
                                $('#showsalesgraph').html(x);
                            }
                        });
                    }
                    function searchreport() {
                        var mydatefrom = $('#mydatefrom').val();
                        var mydateto = $('#mydateto').val();
                        var tax = $('#tax').val();
                        $.ajax({
                            type: "POST",
                            url: "allquery.php",
                            async: false,
                            data: {
                                "tax" : tax,
                                "mydatefrom": mydatefrom,
                                "mydateto": mydateto,
                                "showsalesreport": '1'
                            },
                            success: function (x) {
                                $('#showhistory').html(x);
                            }
                        });
                    }
                </script>

                <script src="bootstrap/jquery.js"></script>
                <script src="bootstrap/js/bootstrap.js"></script>
                <script src="design/bootstrap/js/bootstrap.bundle.min.js"></script>
            </div>
        </div>
    </body>
</html>