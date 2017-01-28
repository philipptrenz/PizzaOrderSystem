<?php

    header('Content-Type: application/json');

    include 'config.php';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $all = array();



    // Total
    $sql = "SELECT COUNT(*) AS anzahl FROM orders";
    $result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$all['total_orders'] = $row['anzahl'];
	} else {
	    $all['total_orders'] = 0;
	}






    // sorted and count by number
    $sql = "SELECT COUNT(`meal`) AS `total`, `meal` FROM `orders` GROUP BY `meal` ORDER BY `meal` ASC";
    $result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {

        $per_meal = array();

        $i = 0;
	    while($row = mysqli_fetch_assoc($result)) {

            $per_meal[$i] = array();

            $per_meal[$i]["meal"] = $row["meal"];
            $per_meal[$i]["total"] = $row["total"];

            $i++;
	    }

        $all['per_meal'] = $per_meal;
	}



    // sorted by customer
    $sql = "SELECT id, name, SUM(cost) AS total FROM orders GROUP BY id, name ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
        $per_customer = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {

            $myrow = array();

            $myrow['name'] = $row["name"];
            $myrow['id'] = $row["id"];
            $myrow['total'] = $row["total"];
            $overview = array();
            $paid = true;


            $sql2 = "SELECT meal, cost, paid FROM orders WHERE id='" . $row["id"] . "' ORDER BY meal ASC";
            $result2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($result2) > 0) {
                $j = 0;
                while($row2 = mysqli_fetch_assoc($result2)) {


                    $overview[$j] = array();

                    $overview[$j]['meal'] = $row2['meal'];
                    $overview[$j]['cost'] = $row2['cost'];

                    $paid = $paid && $row2['paid'];

                    $j++;
                }

            } 

            $myrow['overview'] = $overview;
            $myrow['paid'] = $paid;

            $per_customer[$i] = $myrow;

            $i++;
        }
        
        $all['per_customer'] = $per_customer;

	}          
    echo json_encode($all);
    mysqli_close($conn);
?>