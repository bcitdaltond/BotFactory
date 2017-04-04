<?php

class Parts extends MY_Model
{
//	var $data = array(
//			array('partID' => 1, 'model' => 'a', 'piece' => 1, 'CA_code' => '#000000',
//                  'plant' => 'apple', 'stamp' => "02-08-2017 8:30", 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 2, 'model' => 'a', 'piece' => 2, 'CA_code' => '#000001',
//                  'plant' => 'apple', 'stamp' => "02-08-2017 11:45", 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 3, 'model' => 'a', 'piece' => 1, 'CA_code' => '#000002',
//                  'plant' => 'apple', 'stamp' => "02-08-2017 15:10", 'line' => 'Household', 'isAvailable' => 1),
//
//			array('partID' => 4, 'part_code' => 'b1', 'CA_code' => '#000003',
//                  'manufacturer' => 'ubc', 'built_date' => "02-06-2017 08:50", 'cost' => 10,
//                  'piece' => 'Top', 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 5, 'part_code' => 'b2', 'CA_code' => '#000004',
//                  'manufacturer' => 'ubc', 'built_date' => "02-06-2017 11:55", 'cost' => 10,
//                  'piece' => 'Torso', 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 6, 'part_code' => 'b3', 'CA_code' => '#000005',
//                  'manufacturer' => 'ubc', 'built_date' => "02-06-2017 14:35", 'cost' => 10,
//                  'piece' => 'Bottom', 'line' => 'Household', 'isAvailable' => 1),
//
//			array('partID' => 7, 'part_code' => 'c1', 'CA_code' => '#000006',
//                  'manufacturer' => 'sfu', 'built_date' => "02-05-2017 08:45", 'cost' => 15,
//                  'piece' => 'Top', 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 8, 'part_code' => 'c2', 'CA_code' => '#000007',
//                  'manufacturer' => 'sfu', 'built_date' => "02-05-2017 12:10", 'cost' => 15,
//                  'piece' => 'Torso', 'line' => 'Household', 'isAvailable' => 1),
//			array('partID' => 9, 'part_code' => 'c3', 'CA_code' => '#000008',
//                  'manufacturer' => 'sfu', 'built_date' => "02-05-2017 16:15", 'cost' => 10,
//                  'piece' => 'Bottom', 'line' => 'Household', 'isAvailable' => 1),
//
//			array('partID' => 10, 'part_code' => 'm1', 'CA_code' => '#000009',
//                  'manufacturer' => 'ut', 'built_date' => "02-04-2017 08:25", 'cost' => 15,
//                  'piece' => 'Top', 'line' => 'Butler', 'isAvailable' => 1),
//			array('partID' => 11, 'part_code' => 'm2', 'CA_code' => '#00000A',
//                  'manufacturer' => 'ut', 'built_date' => "02-04-2017 12:00", 'cost' => 20,
//                  'piece' => 'Torso', 'line' => 'Butler', 'isAvailable' => 1),
//			array('partID' => 12, 'part_code' => 'm3', 'CA_code' => '#00000B',
//                  'manufacturer' => 'ut', 'built_date' => "02-04-2017 15:20", 'cost' => 15,
//                  'piece' => 'Bottom', 'line' => 'Butler', 'isAvailable' => 1),
//
//			array('partID' => 13, 'part_code' => 'r1', 'CA_code' => '#00000C',
//                  'manufacturer' => 'kpu', 'built_date' => "02-03-2017 08:50", 'cost' => 25,
//                  'piece' => 'Top', 'line' => 'Butler', 'isAvailable' => 1),
//			array('partID' => 14, 'part_code' => 'r2', 'CA_code' => '#00000D',
//                  'manufacturer' => 'kpu', 'built_date' => "02-03-2017 11:15", 'cost' => 30,
//                  'piece' => 'Torso', 'line' => 'Butler', 'isAvailable' => 1),
//			array('partID' => 15, 'part_code' => 'r3', 'CA_code' => '#00000E',
//                  'manufacturer' => 'kpu', 'built_date' => "02-03-2017 14:45", 'cost' => 15,
//                  'piece' => 'Bottom', 'line' => 'Butler', 'isAvailable' => 1),
//
//			array('partID' => 16, 'part_code' => 'w1', 'CA_code' => '#00000F',
//                  'manufacturer' => 'vcc', 'built_date' => "02-02-2017 08:40", 'cost' => 50,
//                  'piece' => 'Top', 'line' => 'Companion', 'isAvailable' => 1),
//			array('partID' => 17, 'part_code' => 'w2', 'CA_code' => '#000010',
//                  'manufacturer' => 'vcc', 'built_date' => "02-02-2017 11:35", 'cost' => 50,
//                  'piece' => 'Torso', 'line' => 'Companion', 'isAvailable' => 1),
//			array('partID' => 18, 'part_code' => 'w3', 'CA_code' => '#000011',
//                  'manufacturer' => 'vcc', 'built_date' => "02-02-2017 15:00", 'cost' => 50,
//                  'piece' => 'Bottom', 'line' => 'Companion', 'isAvailable' => 1)
//	);

	// Constructor
    public function __construct()
	{
		parent::__construct('parts', 'partID');
	}

//	// Gets the specified part (by id)
//    public function get($which)
//	{
//		foreach ($this->data as $record)
//			if ($record['partID'] == $which)
//				return $record;
//		return null;
//	}
//
//  // Gets the amount of parts
//	public function count()
//	{
//        return sizeof($this->all());
//	}
//
//	// Gets all parts in stock
//    public function all()
//	{
//		return $this->data;
//	}
}