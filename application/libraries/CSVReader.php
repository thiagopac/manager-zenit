<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class CSVReader
{
    public $fields;/** columns names retrieved after parsing */
    public $separator = ';';/** separator used to explode each line */
    public $enclosure = '"';/** enclosure used to decorate each field */
    public $max_row_size = 4096;/** maximum row size to be used for decoding */

    public function parse_file($p_Filepath)
    {
        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        $keys = str_getcsv($this->fields[0]);

        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false) {
            if ($row != null) { // skip empty lines
                $values = str_getcsv($row[0]);
                if (count($keys) == count($values)) {
                    $arr = array();
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            $arr[$keys[$j]] = $values[$j];
                        }
                    }

                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }
}
