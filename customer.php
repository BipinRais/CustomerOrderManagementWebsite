<!DOCTYPE html>
<html>   
<head>
    <title>Customer Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>EXPORTS COMP8870</h1>
        <h2>Welcome <?php echo isset($_POST['name']) ? $_POST['name'] : 'Customer'; ?> to your orders</h2>
        <table id="order-table">
            <tr>
                <th>Order No</th>
                <th>Product</th>
                <th>Price</th>
                <th>Region</th>
                <th>Tax</th>
                <th>Quantity</th>
                <th>Update +/-</th>
            </tr>
            <form action='update.php' method='GET'>
            <?php
            session_start();

     
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identifier'])) {
               
                $CID = $_POST['identifier'];
                $_SESSION['identifier'] = $_POST['identifier']; 
            } else {
             
                echo "CID is not set!";
            }
            //Code snippet from lecture taken to connect to SQL database
            $host = 'dragon.ukc.ac.uk';
            $dbname = 'br322';
            $user = 'br322';
            $pwd = 'hn!alib';
            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $sql = "SELECT OrderNo, products.name as pname, price, regions.name as rname, tax, quantity 
                        FROM orders 
                        JOIN products ON orders.PID = products.PID 
                        JOIN regions ON orders.RID = regions.RID 
                        WHERE orders.CID = :cid";
                $handle = $conn->prepare($sql);
                $handle->bindParam(':cid', $CID);
                $handle->execute();

                $res = $handle->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    $min_value = -$row['quantity'] + 1;
                    
                    $productClass = 'product-' . strtolower($row['pname']); 

                    echo "<tr class='product-row $productClass'>";
                    echo "<td><input type='hidden' name='orderNo[]' value='".$row['OrderNo']."'>". $row['OrderNo'] . "</td>";
                    echo "<td class='product-name'>" . $row['pname'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['rname'] . "</td>";
                    echo "<td>" . $row['tax'] . "</td>";
                    echo "<td><input type='hidden' name='quantity[]' value='".$row['quantity']."'>" . $row['quantity'] . "</td>";
                    echo "<td><input type='number' min='$min_value' max='10' name='quantities[]' ></td>";
                    echo "</tr>";
                   
                }
                $conn = null;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </table>
        <input type='submit' value='Update'>
        </form>
        <form action='new.php' method='POST'>
            <input type='submit' value='New'>
        </form>
        <input type='button' onclick="location.href='index.php';" value='Exit'>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var productRows = document.querySelectorAll('.product-row');
            productRows.forEach(function(row) {
                var productName = row.querySelector('td:nth-child(2)').innerText; 
                row.addEventListener('click', function() {
                    productRows.forEach(function(r) {
                        if (r.querySelector('td:nth-child(2)').innerText === productName) { 
                            r.classList.toggle('highlight');
                        }
                    });
                });
            });
        });
    </script>
    </div>
</body>
</html>
