<?php
/**
 * Abstract class that serves as the model
 */
require_once ('database.php');

abstract class abstractModel extends Database
{
  protected $tableMame = '';
  public $properties = array();

  /**
   * Load data from database and populate the properties
   *
   * @param  string $order_by
   * @return array 
   */
  protected function getRows($orderBy = '')
  {

    $results = [];
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 
    
    $sql  = "SELECT ";
    
    foreach ($this->properties as $name)
    {
      $sql .= "`" . $this->tableName . "`.`" . $name .  "`, ";
    }

    $sql  = substr($sql, 0, -2) . " ";
    $sql .= "FROM `" . $this->tableName ."` ";
    $sql .= "WHERE 1 ";

    if (strlen($orderBy) > 0)
    {
      $sql .= "ORDER BY " . $orderBy . " ";
    }

    $sql .= ";";

    try
    {
      $result = $mysqli->query($sql);
    }
    catch (Exception $e)
    {
      //TODO write error to log $e->getMessage();
      return false;
    }

    if ( !$result ) {
      return false;
    }
 
    while ($row = $result->fetch_object())
    {
      $results[] = $row;
    }

    return $results; 

  }

   /**
   * Set values for properties
   * @return boolean
   */
  public function setValues($values){

    foreach ($this->properties as $name )
    {
      if ( array_key_exists($name, $values) ){
        $this->$name = $values[$name];
      }
    }

  }

  /**
   * Saves data from $properties
   * @return boolean
   */
  public function save()
  {

    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql  = "INSERT INTO `" . $this->tableName . "` (
                `" . implode('`, `', $this->properties) . "`
              ) VALUES (
                ";

    foreach ($this->properties as $name )
    {
      if ( isset($this->$name) ){
        $sql .= "'" . $mysqli->escape_string($this->$name) . "', ";
      }      
    }

    $sql  = substr($sql, 0, -2);
    $sql .= "
              );";
    
    try
    {
      $mysqli->query($sql);
    }
    catch (Exception $e)
    {
      //TODO write error to log $e->getMessage();
      return false;
    }

    return true;
  }

}