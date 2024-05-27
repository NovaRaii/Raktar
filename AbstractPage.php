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
                $quantity = isset($inventory[$shelf['item_name']]) ? $inventory[$shelf['item_name']] : 'N/A';
                echo '<td>' . $quantity . '</td>';

                echo '<td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="delete_shelf" value="Törlés"></form></td>';
                echo '<td><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input type="hidden" name="modify_shelf_id" value="' . $shelf['id'] . '"><input type="submit" name="modify_shelf" value="Módosítás"></form></td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        static function showModifyShelf(array $shelfToModify, int $modifyShelfId, array $inventory)
        {
            $quantity = isset($inventory[$shelfToModify['item_name']]) ? $inventory[$shelfToModify['item_name']] : 'N/A';
        
            echo '<h3>Módosítás: Polc #' . $modifyShelfId . '</h3>';
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <input type="hidden" name="modify_shelf_id" value="' . $modifyShelfId . '">
                <label for="modified_shelf_line">Módosított Polc neve:</label>
                <input type="text" id="modified_shelf_line" name="modified_shelf_line" value="' . $shelfToModify['shelf_line'] . '">
                <br>
                <label for="modified_shelf_itemName">Módosított Termék neve:</label>
                <input type="text" id="modified_shelf_itemName" name="modified_shelf_itemName" value="' . $shelfToModify['item_name'] . '">
                <br>
                <label for="modified_shelf_id">Módosított Polc Id:</label>
                <input type="number" id="modified_shelf_id" name="modified_shelf_id" value="' . $shelfToModify['id'] . '">
                <br>
                <label for="modified_item_qty">Módosított Termék mennyisége:</label>
                <input type="number" id="modified_item_qty" name="modified_item_qty" value="' .  $quantity . '">
                <br>
                <input type="submit" name="modify_shelf_submit" value="Mentés">
            </form>';
        }

        static function showAddInventory()
        {
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';

            if (isset($_POST["warehouseDropdown"])) {
                $selectedWarehouseId = isset($_POST["warehouseDropdown"]) ? $_POST["warehouseDropdown"] : '';
            }
        
            echo '<input type="hidden" name="warehouse_id" value="' . (isset($selectedWarehouseId) ? $selectedWarehouseId : '') . '">
                <label for="new_item_name">Új termék neve:</label>
                <input type="text" id="new_item_name" name="new_item_name">
                <label for="new_shelf_id">Új Polc Id:</label>
                <input type="number" id="new_shelf_id" name="new_shelf_id">
                <label for="new_shelf_name">Új Polc neve:</label>
                <input type="text" id="new_shelf_name" name="new_shelf_name">
                <label for="new_item_quantity">Mennyiség:</label>
                <input type="number" id="new_item_quantity" name="new_item_quantity">
                <input type="submit" name="add_inventory" value="Hozzáad">
                </form>';
        }
        
        static function showPdfExport()
        {
            echo '<form method="post" action="pdf.php">
                    <button id="btn-pdf" name="btn-pdf" title="Pdf">PDF</button>
                    </form>';
        }

        static function showDatabaseManage() 
        {
            echo '<form method="post" action="main.php">
            <button id="btn-main" name="btn-main" title="Database">Adatbázis</button>
            </form>';
        }

        static function showMail() {
            echo '<form method="post" action="mail.php">
                    <button id="btn-mail" name="btn-mail" title="Mail">Mail</button>
                    </form>';
        }

        static function showLoginBtn() {
            echo '<form method="post" action="login.php">
                    <button id="btn-login" name="btn-login" title="Login">Login</button>
                    </form>';
        }

        static function showLoginPage() {
            echo '<!DOCTYPE html>
            <hetml lang="hu">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/loginstyles.css">
            <title>Bejelentkezés és Regisztráció</title>
            </head>
            <body>
             
            <div class="container">
            <h2>Bejelentkezés</h2>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="email" placeholder="Email" name="loginEmail" required><br>
            <input type="password" placeholder="Jelszó" name="loginPassword" required><br>
            <input type="submit" name="btn-login" id="btn-login" value="Bejelentkezés">
            </form>
            
            <div class="options">
            <a href="registration.php">Regisztráció</a>
            </div>
            </div>
            </body>
            </html>
            ';
        }

        static function showRegistrationPage() {
            echo '<!DOCTYPE html>
            <hetml lang="hu">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/loginstyles.css">
            <title>Bejelentkezés és Regisztráció</title>
            </head>
            <body>
            <div class="container">
            <h2>Regisztráció</h2>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="text" id="name" name="username" placeholder="Név" required><br>
            <input type="email" id="email" name="email" placeholder="Email" required><br>
            <input type="password" id="password" name="password" placeholder="Jelszó" required><br>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Jelszó újra" required><br>
            <select id="privilegeDropdown" name="privilegeDropdown">
            <option value="Admin">Admin</option>
            <option value="User">User</option><br>
            </select>
            <input type="submit" id="add_user" name="add_user" value="Regisztráció">
            </form>
            <div class="options">
            <a href="login.php">Vissza a bejelentkezéshez</a>
            </div>
            </div>
            </body>
            </html>
            ';
        }

        static function showValidationPage() {
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="css/loginstyle.css">
                <title>Validálás</title>
            </head>
            <body>
            <form method="post" action="login.php">
            <button id="validation" name="validation" title="Validation">Login</button>
            </form>
            </body>
            </html>';
        }

        static function showUserTable(array $shelves, array $inventory)
        {  
            echo '<table>
                    <tr>
                        <th>id</th><th>Polcok</th><th>Termékek</th><th>Mennyiség</th>
                    </tr>';
            foreach ($shelves as $shelf) {
                echo '<tr>';
                echo '<td>' . $shelf['id'] . '</td>';
                echo '<td>' . $shelf['shelf_line'] . '</td>';
                echo '<td>' . $shelf['item_name'] . '</td>';
                $quantity = isset($inventory[$shelf['item_name']]) ? $inventory[$shelf['item_name']] : 'N/A';
                echo '<td>' . $quantity . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }