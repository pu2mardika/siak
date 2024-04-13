<?php
<?php
namespace Modules\Docregister\Libraries;
use Modules\Docregister\Models\DocregisterModel;
use Modules\Docregister\Entities\Document;

class Mailreg 
{
	private $form_token = '';
	private $session;
	private $model;
	
	public function __construct() {
		$this->session = \Config\Services::session();
	}
	
	
	
}