<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DatabaseController
{
	public function indexAction(Application $app) 
	{
		$sql = "SELECT * FROM company WHERE id = ?";
    	$company = $app['dbs']['mysql_read']->fetchAssoc($sql, array((int) $id));

	    return new Response("<h1>{$company['name']}</h1>".
	           "<p>{$company['email']}</p>".
	           "<p>{$company['description']}</p>");
	}
}