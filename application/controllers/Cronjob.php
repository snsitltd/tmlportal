<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

//require APPPATH . '/libraries/BaseController.php';
/**
 * Class : Schedule (CronjobController)
 * User Class to control all user related operations.
 * @author : Pooja K
 * @version : 1.0
 * @since : 20 Oct 2018
 */
class Cronjob extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Schedule_model');        
    }

    function index(){         
                 
    
	    $result= $this->Common_model->select_all_with_where('schedule_files',array('status'=>0,'is_schedule'=>'yes'));

        //print_r($result);die;

	    foreach ($result as $key => $values) {
            $csvdb ='';
	    	$csvdb = json_decode($values['mapindexing']);
	    	$table_cal=array();
	    	foreach ($csvdb as $key => $col) {
	                 $table_cal[] =  $key;
                
	        }	    	
	    	$importDB = array();
                   $ij=0;
                   $file_path = WEB_ROOT_PATH.'assets/Uploads/'.$values['filename'];        
        
                    //open the csv file for reading
                    $handle = fopen($file_path, 'r');

                    // read the first line and ignore it
                    fgets($handle); 
                    $sql_val=array();
                  while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        //print_r($data[4]); die;
                        $sql ='( ';
                        foreach ($csvdb as $key => $value) {
                           
                            if($value!='' && isset($data[$value])){

                                $importDB[$ij][$key] = addslashes(trim($data[$value]));

                            }else{
                                $importDB[$ij][$key] = ''; 
                            }

                             $sql .= "'". $importDB[$ij][$key]."',";         

                        }

                        $sql = substr(trim($sql), 0, -1);
                        $sql .=  ' )'; 

                        $sql_val[] = $sql;
                        $ij++;               
                    }  

                    $delete_table = array("company_to_opportunities","company_to_note","company_to_contact","company_to_document","opportunity_to_note","opportunity_to_contact","opportunity_to_document");
                     if (in_array($values['type'], $delete_table)){$this->db->empty_table($values['type']);}


                    $this->db->query("REPLACE INTO tbl_".$values['type']." (".implode(", ", $table_cal).") VALUES ". implode(", ", $sql_val));
                    $this->Common_model->update('schedule_files',array("status"=>1),array("id"=>$values['id'])) ;             
	    
	    	
	    }

    }

}
