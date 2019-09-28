<?php
namespace FeeCalculation;

class CsvImporter implements Importer
{
    private $fp;

    //--------------------------------------------------------------------

    /**
     * CsvImporter constructor.
     * @param string $file_name
     */
    public function __construct(string $file_name)
    {
        $this->fp = fopen($file_name, 'rb');
    }

    //--------------------------------------------------------------------

    /**
     *
     */
    public function __destruct()
    {
        if ($this->fp) {
            fclose($this->fp);
        }
    }

    //--------------------------------------------------------------------

    /**
     * @return Array
     */
    public function get(): Array
    {
        $data = array();

        while (!feof($this->fp)) {
            $data[] = fgetcsv($this->fp);
        }
        return $data;
    }
}
