<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pizza-Bestellung | 24h CodeCamp</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Theme CSS -->
    <link href="css/creative.min.css" rel="stylesheet">

</head>

<body id="page-top" style="display: none;">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand page-scroll" href="#page-top">24h CodeCamp | Pizza Bestell System</a>
            </div>

            <div class="navbar-header" style="float: right;">
                <a class="navbar-brand page-scroll" id="auto-update">auto update on</a>
            </div>

        </div>
        <!-- /.container-fluid -->
    </nav>

    <section>
                
        <div class="header-content">
            <div class="header-content-inner">

<?php

    include 'config.php';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, "pizza");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    echo "<h1 id='homeHeading'>Bestellübersicht</h1><br>";


    // Total
    $sql = "SELECT COUNT(*) AS anzahl FROM orders";
    $result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		echo "<p>Es wurden bisher ".$row['anzahl']." Gerichte bestellt</p><br>";
	} else {
	    echo "<p>Noch keine Bestellungen</p><br>";
	}




    // sorted and count by number
    $sql = "SELECT COUNT(`meal`) AS `anzahl`, `meal` FROM `orders` GROUP BY `meal` ORDER BY `meal` ASC";
    $result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {

	    echo "<br><p>";
	    while($row = mysqli_fetch_assoc($result)) {
	        echo  $row["anzahl"]. "x  &nbsp;&nbsp;#" . $row["meal"]."<br>";
	    }
	    echo "</p><br>";
	}




    // sorted by customer
    $sql = "SELECT id, name, SUM(cost) AS total FROM orders GROUP BY id ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

    ?>
        <h2>Zu zahlen</h2><br>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>u-Nummer</th>
                    <th>Gerichte</th>
                    <th>Gesamtsumme</th>
                    <th>Bezahlt</th>
                </tr>
            </thead>
            <tbody>

    <?php
        while($row = mysqli_fetch_assoc($result)) {
            $name = $row["name"];
            $id = $row["id"];
            $total = $row["total"];
            
    ?>
            <tr>
                <td><?php echo  $name ?></td>
                <td><?php echo  $id ?></td>
                <td>

                <?php 

                $sql2 = "SELECT meal, cost, paid FROM orders WHERE id='$id' ORDER BY meal ASC";
                $result2 = mysqli_query($conn, $sql2);

                $paid = true;
                if (mysqli_num_rows($result2) > 0) {
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        echo $row2['meal']." (".$row2['cost']." €)<br>";
                        $paid = $paid && $row2['paid'];
                    }
                } 

                ?>
                </td>
                <td><?php echo  $total ?> €</td>
                <td>
                    <input class="checkbox" type="checkbox" <?php if ($paid) echo "checked='checked'"?> >
                    </td>
            </tr>
    <?php
        }
    ?>             
            </tbody>
        </table>
        <br>

<?php
	}          

    mysqli_close($conn);
?>







            </div>
        </div>
                
    </section>

    <style>
    	body {

            width: 100%;
            height: 100%;

            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

            background-position: center;
            background-image: url(./img/header.jpg);
            color: #fff;

            padding: 0;
            margin: 0;

            position: fixed;
            overflow: hidden;
        }

        table {
            margin: 0 auto;
            text-align: center;
        }

        th {
            text-align: center;
            min-width: 100px;
            padding-bottom: 5px;
            border-bottom: 3px solid white;
        }

        tr td {
            border-bottom: 1px solid white;
            padding: 10px 0;
        }

        tr:last-child td {
            border: none;
        }

        input.checkbox {
            margin: 0 auto;
        }

        section {
        	overflow-y: scroll;

        	text-align: center;

            width: 100%;
            max-width: 1360px;
            height: 100%;

            padding: 70px 0 10px;
            margin: 0 auto;
        }


    </style>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('body').fadeIn(500);
        });

        $(".checkbox").change(function() {

            var id = $(':nth-child(2)', this.parent()).text()

            if(this.checked) {
                console.log(id+' checked');
            }
        });

        reload = setTimeout(function(){
           window.location.reload(1);
        }, 5000);

        $( "#auto-update" ).click(function() {
            if($( "#auto-update" ).text() == "auto update on") {
                $( "#auto-update" ).text("auto update off");
                clearTimeout(reload);
            } else {
                $( "#auto-update" ).text("auto update on");
                reload = setTimeout(function(){
                   window.location.reload(1);
                }, 5000);
            }
        });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/creative.min.js"></script>

</body>

</html>
