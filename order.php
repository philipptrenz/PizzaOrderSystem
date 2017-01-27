<!DOCTYPE html>
<html lang="de">

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

    <!-- Plugin CSS -->

    <!-- Theme CSS -->
    <link href="css/creative.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand page-scroll" href="#page-top">24h CodeCamp | Pizza Bestell System</a>
            </div>

        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
                
        <div class="header-content">
            <div class="header-content-inner">

<?php

    include 'config.php';

    function foo()
	{
	    echo "<h1 id='homeHeading'>Ups ...</h1><hr>";
    	echo "<p>Da lief wohl was schief :/ <br>Meld dich besser mal bei den Tutoren!</p>";
	}

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, "pizza");
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id VARCHAR(6),
        name VARCHAR(50) NOT NULL,
        cost NUMERIC(15,2) NOT NULL,
        meal INT(6) UNSIGNED NOT NULL,
        ts TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        paid BOOLEAN NOT NULL DEFAULT 0
    );";

    if (!mysqli_query($conn, $sql)) {
        echo "Error creating database: " . mysqli_error($conn);
    }


    // -------------------------- //
    

    if (!empty($_POST["id"]) &&  !empty($_POST["name"])) {

        $id = $_POST["id"];
        $name = $_POST["name"];

        if (!empty($_POST["meal1"]) &&  !empty($_POST["price1"])) {
            $meal = $_POST["meal1"];
            $cost = str_replace(",",".",$_POST["price1"]);
            $sql = " INSERT INTO orders (id, name, cost, meal) VALUES ('$id', '$name', '$cost', '$meal');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        if (!empty($_POST["meal2"]) &&  !empty($_POST["price2"])) {
            $meal = $_POST["meal2"];
            $cost = str_replace(",",".",$_POST["price2"]);
            $sql = " INSERT INTO orders (id, name, cost, meal) VALUES ('$id', '$name', '$cost', '$meal');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        if (!empty($_POST["meal3"]) &&  !empty($_POST["price3"])) {
            $meal = $_POST["meal3"];
            $cost = str_replace(",",".",$_POST["price3"]);
            $sql = " INSERT INTO orders (id, name, cost, meal) VALUES ('$id', '$name', '$cost', '$meal');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }

        echo "<h1 id='homeHeading'>Vielen Dank!</h1><hr>";
    	echo "<p>Deine Bestellung war erfolgreich. <br>Sammel bitte schon mal dein Geld zusammen. <br>Je passender, desto besser!</p>";

    	$_POST = array();
        
    } else {
        foo();
    }
                

    mysqli_close($conn);
?>

            </div>
        </div>
                
    </header>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/creative.min.js"></script>

</body>

</html>
