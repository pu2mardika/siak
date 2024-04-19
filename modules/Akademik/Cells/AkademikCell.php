<?php

namespace Modules\Akademik\Cells;

use CodeIgniter\View\Cells\Cell;

class AkademikCell extends Cell
{
    public $theme;
    public $fields;
    public $data;
    public $id;
    
    public function render():string
  // public function show(array $params):string
    {
    	return $this->view('sbadmin2/cells/dlist',['fields'=>$this->fields, 'rset'=>$this->data, 'id'=>$this->id]);
    	//show_result($params);
	}
}
