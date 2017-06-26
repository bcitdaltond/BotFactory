<?php
class History extends MY_Model
{
	// Constructor
	function __construct()
	{
	    //Specifies the database and table
		parent::__construct('history','transactionID');
	}

    // retrieve all of the transaction history entries also applies sorting and filtering
    public function all($column = 'stamp', $filter_model = 'all', $filter_series = 'all')
    {
        $this->db->order_by($column, 'asc');
        $this->db->from('history');

        if($filter_series != 'all') {
            $this->db->where('series', $filter_series);
        }
        if($filter_model != 'all') {
            $this->db->where('model', $filter_model);
        }

        $query = $this->db->get();
        return $query->result();
    }

    //Get the total amount of money spent
	public function getSpent()
	{
		$moneySpent = 0;
		foreach ($this->all() as $record)
		{
			if ($record->amount < 0){
				$moneySpent -= $record->amount;
			}
		}
		return $moneySpent;
	}

    //Get the total amount of recycled parts
	public function getEarned()
	{
		$moneyEarned = 0;
		foreach ($this->all() as $record)
		{
			if ($record->amount > 0){
				$moneyEarned += $record->amount;
			}
		}
		return $moneyEarned;
	}

    //Remove all records inside the history table
    public function deleteAll() {
        $this->db->empty_table('history');
    }
}