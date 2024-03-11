<?php
require_once('CsvTools.php');
require_once('WarehouseDBTools.php');
require_once('ShelfDBTools.php');
require_once('ItemsDBTools.php');
require_once('DBWarehouse.php');
require_once('DBShelf.php');
require_once('DBItems.php');

$csvtools = new CsvTools();
$warehouseDbtools = new WarehouseDbTools();
$shelfDbtools = new ShelfDBTools();
$itemsDbtools = new ItemsDBTools();
$dbWarehouse = new DBWarehouse();
$dbShelf = new DBShelf();
$dbItems = new DBItems();

$createWarehouseTable = $dbWarehouse->createTable();
$createShelfTable = $dbShelf->createTable();
$createItemsTable = $dbItems->createTable();

$truncateWarehouseTable = $csvtools->truncateWarehouseTable($warehouseDbtools);
$truncateShelfTable = $csvtools->truncateShelfTable($shelfDbtools);
$truncateItemsTable = $csvtools->truncateItemsTable($itemsDbtools);
