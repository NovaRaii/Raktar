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
    static function showAddCity()
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        if (isset($_POST["warehouseDropdown"])) {
            $selectedWarehouseId = isset($_POST["warehouseDropdown"]) ? $_POST["warehouseDropdown"] : '';
        }
        echo '<input type="hidden" name="warehouse_id" value="' . (isset($selectedWarehouseId) ? $selectedWarehouseId : '') . '">
        <label for="new_item_name">Új termék neve:</label>
        <input type="text" id="new_item_name" name="new_item_name">
        <label for="new_shelf_line">Polc száma:</label>
        <input type="text" id="new_shelf_line" name="new_shelf_line">
        <input type="hidden" name="id_warehouse" value="<?php echo $selectedWarehouseId; ?>">
        <input type="submit" name="add_item" value="Hozzáad">
        </form>';
    }
    static function showMainTable(array $shelves) 
    {   
        echo '<table>
                <tr>
                    <th>id</th><th>Polcok</th><th>Termékek</th><th class="muveletek" colspan="2">Műveletek</th>
                </tr>';
        foreach ($shelves as $shelf) {
            echo '<tr>';
            echo '<td>' . $shelf['id'] . '</td>';
            echo '<td>' . $shelf['shelf_line'] . '</td>';
            if (!empty($shelf['inventory'])) {
                foreach ($shelf['inventory'] as $item) {
                    echo '<td>' . $item['item_name'] . '</td>';
                }
            } else {  
                echo '<td colspan="2">Nincsenek termékek a polcon</td>';
            }   
                echo ' <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="delete_shelf" value="Törlés"></form></td>';
                echo ' <td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="modify_shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="modify_shelf" value="Módosítás"></form></td>';
                echo '</tr>';
        }
        echo '</table>';
    }
    static function showModifyItems(array $itemToModify, ?int $modifyItemId)
    {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="modify_item_id" value="' . $modifyItemId . '">
                <label for="modified_city_name">Módosított termék neve:</label>
                <input type="text" id="modified_item_name" name="modified_item_name" value="' . $itemToModify['item_name'] . '">
                <label for="modified_item_shelf">Módosított polc száma:</label>
                <input type="text" id="modified_item_shelf" name="modified_item_shelf" value="' . $itemToModify['zip_code'] . '">
                <input type="submit" name="modify_item_submit" value="Mentés">
            </form>';
    }


}