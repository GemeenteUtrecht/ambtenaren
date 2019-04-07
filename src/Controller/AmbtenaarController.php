<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Ambtenaar;

class AmbtenaarController
{
	public function __invoke(Ambtenaar $data): Ambtenaar
	{
		//$this->bookPublishingHandler->handle($data);
		
		return $data;
	}
}