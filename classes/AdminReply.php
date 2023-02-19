<?php

class Reply
{

    public function evaluate($data)
    {

        //no error
        $this->add_reply($data);
   
    }

    public function add_reply($data)
    {

        $replying = $data['replying'];
        $ratingId = $data['ratingId'];

        $query = "UPDATE `item_rating` SET `reply`='$replying' WHERE `ratingId`='$ratingId'";
        $DB = new Database();
        $DB->save($query);
    }

}