<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistoryController extends Application
{
    //Number of records that can be displayed
    private $items_per_page = 20;

    //Default history table sorting
    private $sort = "stamp";
    
    //Default history table filter for models
    private $filter_model = "all";
    
    //Default history table filter for model series
    private $filter_series = "all";

    // Constructor
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/
     * 	- or -
     * 		http://example.com/history
     *
     * map to /history/index
     */
    public function index()
    {
        $this->page(1);
    }

    //Allows multi-page views
    public function page($num = 1) {
        
        //Determines if your current role type is allowed
        $role = $this->session->userdata('userrole');
        
        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role != ROLE_BOSS) redirect('/home');

        $this->data['pagetitle'] = 'History ('. $role . ')';

        //Determines if sort was specified on another page
        $sort = $this->input->post('order');
        if ($this->session->userdata('sort') == null) {
            $this->session->set_userdata('sort', $this->sort);
        } else if($sort != null) {
            $this->session->set_userdata('sort', $sort);
        }
        $this->sort = $this->session->userdata('sort');

        //Gets the history table from the database
        $source = $this->history->all($this->sort); //get all the history
        $history = array();
        $index = 0;
        $count = 0;
        $start = ($num - 1) * $this->items_per_page;

        foreach ($source as $record) {
            if ($index++ >= $start) {
                
                $history[] = array (
                    'transactionId' => $record->transactionID,
                    'date' => $record->stamp,
                    'category' => $record->category,
                    'description' => $record->description,
                    'amount' => $record->amount
                );
                $count++;
            }
            if ($count >= $this->items_per_page) break;
        }
        $this->data['pagination'] = $this->pagenav($num);

        //Sets the sort drop-down list to specified option
        $this->data['sort_script'] = '
            var textToFind = "' . $this->sort . '";
    
            var order = document.getElementById("order");
            order.selectedIndex = 0;
            for (var i = 0; i < order.options.length; i++) {
                if (order.options[i].value === textToFind) {
                    order.selectedIndex = i;
                    break;
                }
            }
        ';

        $this->show_page($history);
    }
    
    //Displays the page
    private function show_page($history) {
        $this->data['pagebody'] = 'History/history_page';

        $this->data['history'] = $history;

        $this->render();
    }
    
    //Enables page navigation to keep track where it is
    private function pagenav($num) {
        //Determines which page its currently on
        $lastpage = ceil($this->history->size() / $this->items_per_page);
        
        $parms = array(
            'first' => 1,
            'previous' => (max($num-1,1)),
            'next' => min($num+1,$lastpage),
            'last' => $lastpage
        );
        
        return $this->parser->parse('History/itemnav',$parms,true);
    }
}