<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "cake_world";

    $connection = new mysqli($host, $user, $password, $dbname);

    if($connection->error){
        echo "Something wents wrong!";
    }

    session_start();

    // Checking for authenticate user
    if(!isset($_SESSION['userName'])){
        header('Location: ' . './login.php');
    }
    else if(isset($_SESSION['userName'])){
        $ck=1;
    }
    else if(!isset($_COOKIE['userName'])){
        header('Location: ' . './login.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cake World!</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .search-wrapper {
                width: fit-content;
                border-bottom: 2px dashed grey;
                padding: 20px 0 10px 0;
                text-align: right;
            }
            .option-title {
                font-size: 2.5rem;
            }
            #sOption {
                font-size: 18px;
                padding: 8px 5px;
            }
            .option-label {
                font-size: 20px;
            }
            .display-btn {
                padding: 7px 15px;
                font-size: 18px;
            }
            
        </style>
    </head>
    <body>
        <div class="search-wrapper">
            <h1 class="option-title">Perform any query</h1>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <label class="option-label" for="sOption">Actions: </label>
                <select name="options" id="sOption" placeholder="Choose an option">
                    <option value="flavor_type">Cake flavor types</option>
                    <option value="inventory_cost_per_pound">Total inventory cost for each cake(per pound)</option>
                    <option value="price_before_discount">Selling price before discount</option>
                    <option value="price_after_discount">Total selling price for each cake(after discount)</option>
                    <option value="profit_loss_single">Profit/loss for each cake</option>
                    <option value="profit_loss_percentage">Profit/loss in percentage</option>
                </select>
                <br><br>
                <input class="display-btn" type="submit" value="Display">
            </form>
        </div>
        <div class="output-wrapper">
            <table class="table table-hover table-striped">
                <?php
                    // checking out flavor
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'flavor_type'){
                            echo '<h1>Available Flavor</h1>';
                            $cmd = 'SELECT fname FROM cakes';

                            if($connection->query($cmd) == TRUE){
                                $result = $connection->query($cmd);

                                while($row = $result->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo $row['fname'] ?></td>
                                    </tr>
                                <?php
                                }
                            }

                        }
                    }
                ?>
                <?php
                    // chacking out inventory costs for each cake.
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'inventory_cost_per_pound'){
                            echo '<h1>Inventory Cost</h1>';
                            $cmd1 = 'SELECT * FROM inventory_cost';
                            $cmd2 = 'SELECT fname FROM cakes';

                            if($connection->query($cmd1) == TRUE && $connection->query($cmd2)==TRUE){
                                $result1 = $connection->query($cmd1);
                                $result2 = $connection->query($cmd2);
                                echo '<tr>'.
                                    '<td>Flavor Name</td>'.
                                    '<td>Material Cost</td>'.
                                    '<td>Transportation Cost</td>'.
                                    '<td>Utility Cost</td>'.
                                    '<td>Space Cost</td>'.
                                    '<td>Staff Cost</td>'.
                                    '<td>Total Cost</td>'.
                                    '</tr>';

                                while($row1 = $result1->fetch_assoc() and $row2 = $result2->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo $row2['fname'] ?></td>
                                        <td><?php echo $row1['material_cost'] ?></td>
                                        <td><?php echo $row1['transportation_cost'] ?></td>
                                        <td><?php echo $row1['utility_cost'] ?></td>
                                        <td><?php echo $row1['space_cost'] ?></td>
                                        <td><?php echo $row1['staff_cost'] ?></td>
                                        <td><?php echo $row1['total_cost'] ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                    }
                ?>
                <?php
                    // chacking out selling price before discount.
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'price_before_discount'){
                            echo '<h1>Price before discount</h1>';
                            $cmd1 = 'SELECT actual_price FROM sells';
                            $cmd2 = 'SELECT fname FROM cakes';

                            if($connection->query($cmd1) == TRUE and $connection->query($cmd2)==TRUE){
                                $result1 = $connection->query($cmd1);
                                $result2 = $connection->query($cmd2);
                                echo '<tr>'.
                                    '<td>Flavor Name</td>'.
                                    '<td>Actual Price</td>'.
                                    '</tr>';

                                while($row1 = $result1->fetch_assoc() and $row2 = $result2->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo $row2['fname'] ?></td>
                                        <td><?php echo $row1['actual_price'] ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                    }
                ?>
                <?php
                    // chacking out total selling price after discount.
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'price_after_discount'){
                            echo '<h1>Total price after discount for each</h1>';
                            $cmd1 = 'SELECT discount_price FROM sells';
                            $cmd2 = 'SELECT fname FROM cakes';

                            if($connection->query($cmd1) == TRUE && $connection->query($cmd2)==TRUE){
                                $result1 = $connection->query($cmd1);
                                $result2 = $connection->query($cmd2);
                                echo '<tr>'.
                                    '<td>Flavor Name</td>'.
                                    '<td>Discount Price</td>'.
                                    '</tr>';

                                while($row1 = $result1->fetch_assoc() and $row2 = $result2->fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo $row2['fname'] ?></td>
                                        <td><?php echo $row1['discount_price'] ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                    }
                ?>
                <?php
                    // chacking out profit/loss in taka.
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'profit_loss_single'){
                            echo '<h1>Profit/Loss for each cake (TK.)</h1>';
                            $cmd1 = 'SELECT * FROM inventory_cost';
                            $cmd2 = 'SELECT fname FROM cakes';
                            $cmd3 = 'SELECT * FROM sells';

                            if($connection->query($cmd1) == TRUE && $connection->query($cmd2)==TRUE && $connection->query($cmd3)){
                                $result1 = $connection->query($cmd1);
                                $result2 = $connection->query($cmd2);
                                $result3 = $connection->query($cmd3);

                                echo '<tr>'.
                                    '<td>Flavor Name</td>'.
                                    '<td>Inventory Cost</td>'.
                                    '<td>Selling Price</td>'.
                                    '<td>Profit(+)/Loss(-)</td>'.
                                    '</tr>';

                                while($row1 = $result1->fetch_assoc() and $row2 = $result2->fetch_assoc() and $row3 = $result3->fetch_assoc()){ 
                                    $inventoryCost = ($row1['material_cost'] * $row3['amount']) + $row1['transportation_cost'] + $row1['utility_cost'] + $row1['space_cost'] + $row1['staff_cost'];
                                    $profitLoss = ($row3['fprice'] - $inventoryCost);
                                    ?>
                                    <tr>
                                        <td><?php echo $row2['fname'] ?></td>
                                        <td><?php echo $inventoryCost ?></td>
                                        <td><?php echo $row3['fprice'] ?></td>
                                        <td><?php if($profitLoss>0){
                                                echo '+' . $profitLoss;
                                            }
                                            else{
                                                echo $profitLoss;
                                            } ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                    }
                ?>
                <?php
                    // chacking out profit/loss in percentage.
                    if(isset($_POST['options'])){
                        if($_POST['options'] == 'profit_loss_percentage'){
                            echo '<h1>Profit/Loss for each cake (Percentage)</h1>';
                            $cmd1 = 'SELECT * FROM inventory_cost';
                            $cmd2 = 'SELECT fname FROM cakes';
                            $cmd3 = 'SELECT * FROM sells';

                            if($connection->query($cmd1) == TRUE && $connection->query($cmd2)==TRUE && $connection->query($cmd3)){
                                $result1 = $connection->query($cmd1);
                                $result2 = $connection->query($cmd2);
                                $result3 = $connection->query($cmd3);

                                echo '<tr>'.
                                    '<td>Flavor Name</td>'.
                                    '<td>Inventory Cost</td>'.
                                    '<td>Selling Price</td>'.
                                    '<td>Profit(+)/Loss(-)</td>'.
                                    '</tr>';

                                while($row1 = $result1->fetch_assoc() and $row2 = $result2->fetch_assoc() and $row3 = $result3->fetch_assoc()){ 
                                    $inventoryCost = ($row1['material_cost'] * $row3['amount']) + $row1['transportation_cost'] + $row1['utility_cost'] + $row1['space_cost'] + $row1['staff_cost'];
                                    $profitLossPercentage = (($row3['fprice'] - $inventoryCost) / $inventoryCost) * 100;
                                    $profitLossPercentage = intval($profitLossPercentage * ($p = pow(10, 3))) / $p;
                                    ?>
                                    <tr>
                                        <td><?php echo $row2['fname'] ?></td>
                                        <td><?php echo $inventoryCost ?></td>
                                        <td><?php echo $row3['fprice'] ?></td>
                                        <td><?php if($profitLossPercentage>0){
                                                echo '+' . $profitLossPercentage . "%";
                                            }
                                            else{
                                                echo $profitLossPercentage . "%";
                                            } ?></td>
                                    </tr>
                                <?php
                                }
                            }
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>