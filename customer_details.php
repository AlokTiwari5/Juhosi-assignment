<?php
session_start();
if ($_SESSION['username'] != 'admin') {
  header('Location: login.html');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $orderDate = $_POST['order_date'];
  $company = $_POST['company'];
  $owner = $_POST['owner'];
  $item = $_POST['item'];
  $quantity = $_POST['quantity'];
  $weight = $_POST['weight'];
  $requestForShipment = $_POST['request_for_shipment'];
  $trackingID = $_POST['tracking_id'];
  $shipmentSize = $_POST['shipment_size'];
  $boxCount = $_POST['box_count'];
  $specification = $_POST['specification'];

  $conn = mysqli_connect('localhost', 'username', 'password', 'database');
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $username = $_SESSION['username'];

  $sql = "INSERT INTO customer (username, order_date, company, owner, item, quantity, weight, request_for_shipment, tracking_id, shipment_size, box_count, specification)
          VALUES ('$username', '$orderDate', '$company', '$owner', '$item', '$quantity', '$weight', '$requestForShipment', '$trackingID', '$shipmentSize', '$boxCount', '$specification')";

  if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header('Location: customer.php');
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Customer Form</title>
</head>
<body>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <label for="order_date">Order Date:</label>
    <input type="date" id="order_date" name="order_date" required><br><br>
    <label for="company">Company:</label>
    <input type="text" id="company" name="company" pattern="[A-Za-z0-9]+" required><br><br>
    <label for="owner">Owner:</label>
    <input type="text" id="owner" name="owner" pattern="[A-Za-z0-9]+" required><br><br>
    <label for="item">Item:</label>
    <input type="text" id="item" name="item" required><br><br>
    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" min="1" required><br><br>
    <label for="weight">Weight:</label>
    <input type="number" id="weight" name="weight" step="0.01" min="0.01" required><br><br>
    <label for="request_for_shipment">Request for Shipment:</label>
    <input type="text" id="request_for_shipment" name="request_for_shipment" required><br><br>
    <label for="tracking_id">Tracking ID:</label>
    <input type="text" id="tracking_id" name="tracking_id" required><br><br>
    <label for="shipment_size">Shipment Size:</label>
    <input type="text" id="shipment_size" name="shipment_size" required><br><br>
    <label for="box_count">Box Count:</label>
    <input type="number" id="box_count" name="box_count" min="1" required><br><br>
    <label for="specification">Specification:</label>
    <textarea id="specification" name="specification" required></textarea><br><br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
