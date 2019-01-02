<?php

class Subscription extends ActiveRecord\Model {
    static $belongs_to = array(
    array('company')
    );
    static $has_many = array(
    array('subscription_has_items'),
    array('invoices')
 	); 

 	public static function newInvoiceOutstanding($comp_array, $date){
 		$newInvoiceOutstanding = '';
		$newInvoiceOutstanding = Subscription::find_by_sql("SELECT
			 	* 
			FROM 
				`subscriptions` 
			WHERE 
				`status` != 'Inactive' 
			AND 
				`end_date` > '$date' 
			AND 
				`next_payment` <= '$date' 
			ORDER BY 
				`next_payment`
		");

		return $newInvoiceOutstanding;
 	}

}