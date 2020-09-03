<?php if(!isset($_SESSION)) session_start();
 require_once('../include/top.php'); ?>
<script>    
    function do_print(){
        window.print();
        window.onmousemove = function() {window.close(); }
    }
</script>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<body onload="do_print()">
<?php
$user_id = $_SESSION['id'];
$cnt = 1;

if(isset($_GET['from']) && isset($_GET['to'])){
    if(!empty($_GET['from']) && !empty($_GET['to'])){
        $from_date = $_GET['from'];
        $to_date = $_GET['to'];
        //Data between two days
        $sql = "SELECT * FROM `order_main` WHERE order_from = $user_id AND DATE(`datetime`) BETWEEN '$from_date' AND '$to_date';";
    }else{
        echo "<center><h1>Choose Proper Date</h1></center>"; 
        exit();
    }
}
if(isset($_GET['for'])){
    if($_GET['for']=='today'){
        //Today data
        $sql = "SELECT * FROM `order_main` WHERE order_from = $user_id AND DATE(`datetime`) = CURDATE()";
    }else if($_GET['for']=='yesterday'){
        //Yesterday data
        $sql = "SELECT * FROM `order_main` WHERE order_from = $user_id AND DATE(`datetime`) = CURDATE() - 1";
    }
}

if(isset($_GET['orderid'])){
    if(!empty($_GET['orderid'])){
        $orderid = $_GET['orderid'];
        //for individual
        $sql = "SELECT * FROM `order_main` WHERE order_from = $user_id AND `order_id` = '$orderid'";
    }else{
        echo "<center><h1>Choose Proper Date</h1></center>"; 
        exit();
    }
}

if(isset($_GET['ind_from']) && isset($_GET['ind_to']) && isset($_GET['ind_user'])){
    if(!empty($_GET['ind_from']) && !empty($_GET['ind_to'])){
        $from_date = $_GET['ind_from'];
        $to_date = $_GET['ind_to'];
        $ind_user = $_GET['ind_user'];
        //Data between two days
        $sql = "SELECT * FROM `order_main` WHERE order_from = $ind_user AND DATE(`datetime`) BETWEEN '$from_date' AND '$to_date';";
    }else{
        echo "<center><h1>Choose Proper Date</h1></center>"; 
        exit();
    }
}

$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    ?>
    <table style="width:55rem;border-collapse: collapse;" border=1>
        <tbody>
            <tr>
                <th></th>
                <th style="width:7rem">Order Number</th>
                <th style="width:20rem">PickUp Details</th>
                <th>Delivery Details</th>
            </tr>
    <?php
    while($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['order_id'];
        $sql0 = "SELECT * FROM `pick_up_details` WHERE `order_id`='$order_id'";
        $row0 = mysqli_fetch_assoc(mysqli_query($con, $sql0));
        ?>    
            <tr style="font-size: 0.7rem;line-height: initial;">
                <td><?=$cnt;$cnt++?></td>
                <td><?=$order_id?></td>
                <td><?=$row0['name'].", ".$row0['address'].", ".$row0['pin'].", ".$row0['landmark'].", ".$row0['phone']?></td>
        <?php        
        $sql1 = "SELECT * FROM `delivery_details` WHERE `order_id`='$order_id' AND `delivery_details`.`cod_amt` > 0";
        $result1 = mysqli_query($con, $sql1);
        if (mysqli_num_rows($result1) > 0) {
            echo "<td>";
            while($row1 = mysqli_fetch_assoc($result1)) {            
                ?>
                <div style="width:60%;display:inline-block">
                    <?=$row1['name'].", ".$row1['address'].", ".$row1['pin'].", ".$row1['landmark'].", ".$row1['phone']?>
                </div>
                <div style="width:30%;display:inline-block;text-align:right"><?=$row1['cod_amt'].""?></div>
                <hr style="margin:0;border-top: 3px solid #eeeeee;">
                <?php    
            }            
            echo "</td>";            
        }else{
            echo "<td>No COD of this Order</td>";
        }        
    }
    echo "</tr></tbody></table>";
    } else {
    echo "0 results";
}
mysqli_close($con);
?>
</body>