<?php

ini_set('memory_limit','1024M');

class CsvTools {

    const FILENAME = "electronics_inventory.csv";
    public $csvData;
    public $result = [];
    public $warehouses = [];
    public $shelves = [];
    public $items = [];
    public $header;
    public $idxWarehouse;
    public $idxShelf;
    public $idxItem;
    public $idxQty;
    
    function __construct(){
        $this->csvData = $this->getCsvData(self::FILENAME);
        $this->header = $this->csvData[0];
        $this->idxWarehouse = array_search('warehouse', $this->header);
        $this->idxShelf = array_search('shelf', $this->header);
        $this->idxItem = array_search('item', $this->header);
        $this->idxQty = array_search('quantity', $this->header);
    }

    function getCsvData($fileName) {
        if (!file_exists($fileName)) {
            echo "$fileName nem található. ";
            return false;
        }
        $csvFile = fopen($fileName, 'r');
        $lines = [];
        while (!feof($csvFile)) {
            $line = fgetcsv($csvFile);
            $lines[] = $line;
        }
        fclose($csvFile);
        return $lines;
    }
    function importCsv($tmpFilePath, $warehouseDbTool, $shelfDbTool, $itemsDbTool) {
        $csvData = $this->getCsvDataFromTmpFile($tmpFilePath);

        if (empty($csvData)) {
            echo "Nem található adat a CSV fájlban.";
            return false;
        }
        header("Refresh:0"); 
    }

    function getWarehouses($csvData) {
        if (!empty($csvData)) {
            if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $warehouse = '';
        foreach ($this->csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
            if ($warehouse != $line[$this->idxWarehouse]){
                $warehouse = $line[$this->idxWarehouse];
                $warehouses[] = $warehouse;
            }
        }
        return $warehouses;
        }
    }

    function getShelves($csvData) {
        if (!empty($csvData)) {
            if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $shelf = '';
        foreach ($this->csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
            if ($shelf != $line[$this->idxShelf]){
                $shelf = $line[$this->idxShelf];
                $shelves[] = $shelf;
            }
        }
        return $shelves;
        }
    }

    function getItems($csvData){
        if (!empty($csvData)) {
            if (empty($csvData)) {
            echo "Nincs adat.";
            return false;
        }
        $item = '';
        foreach ($this->csvData as $idx => $line) {
            if(!is_array($line)){
                continue;
            }
            if ($idx == 0) {
                continue;
            }
            if ($item != $line[$this->idxItem]){
                $item = $line[$this->idxItem];
                $items[] = $item;
            }
        }
        return $items;
        }
    }
    function truncateWarehouseTable($warehouseDbTool,$csvData){
        $warehouseDbTool->truncateWarehouse();
        $cities = $this->getWarehouses($csvData);
        foreach ($cities as $city){
            $warehouseDbTool->createCity($city[0],$city[1]);
        }
    }

    function getCsvDataFromTmpFile($tmpFilePath) {
        $lines = [];
        $csvFile = fopen($tmpFilePath, 'r');
        while (! feof($csvFile)) {
            $line = fgetcsv($csvFile);
            $lines[] = $line;
        }
        fclose($csvFile);
        return $lines;
    }
}




?>