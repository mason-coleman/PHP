<?php
$conn = mysqli_connect("localhost", "root", "", "dbfiaug8nfffhs");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <h1>🦉 The Two Owls Café</h1>
    <p>Hours of Operation: 11am – 10pm</p>
</head>
<body>

<form method="get" action="process_order.php" onsubmit="return validateOrder()">

    <?php
    $result = mysqli_query($conn, "SELECT * FROM menu");
    while ($item = mysqli_fetch_assoc($result)) {
    ?>
    <div>
        <img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="150">
        <h2><?php echo $item['name']; ?></h2>
        <p><?php echo $item['description']; ?></p>
        <p>$<?php echo number_format($item['price'], 2); ?></p>
        <label>Quantity:
            <select name="item_<?php echo $item['id']; ?>">
                <?php for ($i = 0; $i <= 10; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </label>
    </div>
    <hr>
    <?php } ?>

    <!-- Step 4: Customer fields -->
    <label>First Name: <input type="text" name="first_name"></label>
    <label>Last Name: <input type="text" name="last_name"></label>
    <br>
    <label>Special Instructions:<br>
        <textarea name="special_instructions" rows="4" cols="50"></textarea>
    </label>
    <br>
    <input type="hidden" name="pickup_time" id="pickup_time">

    <!-- Step 5: Submit button -->
    <br>
    <button type="submit">Submit Order</button>

</form>

<script>
function validateOrder() {
    // Step 7a: Check at least one item ordered
    const selects = document.querySelectorAll('select[name^="item_"]');
    let totalItems = 0;
    selects.forEach(select => {
        totalItems += parseInt(select.value);
    });
    if (totalItems === 0) {
        alert('Please order at least one item.');
        return false;
    }

    // Step 7b: Check first and last name
    const firstName = document.querySelector('input[name="first_name"]').value.trim();
    const lastName = document.querySelector('input[name="last_name"]').value.trim();
    if (firstName === '' || lastName === '') {
        alert('Please enter your first and last name.');
        return false;
    }

    // Step 8: Calculate pickup time (20 minutes from now)
    const now = new Date();
    now.setMinutes(now.getMinutes() + 20);
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    document.getElementById('pickup_time').value = hours + ':' + minutes;

    return true;
}
</script>

</body>
</html>