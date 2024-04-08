<?php
 
abstract class AbstractPage {
 
    static function insertHtmlHead()
    {
        echo '<!DOCTYPE html>
    <html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Raktár</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="fontawesome/css/all.css" type="text/css">
    </head>
    <body>
   
    <h1>Ráktarak</h1>';
    }
 
 
    static function showDropDown(array $warehouses)
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <label for="warehouseDropdown">Raktárak:</label>
            <select id="warehouseDropdown" name="warehouseDropdown">
            <option value="">Válassz egy Raktárat</option>';
            foreach ($warehouses as $warehouse) {
                echo '<option value="' . $warehouse['id'] . '">' . $warehouse['name'] . '</option>';
                }
            echo '</select>
            <input type="submit" name="submit" value="Küldés">
        </form>';
    }
    static function showAddItem()
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        if (isset($_POST["warehouseDropdown"])) {
            $selectedWarehouseId = isset($_POST["warehouseDropdown"]) ? $_POST["warehouseDropdown"] : '';
        }
        echo '<input type="hidden" name="warehouse_id" value="' . (isset($selectedWarehouseId) ? $selectedWarehouseId : '') . '">
        <label for="new_item_name">Új Termék neve:</label>
        <input type="text" id="new_item_name" name="new_item_name">
        <label for="new_shelf_line">Polc:</label>
        <input type="text" id="new_shelf_line" name="new_shelf_line">
        <input type="hidden" name="id_warehouse" value="<?php echo $selectedWarehouseId; ?>">
        <input type="submit" name="add_item" value="Hozzáad">
        </form>';
    }
    static function showMainTable(array $shelves, array $inventory)
    {  
        echo '<table>
                <tr>
                    <th>id</th><th>Polcok</th><th>Termékek</th><th>Mennyiség</th><th class="muveletek" colspan="2">Műveletek</th>
                </tr>';
        foreach ($shelves as $shelf) {
            echo '<tr>';
            echo '<td>' . $shelf['id'] . '</td>';
            echo '<td>' . $shelf['shelf_line'] . '</td>';
            echo '<td>' . $shelf['item_name'] . '</td>';
            
                echo ' <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="delete_shelf" value="Törlés"></form></td>';
                echo ' <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="modify_shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="modify_shelf" value="Módosítás"></form></td>';
                echo '</tr>';
        }
        echo '</table>';
    }

    static function showModifyShelf(array $shelfToModify, ?int $modifyWarehouseId)
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="modify_warehouse_id" value="' . $modifyWarehouseId . '">
                <label for="modified_shelf_line">Módosított Polc:</label>
                <input type="text" id="modified_shelf_line" name="modified_shelf_line" value="' . $shelfToModify['shelf_line'] . '">
                <label for="modified_item_name">Módosított Termék:</label>
                <input type="text" id="modified_item_name" name="modified_item_name" value="' . $shelfToModify['item_name'] . '">
                <input type="submit" name="modify_shelf_submit" value="Mentés">
            </form>';
    }
 
}