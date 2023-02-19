<?php

class Post
{

    private $error = "";

    public function create_post($userid, $data, $files)
    {

      if(!empty($data['post']) || !empty($files['file']['name']))
       {
           $myimage = "";
           $has_image = 0;
           $is_cover_image = 0;
           $is_profile_image = 0;
        
          
               if(!empty($files['file']['name']))
               {
                  $folder = "uploads/" . $userid . "/";

                  //create folder
                  if(!file_exists($folder))
                   {
                      mkdir($folder,0777,true);
                      file_put_contents($folder . "index.php", "");
                   }
                   $image_class = new Image();

                    $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                   move_uploaded_file($_FILES['file']['tmp_name'], $myimage);
                   $image_class->resize_image($myimage,$myimage,1500,1500);
              
                   $has_image = 1;

                }
            
            $name = "";
            $price = "";
            if(isset($data['post']) && isset($data['post']))
            {
                $name = addslashes($data['post']);
                $price = $data['price'];
            }
            $menu_id = $this->create_postid();
            $id2 = $this->create_postid2();
            $query = "insert into menu (menu_id,id2,name,image,price,userid) values ('$menu_id','$id2','$name','$myimage','$price','$userid')";

            $DB = new Database();
            $DB->save($query);
        }else
        {
            $this->error .= "Please type something to post!<br>";
        }

        return $this->error;
     
    }
    public function get_posts($id)
    {
       
        $query = "select * from menu where userid = '$id' order by id desc limit 10";

        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {
             return $result;
        }else
        {
            return false;
        }
    }

    public function get_one_post($menu_id)
    {
        if(!is_numeric($menu_id))
        {
            return false;
        }
        $query = "select * from menu where menu_id = '$menu_id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {
             return $result[0];
        }else
        {
            return false;
        }
    }

    

    public function i_own_post($postid, $mybook_userid)
    {
        if(!is_numeric($postid))
        {
            return false;
        }
        $query = "select * from posts where postid = '$postid' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if(is_array($result))
        {
          if($result[0]['userid'] == $mybook_userid)
          {
              return true;
          }
        }

        return false;
        
    }

    public function like_post($id,$type,$mybook_userid)
    {
        if($type == "post")
        {
            $DB = new Database();
            //increment the posts table
            $sql = "update posts set likes = likes + 1 where postid = '$id' limit 1";
            $DB->save($sql);

            //save likes details
            $sql = "select likes from likes where type = 'post' && contentid = '$id' limit 1";
            $result = $DB->save($sql);
            if(is_array($result))
            {
                $likes = json_decode($result[0]['likes'],true);

                $user_ids = array_column($likes, "userid");

                if(!in_array($mybook_userid, $user_ids))
                {
                
                $arr["userid"] = $mybook_userid;
                $arra["date"] = date("Y-m-d H:i:s");

                $likes[] = $arr;

                $likes_string = json_encode($likes);
                $sql = "update likes set likes = '$likes_string' where type = 'post' && contentid = '$id' limit 1";
                $DB->save($sql);
                }

            }else 
            {

                $arr["userid"] = $mybook_userid;
                $arra["date"] = date("Y-m-d H:i:s");

                $arr2[] = $arr; 

                $likes = json_encode($arr2);
                $sql = "insert into likes (type,contentid,likes) values ('$type','$id','$likes')";
                $DB->save($sql);
            }
        }
    }

    private function create_postid()
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
    private function create_postid2()
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
    private function create_orderid()
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
?>