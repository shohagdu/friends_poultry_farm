<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    function table($table) {
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function table_row($table, $column_name, $column_value) {
        $query = $this->db->get_where($table, array($column_name => $column_value));
        return $query->row();
    }

    function table_data($table, $column_name, $column_value) {
        $query = $this->db->get_where($table, array($column_name => $column_value));
        return $query->result_array();
    }

    function table_transaction($class, $type) {
        $query = $this->db->get_where('transaction', array('class' => $class, 'type' => $type));
        return $query->result_array();
    }

    function table_transaction_open($class, $type) {
        $query = $this->db->get_where('transaction', array('class' => $class, 'type' => $type, 'date <' => date('Y-m-d')));
        return $query->result_array();
    }

    function table_transaction_daily($class, $type) {
        $query = $this->db->get_where('transaction', array('class' => $class, 'type' => $type, 'date' => date('Y-m-d')));
        return $query->result_array();
    }

    function insert_data($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    // update data by id of a database table
    function update_data($table_name, $data, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        $this->db->update($table_name, $data);
        return $this->db->affected_rows();
    }

    function login_check($table_name, $email, $password) {

        // $sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";
        //echo $sql;die;
        $query = $this->db->get_where($table_name, array('email' => $email, 'password' => $password));
        return $query->row_array();
    }

    // delete data by id of a database table
    function delete_data($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        $this->db->delete($table_name);
        return $this->db->affected_rows();
    }


    
    


    public function viewMonthTotalPurchase($tableName, $sumField, $whereField) {
        return false;
        $date = date("m");
        $this->db->select('SUM(' . $sumField . ') as total');
        $this->db->where('month(' . $whereField . ')', $date);
        $q = $this->db->get($tableName);
        $row = $q->row();
        if ($row->total != '') {
            return $row->total;
        } else {
            return 0;
        }
    }
    public function viewMonthTotalExpense($tableName, $sumField, $whereField) {
        return false;
        $date = date("m");
        $this->db->select('SUM(' . $sumField . ') as total');
        $this->db->where('month(' . $whereField . ')', $date);
        $q = $this->db->get($tableName);
        $row = $q->row();
        if ($row->total != '') {
            return $row->total;
        } else {
            return 0;
        }
    }
    

    // get data list by single column of a database table
    function get_data_list_by_single_column($table_name, $column_name, $column_value, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->result_array();
    }

    // get all data list of a database table
    function get_data_list($table_name, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        return $this->db->get($table_name)->result_array();
    }



    function table_info($table, $column_name, $column_value) {
        $query = $this->db->get_where($table, array($column_name => $column_value));
        return $query->row();
    }

    function get_data_list1($table_name, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        return $this->db->get($table_name)->row_array();
    }

    // get single data by single column of a database table
    function get_single_data_by_single_column($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->row_array();
    }


    function get_single_data_by_single_columns($table_name, $column_name, $column_value) {
        $this->db->where($column_name, $column_value);
        return $this->db->get($table_name)->result_array();
    }




    function get_value_from_admin($table_name, $column_name, $member_id) {
        $sql = "SELECT " . $column_name . " FROM " . $table_name . " WHERE admin_id ='$member_id'";
        $query = $this->db->query($sql);
        $value = $query->row_array();
        foreach ($value as $each_value) {
            $value = $each_value;
        }

        return $value;
    }

    // get single data by many columns of a database table
    function get_data_list_by_many_columns($table_name, $column_array, $order_column_name = NULL, $order = NULL, $start_limit = NULL, $per_page = NULL) {
        $this->db->where($column_array);
        if (isset($order_column_name) && isset($order))
            $this->db->order_by($order_column_name, $order);
        if (isset($start_limit))
            $this->db->limit($per_page, $start_limit);
        return $this->db->get($table_name)->result_array();
    }

    // get single data by many columns of a database table
    function get_single_data_by_many_columns($table_name, $column_array) {
        $this->db->where($column_array);
        $result = $this->db->get($table_name)->row_array();
        return $result;
        //dumpVar($result);
    }

    // get number of rows of a database table
    function count_all_data($table_name) {
        return $this->db->count_all($table_name);
    }

    function category_product($category_id) {
        $query_catpro = $this->get_product_by_category($category_id);
        $result = '';
        if (!empty($query_catpro)) {
            $result.='<option selected="selected">(:-- Select Product --:)</option>';
            foreach ($query_catpro as $row_catpro):
                $result.='<option value="' . $row_catpro->price . '" productid="' . $row_catpro->product_id . '" productname="' . $row_catpro->name . '">' . $row_catpro->name . '</option>';
            endforeach;
        }else {
            $result.='<option value="">No Product Found! </option>';
        }
        return $result;
    }

    function get_total_product_price($general_id) {

        //echo $general_id;die;
        $sql = "SELECT SUM(dp_price) AS TotalItemsprice FROM stock WHERE generals_id='$general_id'";
        //$sql = "SELECT SUM(dp_price) AS TotalItemsprice FROM stock WHERE generals_id='79'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /* in_words */

    function get_bd_money_format($amount) {
        $output_string = '';
        $fraction = '';
        $tokens = explode('.', $amount);
        $number = $tokens[0];

        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = '.' . $fraction;
        }

        $number = $number . '';
        $spl = str_split($number);
        $lpcount = count($spl);
        $rem = $lpcount - 3;
        //echo "rem".$rem."";
        //even one
        if ($lpcount % 2 == 0) {
            for ($i = 0; $i <= $lpcount - 1; $i++) {
                if ($i % 2 != 0 && $i != 0 && $i != $lpcount - 1) {
                    $output_string .= ",";
                }
                $output_string .= $spl[$i];
            }
        }

        //odd one
        if ($lpcount % 2 != 0) {
            for ($i = 0; $i <= $lpcount - 1; $i++) {
                if ($i % 2 == 0 && $i != 0 && $i != $lpcount - 1) {
                    $output_string .= ",";
                }
                $output_string .= $spl[$i];
            }
        }
        return $output_string . $fraction;
    }

    function translate_to_words($number) {
        /*         * ***
         * A recursive function to turn digits into words
         * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.
         */

        // zero is a special case, it cause problems even with typecasting if we don't deal with it here
        $max_size = pow(10, 18);
        if (!$number)
            return "zero";
        if (is_int($number) && $number < abs($max_size)) {
            $prefix = '';
            $suffix = '';
            switch ($number) {
                // setup up some rules for converting digits to words
                case $number < 0:
                    $prefix = "negative";
                    $suffix = $this->translate_to_words(-1 * $number);
                    $string = $prefix . " " . $suffix;
                    break;
                case 1:
                    $string = "one";
                    break;
                case 2:
                    $string = "two";
                    break;
                case 3:
                    $string = "three";
                    break;
                case 4:
                    $string = "four";
                    break;
                case 5:
                    $string = "five";
                    break;
                case 6:
                    $string = "six";
                    break;
                case 7:
                    $string = "seven";
                    break;
                case 8:
                    $string = "eight";
                    break;
                case 9:
                    $string = "nine";
                    break;
                case 10:
                    $string = "ten";
                    break;
                case 11:
                    $string = "eleven";
                    break;
                case 12:
                    $string = "twelve";
                    break;
                case 13:
                    $string = "thirteen";
                    break;
                // fourteen handled later
                case 15:
                    $string = "fifteen";
                    break;
                case $number < 20:
                    $string = $this->translate_to_words($number % 10);
                    // eighteen only has one "t"
                    if ($number == 18) {
                        $suffix = "een";
                    } else {
                        $suffix = "teen";
                    }
                    $string .= $suffix;
                    break;
                case 20:
                    $string = "twenty";
                    break;
                case 30:
                    $string = "thirty";
                    break;
                case 40:
                    $string = "forty";
                    break;
                case 50:
                    $string = "fifty";
                    break;
                case 60:
                    $string = "sixty";
                    break;
                case 70:
                    $string = "seventy";
                    break;
                case 80:
                    $string = "eighty";
                    break;
                case 90:
                    $string = "ninety";
                    break;
                case $number < 100:
                    $prefix = $this->translate_to_words($number - $number % 10);
                    $suffix = $this->translate_to_words($number % 10);
                    //$string = $prefix . "-" . $suffix;
                    $string = $prefix . " " . $suffix;
                    break;
                // handles all number 100 to 999
                case $number < pow(10, 3):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 2)))) . " hundred";
                    if ($number % pow(10, 2))
                        $suffix = " and " . $this->translate_to_words($number % pow(10, 2));
                    $string = $prefix . $suffix;
                    break;
                case $number < pow(10, 6):
                    // floor return a float not an integer
                    $prefix = $this->translate_to_words(intval(floor($number / pow(10, 3)))) . " thousand";
                    if ($number % pow(10, 3))
                        $suffix = $this->translate_to_words($number % pow(10, 3));
                    $string = $prefix . " " . $suffix;
                    break;
            }
        } else {
            echo "ERROR with - $number Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
        }
        return $string;
    }

    function get_us_amount_in_text($amount) {

        $output_string = '';

        $tokens = explode('.', $amount);
        $current_amount = $tokens[0];
        $fraction = '';
        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = (int) $fraction;
            $fraction = $this->translate_to_words($fraction) . ' Cents';
            $fraction = ' Dollars & ' . $fraction;
        }

        $crore = 0;
        if ($current_amount >= pow(10, 7)) {
            $crore = (int) floor($current_amount / pow(10, 7));
            $output_string .= $this->translate_to_words($crore) . ' crore ';
            $current_amount = $current_amount - $crore * pow(10, 7);
        }

        $lakh = 0;
        if ($current_amount >= pow(10, 5)) {
            $lakh = (int) floor($current_amount / pow(10, 5));
            $output_string .= $this->translate_to_words($lakh) . ' lakh ';
            $current_amount = $current_amount - $lakh * pow(10, 5);
        }

        $current_amount = (int) $current_amount;
        $output_string .= $this->translate_to_words($current_amount);

        $output_string = $output_string . $fraction . ' only';
        $output_string = ucwords($output_string);
        return $output_string;
    }

    function get_bd_amount_in_text($amount) {

        $output_string = '';

        $tokens = explode('.', $amount);
        $current_amount = $tokens[0];
        $fraction = '';
        if (count($tokens) > 1) {
            $fraction = (double) ('0.' . $tokens[1]);
            $fraction = $fraction * 100;
            $fraction = round($fraction, 0);
            $fraction = (int) $fraction;
            $fraction = $this->translate_to_words($fraction) . ' Poisa';
            $fraction = ' Taka & ' . $fraction;
        }

        $crore = 0;
        if ($current_amount >= pow(10, 7)) {
            $crore = (int) floor($current_amount / pow(10, 7));
            $output_string .= $this->translate_to_words($crore) . ' crore ';
            $current_amount = $current_amount - $crore * pow(10, 7);
        }

        $lakh = 0;
        if ($current_amount >= pow(10, 5)) {
            $lakh = (int) floor($current_amount / pow(10, 5));
            $output_string .= $this->translate_to_words($lakh) . ' lakh ';
            $current_amount = $current_amount - $lakh * pow(10, 5);
        }

        $current_amount = (int) $current_amount;
        $output_string .= $this->translate_to_words($current_amount);

        $output_string = $output_string . $fraction . ' only';
        $output_string = ucwords($output_string);
        return $output_string;
    }

    function last_rate() {
        $this->db->select_max('rate_id');
        $query = $this->db->get('rate');
        return $query->row_array();
    }
    
    function get_result($select, $table, $order_by=null, $where=null, $groupBy=null, $limit=null){
        $this->db->select($select);
        $this->db->from($table);        
        if($order_by){ $this->db->order_by($order_by); }
        if($where){ $this->db->where($where); }        
        if($groupBy){ $this->db->group_by($groupBy); }         
        if($limit){ $this->db->limit($limit); }         
        return $this->db->get()->result_array();
    }
    function get_row($select, $table, $where= null){
        $this->db->select($select);
        $this->db->from($table);
        if($where){ $this->db->where($where); }        
        return $this->db->get()->row_array(); 
    }
    function getConfigInfo($select, $table){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->order_by("id","DES");
        $this->db->limit("1");
        return $this->db->get()->row();
    }
    function checking_duplicate($table_name, $column_name, $column_value) {
        $this->db->select($column_name);
        $this->db->where($column_name, $column_value);
        $query= $this->db->get($table_name);
        if($query->num_rows()>0){
            return ['status'=>'found','message'=>'Data found successfully']; // Duplicate Data
        }else{
            return ['status'=>'not_found','message'=>'No data found']; // No Duplicate Data
        }

    }
    public function generateRandomNo($prefix=NULL,$length = 6,$from_tbl=NULL,$from_field=NULL)
    {
        $characters = '123456789ABCDEFLMRW';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $random = $prefix . $randomString;
        $exits = $this->get_single_data_by_single_column($from_tbl, $from_field, $random);
        if (!empty($exits)) {
            return   $this->generateRandomString();
        } else {
            return $random;
        }
    }
    function table_data_selected($select,$table, $column_name, $column_value) {
        $query = $this->db->select($select)->get_where($table, array($column_name => $column_value));
        return $query->result();
    }
    public function get_join($table, $where = FALSE, $field_rows = '*', $limit = FALSE, $order_by = FALSE, $where_in_parmas = FALSE, $join_parmas = FALSE, $group_by = FALSE, $like = FALSE) {
        $this->db->select($field_rows);
        $this->db->from($table);

        if (!empty($join_parmas)) {
            foreach ($join_parmas as $join_item) {
                if (isset($join_item['type'])) {
                    $this->db->join($join_item['table'], $join_item['relation'], $join_item['type']);
                } else {
                    $this->db->join($join_item['table'], $join_item['relation']);
                }
            }
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($where_in_parmas)) {
            if (isset($where_in_parmas['key']) && isset($where_in_parmas['values'])) {
                $this->db->where_in($where_in_parmas['key'], $where_in_parmas['values']);
            } else {
                foreach ($where_in_parmas as $where_in) {
                    $this->db->where_in($where_in['key'], $where_in['values']);
                }
            }
        }

        if (!empty($like)) {
            $this->db->like($like);
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }

        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        if (!empty($order_by)) {

            if(isset($order_by[0]) && is_array($order_by[0]) && sizeof($order_by[0]) >0){
                foreach ($order_by as $orow){
                    $this->db->order_by($orow['field'], $orow['order']);
                }
            }else{
                $this->db->order_by($order_by['field'], $order_by['order']);
            }

        }

        $query = $this->db->get();
        // return  $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
}