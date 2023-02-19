<?php

class AddDriver
{

    private $error = "";

    public function evaluate($data)
    {

        foreach ($data as $key => $value) {
            # code...
            if(empty($value))
            {
                $this->error = $this->error . $key . " is empty!<br>";
            }

            if($key == "email")
            {
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {

                    $this->error = $this->error . "invalid email address!<br>";
                }
                
            }

            if($key == "driver_name")
            {
                if(is_numeric($value)) {

                    $this->error = $this->error . "first name can't be a number<br>";
                }
                if(strstr($value, " ")) {

                    $this->error = $this->error . "first name can't have spaces<br>";
                }
            }
            
            

        }

        if($this->error == "")
        {

            //no error
            $this->create_user($data);
        }else
        {
            return $this->error;
        }
    }

    public function create_user($data)
    {

        $driver_name = ucfirst($data['driver_name']);
        $email = $data['email'];
        $password = hash("sha1",$data['password']);
        $user_type = $data['user_type'];
        
        //create these
        $url_address = strtolower($driver_name);
        $userid = $this->create_userid();

        $query = "insert into users
        (userid, first_name, email, password, url_address, user_type)
        values
        ('$userid', '$driver_name', '$email', '$password', '$url_address', '$user_type')";

        $DB = new Database();
        $DB->save($query);
    }

    private function create_userid()
    {
        $length = rand(4,19);
        $number = "";
        for ($i=0; $i < $length; $i++) {
            # code...
            $new_rand = rand(0,9);

            $number = $number . $new_rand;
        }

        return $number;
    }
}