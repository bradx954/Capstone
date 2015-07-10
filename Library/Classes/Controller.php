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
        if($config['acl'][$controller]['public'] == false)
        {
            return $this->Allowed;
        }
        else
        {
            return true;
        }
    }
}
?>
