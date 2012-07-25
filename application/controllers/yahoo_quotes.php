<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Yahoo_quotes extends CI_Controller {
    
    private $csvUrl = 'http://download.finance.yahoo.com/d/quotes.csv?e=.csv';
	
	private $tableName;
	
	private $html_errormsg;
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->tableName = 'yahoo_quotes';
        $this->load->model('yahoo_quotes_model');
        $this->html_errormsg = 'There was a problem importing the data - check the logs for details';
    }
    
    function index()
    {
        if ($this->yahoo_quotes_model->importCSV() == TRUE) 
      		echo 'Yahoo! finance CSV quotes imported';
      	else
            show_error($this->html_errormsg, 500);		       
    }
    
    function yql()
    {
        // args for importYQL() are 'json' or 'xml'
		if($this->yahoo_quotes_model->importYQL('json') == TRUE)
			echo 'Yahoo! finance YQL quotes imported';
		else
			show_error($this->html_errormsg, 500);
    }

}