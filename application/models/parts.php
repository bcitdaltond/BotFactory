<?php

class Parts extends MY_Model
{
	// Constructor
    public function __construct()
	{
		parent::__construct('parts', 'partID');
	}
}