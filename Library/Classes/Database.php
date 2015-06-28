<?php
class Database {

	private static $classInstance;
	private static $PDOConnection;  
  
	public function __construct(   ) {
			try { 
				self::$PDOConnection  = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
				self::$PDOConnection->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				if ($e->getCode() == 0)    //connection failed code
					$this->showErrorPage("Connection to database failed. ",$e);								
			} 
	}
 
 	//singleton 
 	public static function getInstance(){
		if ( empty(self::$classInstance) == TRUE ):
				self::$classInstance = new Database() ;
		endif;
		return self::$classInstance;
	}
 
	public function  getPDOConnection() {
			return self::$PDOConnection;
		}

	 /**
	 * Catch Block errors  
	 */ 
	public function showErrorPage($errorMsg ,$e    ) {
		 
		$TPL = array(	"time" 			=> date("F j, Y, g:i a"),    
						'message' 		=> $errorMsg,
						'exceptionMsg' 	=> $e->getMessage(),
						'esceptionCode' => $e->getCode() , 
						//'PDOS_Values'	=> $otherValues , 
						'traceDetails' 	=> $e->getTrace());
		 
		$this->errorLog($TPL);
		include DATABASEERROR_VIEW; 
		exit();
	}

	/**
	 * Logging utility   
	 *   Database::errorLog()
	 */
	public function errorLog ($errorArray) {
		//Useage: Database::errorLog(array('clear'=>'logfile');
		if ($errorArray['clear'] == 'logfile'):
			if (file_exists(LOGFILE)) 	file_put_contents(LOGFILE, '');
			return;
		endif;
		
		$lineBreak = "\n---------------- ". date("F j, Y, g:i a")." ------------------------------------------\n";
		if (file_exists(LOGFILE)) 
			file_put_contents(LOGFILE, $lineBreak.print_r($errorArray,TRUE) , FILE_APPEND);
		return;
	
	}
}
?>