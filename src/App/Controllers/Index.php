<?php

namespace App\Controllers;

use Liz\Core\Controller;    
use App\Models\Perfil;

class Index extends Controller
{  
	private $perfil;

	public function __construct()
	{
		$this->perfil = new Perfil();

	}  

    public function index()
    { 
    	$perfis = $this->perfil->getAll();
		
		print '<h1>Welcome to the Liz Nano Framework</h1><a href="/index/save">Add new</a><hr>';
    	
    	if(count($perfis) <= 0) {
    		return print 'Perfis not found';
    	}

    	foreach($perfis as $p) {
    		print '<li>' . $p['name'] . ' <a href="/index/delete/?id=' . $p['id'] . '">&times;</a></li><hr>';
    	}
    }

    public function save()
    { 
    	if($_SERVER['REQUEST_METHOD'] == 'POST') {
    		$name  = (string) $_POST['name'];
    		$email = (string) $_POST['email'];

	    	if($name == '' || $email == '') return print 'Invalid datas';
	    	
	    	$save  = $this->perfil->setName($name)
	    				          ->setEmail($email)
	    					      ->setCreatedAt(date("Y-m-d H:i:s"))
	    					      ->save();
	    	if(!$save) {
	    		 print 'Error to save perfil in database!';
	    	}

	    	print "Save with success";
    	}
    	#else require the form automatic	
    }

    public function delete()
    {
    	if($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = (int) $_GET['id'];

    		$delete = $this->perfil->delete($id);

    		if(!$delete) {
    			print 'Error to delete perfil';
    		}

    		header('Location: /');
    	}
    }
}