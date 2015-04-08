<?php

/*
 * Class for creating table in CSV format
 * Input: data[x][y], Output: file.csv
 */

class CSVTable {
    /*
     * $map[x][y] = 'Example text';
     */

    private $map;
    /*
     * The size of table, for example: 100, (100x100)
     */
    private $size;
    private $delim;

    public function __construct($size = 1000) {
        if ($size > 0 && $size < 100000000) {
            $this->size = $size;
        } else {
            $this->showError("The size is not correct");
        }
        $this->delim = ";";
        $this->init();
    }

    private function init() {
        for ($x = 0; $x <= $this->size; $x++) {
            for ($y = 0; $y <= $this->size; $y++) {
                $this->map[$x][$y] = "";
            }
        }
    }

    public function showError($message) {
        echo "Error: ".$message;
        exit;
    }

    public function setDelimeter($character) {
        if (strlen($character) > 1) {
            $this->showError("Delimeter must contain 1 character. For example ';'");
        }
        $this->delim = $character;
    }

    public function insert($x, $y, $text) {
        if (isset($this->map[$x][$y])) {
            $this->map[$x][$y] = $text;
        } else {
            $this->showError("The ceil x=$x, y=$y is not exist");
        }
    }

    public function insertVertical($x, $y, $array) {
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            if (isset($this->map[$x][$y + $i])) {
                $this->map[$x][$y + $i] = $array[$i];
            } else {
                $this->showError("The ceil x=$x, y=$y is not exist");
            }
        }
    }

    public function insertHorizontal($x, $y, $array) {
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            if (isset($this->map[$x + $i][$y])) {
                $this->map[$x + $i][$y] = $array[$i];
            } else {
                $this->showError("The ceil x=$x, y=$y is not exist");
            }
        }
    }

    public function saveTo($filename) {
        $h = fopen($filename, "w");
        for ($y = 0; $y <= $this->size; $y++) {
            for ($x = 0; $x <= $this->size; $x++) {
                fwrite($h, $this->map[$x][$y] . $this->delim);
            }
            fwrite($h, "\n");
        }
    }

}
/*

$table = new CSVTable();
$table->insert(7, 6, "Hello World!");
$table->insertVertical(-3, 6, array("Hello!", "Hi!", "Halo!"));
$table->insertHorizontal(10, 6, array("Hello!", "Hi!", "Halo!"));
$table->saveTo("hello.csv");
 
 */
