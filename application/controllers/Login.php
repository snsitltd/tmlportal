<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login (LoginController)
 * Login class to control to authenticate user credentials and starts user's session.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
		//$this->load->library('encrypt');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
					//$this->output->enable_profiler(TRUE);
    }
	public function refreshLogin()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
         //print_r($this->session->userdata());    
//print_r($isLoggedIn);  
    }
	 
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
  //       print_r($this->session->userdata());    
//print_r($isLoggedIn);    
   
//exit;		
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login'); 
        }
        else
        {
            redirect('/dashboard');
        }
    }


    function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
       //$this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if(@$this->form_validation->run() == FALSE){
            $this->index();
        }else{
            if(GOOGLE_RECAPTCHA_STATUS){
                $post_data = http_build_query(
                    array(
                        'secret' => GOOGLE_RECAPTCHA_SECRETKEY,
                        'response' => $_POST['g-recaptcha-response'],
                        'remoteip' => $_SERVER['REMOTE_ADDR']
                    )
                );
                $opts = array('http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $post_data
                    )
                );
                $context  = stream_context_create($opts);
                $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
                $result = json_decode($response);

                if (!$result->success) {
                    $this->session->set_flashdata('error', 'Gah! CAPTCHA verification failed');                
                    redirect('/login');
                } 
            }

            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
             
            $result = $this->login_model->loginMe($email, $password);
			 
            if(!empty($result))
            {
                $lastLogin = $this->login_model->lastLoginInfo($result->userId);
                $role_access='';
                $lastRoleAccess =    $this->login_model->lastRoleAccess($result->role);
                if($lastRoleAccess){
                   $role_access= $lastRoleAccess->role_permission;
				   $logout_time= $lastRoleAccess->logout_time;
                }
            
                $sessionArray = array('userId'=>$result->userId,                    
                                        'role'=>$result->roleId,
                                        'roleText'=>$result->role,
                                        'name'=>$result->name,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'isLoggedIn' => TRUE,
										'logout_time' => $logout_time,
                                        'roleAccess'=>$role_access
                                ); 
                $this->session->set_userdata($sessionArray);
              
                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

                $loginInfo = array("userId"=>$result->userId, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());

                $this->login_model->lastLogin($loginInfo);
                
                redirect('/dashboard');
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
                redirect('/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->security->xss_clean($this->input->post('login_email'));
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url("resetPasswordConfirmUser/".$data['activation_id']."/".$encoded_email);
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    } 
//                    $sendStatus = resetPasswordEmail($data1);

					$subject1 = " Reset Password | Thames Materials "; 		

/*					
					$config['mailtype'] = 'html';  
					$this->load->library('Email', $config);
					$email_setting  = array('mailtype'=>'html');
					$this->email->initialize($email_setting);
					
					$this->email->from(EMAIL_FROM,FROM_NAME);
					$this->email->to($data1["email"],$data1["name"]);  
					
					$this->email->subject($subject1);  
					$message1 = $this->load->view('email/resetPassword', $data1, TRUE);  
					//var_dump($message1); 
					$this->email->message($message1);  
*/					
                        $config['protocol'] = 'sendmail';
                        //$config['mailpath'] = '/usr/sbin/sendmail';
                        $config['charset'] = 'iso-8859-1';
                        $config['wordwrap'] = TRUE;
                        $config['mailtype'] = 'html';
						
                        $this->email->initialize($config);
						
                        $to_email = $user['Email'];
                        $mailHTML = $this->load->view('email/resetPassword', $data1, TRUE);  
                        $this->load->library('email');
                        $this->email->from(EMAIL_FROM,FROM_NAME);
                        $this->email->to($data1["email"],$data1["name"]); 
                        $this->email->subject($subject1); 
                        $this->email->message($mailHTML);  					
					
					$result = $this->email->send();   
                    if($result){ 
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    }else{
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
}

?>