<?php
namespace phpv2rayclass;
class v2Ray{
    private $host;
    private $username;
    private $password;

    function __construct($host, $username, $password) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        if(!file_exists(dirname(__FILE__) . '/cookie.txt')) $this->login();
    }

     private function login(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'password='.$this->password.'&username='.$this->username.'',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    public function guidv4($data = null) {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    
    private function RandomString($len=7){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $randstring = null;
        for($i = 0; $i < $len; $i++)
            $randstring .= $characters[rand(0, strlen($characters))];
        return $randstring;
    }
    
    public function users(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/panel/api/inbounds/list',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response['obj'];
    }
    public function get_client_stats($mail){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/panel/api/inbounds/getClientTraffics/'.$mail,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response['obj'];
    }
    public function get_client_ips($mail){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/panel/api/inbounds/clientIps/'.$mail,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response;
    }
    public function delete($guid){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/panel/API/inbounds/1/delClient/'.$guid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response;
    }
    
    public function reset($guid){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://'.$this->host. '/panel/API/inbounds/1/resetClientTraffic/'.$guid,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_COOKIEFILE => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_COOKIEJAR => dirname(__FILE__) . '/cookie.txt',
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response;
    }

   
    public function create_client($inbound,$mail,$expire,$guid){
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->host. '/panel/api/inbounds/addClient'); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "id": '.$inbound.',
            "settings": "{\\"clients\\":[{\\"id\\":\\"'.$guid.'\\",\\"alterId\\":0,\\"email\\":\\"'.$mail.'\\",\\"limitIp\\":0,\\"totalGB\\":0,\\"expiryTime\\":'.$expire.',\\"enable\\":true,\\"tgId\\":\\"\\",\\"subId\\":\\"\\"}]}"
        }');
        curl_setopt($ch,
        CURLOPT_HTTPHEADER, array(
          'Accept: application/json',
          'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close ($ch);
        return $response;
    }
    public function update_client($inbound,$mail,$expire,$gu,$status){
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://'.$this->host. '/panel/api/inbounds/updateClient/'.$gu); 
        curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "id": '.$inbound.',
            "settings": "{\\"clients\\":[{\\"id\\":\\"'.$gu.'\\",\\"alterId\\":0,\\"email\\":\\"'.$mail.'\\",\\"limitIp\\":0,\\"totalGB\\":0,\\"expiryTime\\":'.$expire.',\\"enable\\":'.$status.',\\"tgId\\":\\"\\",\\"subId\\":\\"\\"}]}"
        }');
        curl_setopt($ch,
        CURLOPT_HTTPHEADER, array(
          'Accept: application/json',
          'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        curl_close ($ch);
        return $response;
    }

    public function genVmess($mail,$id){
       $config='vmess://' . base64_encode('{
    "v": "2",
    "ps": "in1-'.$mail.'",
    "add": "'.$this->host.'",
    "port": 8880,
    "id": "'.$id.'",
    "net": "ws",
    "type": "none",
    "tls": "none",
    "path": "/"
}');
        return $config;
    }
}
