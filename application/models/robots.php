<?php

class robots extends MY_Model
{
//    var $data = array(
//        array('robotID' => 1, 'topPardId' => 'a', 'torsoPartId' => 'a', 'bottomPartId' => 'a',
//        'type' => 'household', 'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 2, 'topPardId' => 'b', 'torsoPartId' => 'b', 'bottomPartId' => 'b',
//        'type' => 'household', 'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 3, 'topPardId' => 'c', 'torsoPartId' => 'c', 'bottomPartId' => 'c',
//        'type' => 'household', 'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 4, 'topPardId' => 'm', 'torsoPartId' => 'm', 'bottomPartId' => 'm',
//        'type' => 'butler',    'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 5, 'topPardId' => 'r', 'torsoPartId' => 'r', 'bottomPartId' => 'r',
//        'type' => 'butler',    'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 6, 'topPardId' => 'w', 'torsoPartId' => 'w', 'bottomPartId' => 'w',
//        'type' => 'companion', 'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 7, 'topPardId' => 'a', 'torsoPartId' => 'b', 'bottomPartId' => 'c',
//            'type' => 'motley', 'assembleDate' => "02-08-2017 8:30"),
//        array('robotID' => 8, 'topPardId' => 'a', 'torsoPartId' => 'a', 'bottomPartId' => 'b',
//            'type' => 'motley', 'assembleDate' => "02-08-2017 8:30"),
//
//    );
    public function __construct()
    {
        parent::__construct('robot','robotID');

    }


    // Gets the specific robot
//    public function get($which)
//    {
//        foreach ($this->data as $record)
//            if ($record['robotID'] == $which)
//                return $record;
//        return null;
//    }
//
//    // Gets the amount of parts
//    public function count()
//    {
//        return sizeof($this->data);
//    }
//
//    // Gets all parts in stock
//    public function all(){
//        return $this->data;
//    }

}
