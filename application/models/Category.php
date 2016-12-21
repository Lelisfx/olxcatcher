<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Model
{
  public $table_name = 'Category';
  const FIELDS = array('Id', 'Description');
  public $Id;
  public $Description;



  public function __construct() {
           parent::__construct();
  }

  public function fill($data)
  {

    for ($i=0; $i < count(self::FIELDS); $i++) {
      //echo self::FIELDS[$i];
      $field = self::FIELDS[$i];
      $valor = $data[0][$field];
      $this->{$field} = $data[0][$field];
    }
  }

  public function byDescription($description)
  {
    $this->load->database();
    $sql = <<<EOT
                  CALL spSaveCategory(?);
EOT;

    $q = $this->db->query($sql, array($description));
    $data = $q->result_array();
    $this->fill($data);
    $q->next_result();
    $q->free_result();

    return $this;
    /*
    $data = array(
       'roll_no' => ‘1’,
       'name' => ‘Virat’
    );

    $this->db->insert("stud", $data);

    $data = array(
       'roll_no' => ‘1’,
       'name' => ‘Virat’
    );

    $this->db->set($data);
    $this->db->where("roll_no", ‘1’);
    $this->db->update("stud", $data);

    $this->db->select('age');
    $this->db->where('id', '3');
    $q = $this->db->get('my_users_table');
    //if id is unique we want just one row to be returned
    $data = array_shift($q->result_array());
   */
  }
}
?>
