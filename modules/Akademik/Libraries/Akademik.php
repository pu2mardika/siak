<?php
namespace Modules\Akademik\Libraries;

class Akademik 
{
	private $form_token = '';
	private $session;
	private $model;
	
	public function show(array $params)
	{
		$theme = $params['theme'];
		$dtview = $params['dtview'];
		return view($theme.'/cells/dlist',$dtview);
	}
}