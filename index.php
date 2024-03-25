<?php
require_once('AbstractPage.php');
require_once('WarehousesDbTools.php');

// Initialize the WarehousesDbTools object
$warehousesDbTool = new WarehousesDbTools();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve the selected warehouse ID from the form
    $selectedWarehouseId = $_POST["countyDropdown"];

    // Retrieve the shelves and inventory items for the selected warehouse
    // You need to implement these methods in your WarehousesDbTools class
    $shelves = $warehousesDbTool->getShelvesForWarehouse($selectedWarehouseId);
    $inventory = $warehousesDbTool->getInventoryForWarehouse($selectedWarehouseId);

    // Display the shelves and inventory
    echo "<h2>Shelves</h2>";
    echo "<ul>";
    foreach ($shelves as $shelf) {
        echo "<li>Shelf ID: " . $shelf['id'] . ", Shelf Line: " . $shelf['shelf_line'] . "</li>";
    }
    echo "</ul>";

    echo "<h2>Inventory</h2>";
    echo "<ul>";
    foreach ($inventory as $item) {
        echo "<li>Item ID: " . $item['id'] . ", Item Name: " . $item['item_name'] . ", Quantity: " . $item['quantity'] . "</li>";
    }
    echo "</ul>";
}

// Display the HTML form and dropdown
AbstractPage::insertHtmlHead();
$warehouses = $warehousesDbTool->getAllWarehouses();
AbstractPage::showDropDown($warehouses);
?>
