<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Yahoo_quotes_model extends CI_Model {
	
    private $options = array();
    
    private $symbols = array();
	
	private $current_symbols = array();
	
	private $delivery_months = array();
	
	private $month_symbols = array();
    
    private $csv_url;
    
    private $csv_import_table;
    
    function __construct()
    {
		$this->load->database();
		$this->load->config('yahoo_quotes');
		$this->csv_import_table = $this->config->item('table_name');
		
        parent::__construct($this->csv_import_table);
		
        $this->symbols = $this->config->item('symbols');
		$this->month_symbols = $this->config->item('month_symbols');
        $this->options = $this->config->item('all_options');
        $this->csv_url = $this->config->item('csv_url');
		$this->delivery_months = $this->config->item('delivery_months');
		$this->init_symbols();
    }
    
    function importCSV($cols = array())
    {
        // $this->options keys are column names for table
        $cols = array_change_key_case(array_keys($this->options));
        
        $inputValues[] = array(); // source for db insert values
        $row = 0;
        $num = 0;
        $status = FALSE;
        $csv_url = $this->csv_url . '&f='. implode('', $this->options) .'&s='. implode(',', $this->current_symbols);

        if (($handle = fopen($csv_url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, count($this->options), ",")) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < count($cols); $c++) {
                    $inputValues[$row][$cols[$c]] = $data[$c];
                }
                $row++;
            }
            fclose($handle);
            
            if(count($inputValues) > 0)
            {
                $this->db->empty_table($this->csv_import_table);
                $this->db->insert_batch($this->csv_import_table, $inputValues); 
                if($this->db->affected_rows() > 0)
                    $status = TRUE;
				else {
		    		$status = 'Inserts failed';
		    		log_message('error', $status . ': Yahoo finance csv data insert failed.');
				}
            }
	    	else {
				$status = 'Nothing to import';
				log_message('error', $status . ': Yahoo finance csv data insert array was empty.');
	    	}

        }
        else {
            $status = 'Network error';
            log_message('error', $status .': Yahoo finance csv download url could not be read.');
        }
        return $status;
    }
    
    function importYQL($format = 'json')
    {
		$this->load->helper('xml2array');
		$status = FALSE;
		$quotes_array = array();
		$obj_array = array();		
		$fmtstr = '&format=json';
		if($format != 'json') 
			$fmtstr = '';		
		$yql_query = 'SELECT * FROM '. $this->config->item('yql_query_source') .' WHERE symbol IN("'. implode('","', $this->current_symbols) .'")';
		$yql_url = $this->config->item('yql_url') .'&q='. urlencode($yql_query);
		
		$response = file_get_contents($yql_url . $fmtstr);		
		if($response) {
			// obj_array should be similar whether source is JSON or XML
			$obj_array = ($format == 'json') ? json_decode($response, TRUE) : XML2Array::createArray($response);
			// copy core 'quote' array
			$quotes_array = $obj_array['query']['results']['quote'];
		}
		else {
			$status = 'Network error';
			log_message('error', $status . ': YQL response unavailable');
		}
		$count = count($quotes_array);
		if($count > 0) {
			for($c = 0; $c < $count; $c++) {
				// xml object will have mixed case keys, so lowercase
				$inputValues[$c] = array_change_key_case($quotes_array[$c], CASE_LOWER);
				// xml parsing will add @attributes element which we don't want in batch insert array
				if(isset($inputValues[$c]['@attributes']))
					unset($inputValues[$c]['@attributes']);
			}
			if(count($inputValues) > 0) {
				// scratch old values
				$this->db->empty_table($this->csv_import_table);
				$this->db->insert_batch($this->csv_import_table, $inputValues); 
				if($this->db->affected_rows() > 0)
					$status = TRUE;
				else {
					$status = 'Inserts failed';
					log_message('error', $status . ': Yahoo finance YQL data insert failed.');
				}
			}
			else {
				$status = 'Nothing to import';
				log_message('error', $status . ': Yahoo finance YQL data insert array was empty.');
			}
		}
		else {
			$status = 'YQL error';
        	log_message('error', $status .': Yahoo finance YQL download url could not be read, or quote was empty.');
		}
		return $status;
    }
    
	function init_symbols()
	{
		$delivery_months = $this->delivery_months;
		$month_symbols = $this->month_symbols;
		$current_date = getdate();

		// work out current or next contract per commodity 
		foreach(array_keys($this->symbols) as $symbol) {
			if(in_array($month_symbols[$current_date['mon']], explode(',', $delivery_months[$symbol])) ) {
				if($current_date['mday'] < 15)
					$month_year = $month_symbols[$current_date['mon']] . strftime("%y");
				else
					$month_year = $this->get_next_month_symbol($symbol, $current_date['mon']);
			}
			else { 
				$month_year = $this->get_next_month_symbol($symbol, $current_date['mon']);
			}
			$this->current_symbols[] = $symbol . $month_year . '.' . $this->symbols[$symbol];
		} 
	}
	
	function get_next_month_symbol($symbol, $month)
	{
		// get next available month after $month
		$symbol_delivery_months = explode(',', $this->delivery_months[$symbol]);
		// set default to first contract month next year
		$next_month = reset($symbol_delivery_months) . strftime("%y", time() + 31536000);
		
		foreach($symbol_delivery_months as $month_symbol) {
			if($this->month_symbols[$month] < $month_symbol) {	
				$next_month = $month_symbol . strftime("%y"); 
				break;
			}
		} 
		return $next_month;
	}
}