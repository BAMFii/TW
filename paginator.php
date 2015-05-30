<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 5/28/2015
 * Time: 11:19 AM
 */

class Paginator
{

    var $_conn;
    var $_limit;
    var $_page;
    var $_query;
    var $_total;


    public function _construct($conn, $query)
    {

        $this->_conn = $conn;
        $this->_query = $query;

        $rs = $this->_conn->query($this->_query);
        $this->_total = $rs->num_rows;

    }
}