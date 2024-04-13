<?php
namespace Modules\Docregister\Models;;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DocregisterModel extends Model
{
    protected $table      = 'tbl_docregister';
    protected $primaryKey = 'regId';

    //protected $useAutoIncrement = true;

    protected $returnType     = 'Modules\Docregister\Entities\Document'; // configure entity to use'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['regId', 'tgl', 'no_kendali', 'clascode', 'no_order', 'tujuan', 'prihal', 'opid'];
	
}