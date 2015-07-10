<?php
class Controller 
{
	public $view;
    private $Allowed=false;

	function __construct() 
	{
        $this->MUserAuth = new UserAuth();
        $this->Allowed = $this->MUserAuth->loggedin();
        $this->view = new View;
	}
    function isAllowed()
    {
        return $this->Allowed;
    }
}
?>
