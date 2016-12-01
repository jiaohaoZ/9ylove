<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth
{
    public $CI;
    
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }
    
    //会员是否登录
    public function is_logged_in($redirect = false, $default_redirect = 'secure/login')
    {
        
        if ( ! isset($_SESSION['user_id']))
        {
            //check the cookie
            if(isset($_COOKIE['GaoUser']))
            {
                //the cookie is there, lets log the customer back in.
                $info = $this->aes256Decrypt(base64_decode($_COOKIE['GaoUser']));
                $cred = json_decode($info, true);
    
                if(is_array($cred))
                {
                    if( $this->login($cred['username'], $cred['password']) )
                    {
                        return $this->is_logged_in($redirect, $default_redirect);
                    }
                }
            }
    
            //this tells where to go once logged in
            if ($redirect)
            {
                $this->CI->session->set_flashdata('redirect', $redirect);
            }
    
            if ($default_redirect)
            {
                $default_redirect .=  '?redirect=' . urlencode($redirect);
                redirect($default_redirect);
            }
    
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function login($user, $password, $remember=false)
    {
        if( ! $user)
        {
            return false;
        }

        $this->CI->db->select('*');
        $this->CI->db->where('user_name', $user);
        $this->CI->db->or_where('mobile', $user);
        $this->CI->db->limit(1);
        $result = $this->CI->db->get('user');
        $result = $result->row_array();
        
        if (sizeof($result) > 0)
        {
            $password = md5(md5($password) . $result['salt']);
            if($result['password'] != $password)
            {
                return false;
            }
            
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['user_name'] = $result['user_name'];
            $_SESSION['user_rank'] = $result['user_rank'];
            $_SESSION['real_name'] = $result['real_name'];
            $_SESSION['nick_name'] = $result['nick_name'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['mobile'] = $result['mobile'];
        
            if($remember)
            {
                $loginCred = json_encode(array('mobile'=>$result['mobile'], 'password'=>$password));
                $loginCred = base64_encode($this->aes256Encrypt($loginCred));
                //remember the user for 1 months
                $this->generateCookie($loginCred, strtotime('+1 months'));
            }

            return true;
        }
        else
        {
            return false;
        }
        
    }

    /**
     * 判断支付密码
     *
     * @param $pay_password
     * @return bool
     */
    public function check_pay_password($pay_password)
    {
        if(isset($_SESSION['user_id']))
        {
            $result = $this->CI->db->select('pay_password, pay_salt')
                ->from('user')
                ->where('user_id', $_SESSION['user_id'])
                ->limit(1)
                ->get()->row_array();
            if(sizeof($result) > 0)
            {
                return $result['pay_password'] === md5(md5($pay_password) . $result['pay_salt']);
            }

            return false;

        }

        return false;

    }
    
       
        
    private function generateCookie($data, $expire)
    {
        setcookie('GaoUser', $data, $expire, '/', $_SERVER['HTTP_HOST']);
    }
    
    private function aes256Encrypt($data)
    {
        $key = config_item('encryption_key');
        if(32 !== strlen($key))
        {
            $key = hash('SHA256', $key, true);
        }
        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
    }
    
    private function aes256Decrypt($data) 
    {
        $key = config_item('encryption_key');
        if(32 !== strlen($key))
        {
            $key = hash('SHA256', $key, true);
        }
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
        $padding = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padding);
    }
    
}