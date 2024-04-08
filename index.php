<?php

require_once('AbstractPage.php');
require_once('WarehousesDbTools.php');
require_once('ShelvesDbTools.php');
require_once('InventoryDbTools.php');

$warehousesDbTool = new WarehousesDbTools();
$shelvesDbTool = new ShelvesDbTools();
$inventoryDbTool =  new InventoryDbTools();

AbstractPage::insertHtmlHead();
$warehouses = $warehousesDbTool->getAllWarehouses();
AbstractPage::showDropDown($warehouses);
AbstractPage::showAddItem();

if (isset($_POST["warehouseDropdown"])) {
    $selectedWarehouseId = $_POST["warehouseDropdown"] ? $_POST["warehouseDropdown"] : '';
    $shelves = $shelvesDbTool->getShelvesByWarehouseId($selectedWarehouseId);
    $inventory = $inventoryDbTool->getInventoryByWarehouseId($selectedWarehouseId);

    if (!empty($shelves)) {
        $warehouseName = $shelves[0]['warehouse_name'];
        echo '<h2 class="nev">' . (!empty($warehouseName) ? $warehouseName . ' Raktár:' : '') . '</h2>';
        AbstractPage::showMainTable($shelves, $inventory);
    }
}

if(isset($_POST['delete_shelf'])) {
    $shelfIdToDelete = $_POST['shelf_id'];
    $shelvesDbTool->deleteShelfById($shelfIdToDelete);
    $shelves = $shelvesDbTool->getShelvesByWarehouseId($selectedWarehouseId);
}

if (isset($_POST['modify_shelf'])) {
       
    $modifywarehouseId = $_POST['modify_warehouse_id'];
    $shelfToModify = $shelvesDbTool->getShelfById($modifywarehouseId);
    AbstractPage::showModifyShelf($shelfToModify, $modifywarehouseId);
}

if (isset($_POST['modify_shelf_submit'])) {
    $modifyWarehouseId = $_POST['modify_warehouse_id'];
    $modifiedShelfLine = $_POST['modified_shelf_line'];
    $modifiedItemName = $_POST['modified_item_name'];
    $shelvesDbTool->updateCity($modifyWarehouseId, $modifiedShelfLine, $modifiedItemName);
    $shelves = $shelvesDbTool->getShelvesByWarehouseId($selectedWarehouseId);
}

if(isset($_POST['add_item'])) {
    $newItemName = $_POST['new_item_name'];
    $newShelfLine = $_POST['new_shelf_line'];
    $warehouseId = $selectedWarehouseId;

    if(!empty($newItemName) && !empty($newShelfLine) && !empty($warehouseId)) {
        $shelvesDbTool->addItem($newItemName, $newShelfLine, $warehouseId);
        $shelves = $shelvesDbTool->getShelvesByWarehouseId($warehouseId);
    }
    else {
        echo "Kérlek töltsd ki mindkét mezőt!";
    }
}


?>
