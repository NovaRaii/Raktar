<?php

require_once('AbstractPage.php');
require_once('WarehousesDbTools.php');
require_once('ShelvesDbTools.php');
require_once('InventoryDbTools.php');

$warehousesDbTool = new WarehousesDbTools();
$shelvesDbTool = new ShelvesDbTools();

AbstractPage::insertHtmlHead();
$warehouses = $warehousesDbTool->getAllWarehouses();
AbstractPage::showDropDown($warehouses);

if (isset($_POST["warehouseDropdown"])) 
    {
        $selectedWarehouseId = isset($_POST["warehouseDropdown"]) ? $_POST["warehouseDropdown"] : '';
        $shelves = $shelvesDbTool->getShelvesByWarehouseId($selectedWarehouseId);
        
        
        if (!empty($shelves)) {
            $warehouseName = $shelves[0]['warehouse_name'];
            echo '<h2 class="nev">' . (!empty($warehouseName) ? $warehouseName . ' Raktár:' : '') . '</h2>';
            AbstractPage::showMainTable($shelves);
        }
    }


if(isset($_POST['delete_shelf'])) {
    $shelfIdToDelete = $_POST['shelf_id'];
    $shelvesDbTool->deleteShelfById($shelfIdToDelete);
    $shelves = $shelvesDbTool->getShelvesByWarehouseId($selectedWarehouseId);
}

if (isset($_POST['modify_items'])) {
       
    $modifyItemId = $_POST['modify_item_id'];
    $itemToModify = $inventoryDbTool->getItemById($modifyItemId);
    AbstractPage::showModifyItems($itemToModify, $modifyItemId);
}
if (isset($_POST['modify_item_submit'])) {
    $modifyItemId = $_POST['modify_item_id'];
    $modifiedItemName = $_POST['modified_item_name'];
    $modifiedItemShelf = $_POST['modified_item_shelf'];
    $inventoryDbTool->updateItem($modifyItemId, $modifiedItemName, $modifiedItemShelf);
    $items = $inventoryDbTool->getItemsByShelfId($selectedShelfId);
}

?>
