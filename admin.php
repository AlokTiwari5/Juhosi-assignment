<?php
session_start();
if ($_SESSION['username'] != 'admin') {
  header('Location: login.html');
  exit();
}

$conn = mysqli_connect('localhost', 'username', 'password', 'database');
$sql = "SELECT * FROM customer";
$result = mysqli_query($conn, $sql);

$customer1_quantity = 0;
$customer1_weight = 0;
$customer1_box_count = 0;
$customer2_quantity = 0;
$customer2_weight = 0;
$customer2_box_count = 0;

while ($row = mysqli_fetch_assoc($result)) {
  if ($row['username'] == 'customer1') {
    $customer1_quantity += $row['quantity'];
    $customer1_weight += $row['weight'];
    $customer1_box_count += $row['box_count'];
  } else if ($row['username'] == 'customer2') {
    $customer2_quantity += $row['quantity'];
    $customer2_weight += $row['weight'];
    $customer2_box_count += $row['box_count'];
  }
}

$total_quantity = $customer1_quantity + $customer2_quantity;
$total_weight = $customer1_weight + $customer2_weight;
$total_box_count = $customer1_box_count + $customer2_box_count;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
</head>
<body>
  <table>
    <tr>
      <th>Item/Customer</th>
      <th>Customer 1</th>
      <th>Customer 2</th>
      <th>Total</th>
    </tr>
    <tr>
      <td>Quantity</td>
      <td><?php echo $customer1_quantity; ?></td>
      <td><?php echo $customer2_quantity; ?></td>
      <td><?php echo $total_quantity; ?></td>
    </tr>
    <tr>
      <td>Weight</td>
      <td><?php echo $customer1_weight; ?></td>
      <td><?php echo $customer2_weight; ?></td>
      <td><?php echo $total_weight; ?></td>
    </tr>
    <tr>
      <td>Box Count</td>
      <td><?php echo $customer1_box_count; ?></td>
      <td><?php echo $customer2_box_count; ?></td>
      <td><?php echo $total_box_count; ?></td>
    </tr>
  </table>
</body>
</html>
