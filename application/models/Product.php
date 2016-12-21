<?php
class Product extends CI_Model
{
  public $table_name = 'Product';
  const FIELDS = array('Id, Description, $CategoryId, Link, Price');

  public $Id;
  public $Description;
  public $Category;
  public $Link;
  public $Price;

  public function __construct() {
           parent::__construct();
  }

  public function Save()
  {
        $sql = <<<EOT
                      CALL spSaveProduct(?,?,?,?);
EOT;

        $q = $this->db->query($sql, array($this->Link, $this->Description, $this->Category->Id, $this->Price));

        $data = $q->result_array();
        $this->Id = $data[0]['Id'];

        $q->next_result();
        $q->free_result();
  }
}
?>
