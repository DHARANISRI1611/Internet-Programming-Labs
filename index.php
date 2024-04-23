<?php

class ShoppingCart
{
    private $items = [];
    private $quantities = [];
    private $totalPrice = 0;

    public function addItem($item, $quantity, $price)
    {
        if (array_key_exists($item, $this->items)) {
            
            $this->quantities[$item] += $quantity;
        } else {
     
            $this->items[$item] = $price;
            $this->quantities[$item] = $quantity;
        }

        $this->totalPrice += $quantity * $price;
    }

    public function removeItem($item)
    {
        if (array_key_exists($item, $this->items)) {
            $this->totalPrice -= $this->quantities[$item] * $this->items[$item];
            unset($this->items[$item]);
            unset($this->quantities[$item]);
        }
    }

    public function updateQuantity($item, $quantity)
    {
        if (array_key_exists($item, $this->items)) {
            $this->totalPrice -= $this->quantities[$item] * $this->items[$item];
            $this->quantities[$item] = $quantity;
            $this->totalPrice += $quantity * $this->items[$item];
        }
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getQuantities()
    {
        return $this->quantities;
    }
}

$cart = new ShoppingCart();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    $cart->addItem($item, $quantity, $price);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <h2>Add Item to Cart</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="item">Item:</label><br>
        <input type="text" id="item" name="item"><br><br>
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity"><br><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br><br>
        <input type="submit" value="Add to Cart">
    </form>

    <h2>Shopping Cart</h2>
    <p>Total Price: $<?php echo $cart->getTotalPrice(); ?></p>
    <ul>
        <?php foreach ($cart->getItems() as $item => $price): ?>
            <li><?php echo "$item - Quantity: " . $cart->getQuantities()[$item] . " - Price: $$price"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
