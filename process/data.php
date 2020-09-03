<?php
require_once '../includes/config.php';
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if(isset($_POST['myData'])){
    $obj = json_decode($_POST["myData"]);
    
    $order_id = test_input($obj->order_id);
    $total_amount = test_input($obj->amount);
    $delivery_options = test_input($obj->delivery_option);
    $user_id = test_input($obj->user_id);
    $user_admin_type = test_input($obj->user_admin_type);

    if($delivery_options == "regular") $delivery_option_id = 1;
    if($delivery_options == "same") $delivery_option_id = 2;
    if($delivery_options == "swift") $delivery_option_id = 3;

    $pick_name = test_input($obj->pick_up_details->name);
    $pick_pincode = test_input($obj->pick_up_details->pincode);
    $pick_phone = test_input($obj->pick_up_details->phone);
    $pick_address = test_input($obj->pick_up_details->address);
    $pick_landmark = test_input($obj->pick_up_details->landmark);

    $delivery_details = $obj->delivery_details;

    $sql = "INSERT INTO `order_main` (`order_id`, `total_price`,`user_id`,`order_from`) VALUES ('$order_id', '$total_amount','$user_id', '$user_admin_type')";
    if(mysqli_query($con, $sql)){
        $sql = "INSERT INTO `pick_up_details` (`order_id`, `name`, `address`, `pin`, `phone`, `landmark`) VALUES ('$order_id', '$pick_name', '$pick_address', '$pick_pincode', '$pick_phone', '$pick_landmark')";
        if(mysqli_query($con, $sql)){
            for($i = 0 ; $i < count($delivery_details) ; $i++){
                $deli_name = $delivery_details[$i]->name;
                $deli_pin = $delivery_details[$i]->pin;
                $deli_phone = $delivery_details[$i]->phone;
                $deli_add = $delivery_details[$i]->add;
                $deli_weight = $delivery_details[$i]->weight;
                $deli_landmark = $delivery_details[$i]->landmark;
                $deli_weight_gm = $delivery_details[$i]->weight_gm;
                $deli_aprx_amt = $delivery_details[$i]->aprx_amt;
                $cod_amt = $delivery_details[$i]->cod_amt;
                $amount_self = $delivery_details[$i]->amount_self;
                $cod_self = $delivery_details[$i]->cod_self;
                $sql = "INSERT INTO `delivery_details` (`order_id`, `name`, `address`, `pin`, `phone`, `weight`,`landmark`,`weight_gm`, `aprx_amt`,`cod_amt`, `amount_self`, `cod_self`) VALUES ('$order_id', '$deli_name', '$deli_add', '$deli_pin', '$deli_phone', '$deli_weight', '$deli_landmark','$deli_weight_gm','$deli_aprx_amt','$cod_amt','$amount_self','$cod_self')";
                echo (mysqli_query($con, $sql))?1:0;
            }            
        }else echo 2;
    } else echo 3;
    mysqli_close($con);
}

if(isset($_POST['track_id'])){
    $track_id = $_POST['track_id'];
    if($res=mysqli_query($con,"SELECT name, order_status from delivery_details WHERE order_id='$track_id'")){
        if(mysqli_num_rows($res)>0){
            ?>
            <table class="table table-sm">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                </tr>
            <?php
            while($result = mysqli_fetch_array($res)){
                ?>
                <tr>
                    <th><?=$result['name']?></th>
                    <th><?=$result['order_status']?></th>
                </tr>
                <?php
            }
            echo "</table>";
        }else{
            echo "You don't have any order";
        }        
    }else{
        echo "Please Give a Valid Tracking ID";
    }
}
mysqli_close($con);
?>