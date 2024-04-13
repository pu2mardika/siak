<?php namespace App\Controllers;
class Home extends BaseController
{
	public function index()
	{
		echo $this->_render('dashboard',$this->data);
	}

	//--------------------------------------------------------------------
	public function about()
	{
		echo "about page";
	}
    
    public function contact()
	{
		echo "contact page";
	}
    
    public function faqs()
	{
		echo "Faqs page";
	}
}
