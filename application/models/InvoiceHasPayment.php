<?php

class InvoiceHasPayment extends ActiveRecord\Model {
    static $table_name = 'invoice_has_payments';

    static $belongs_to = array(
     array('invoice'),
     array('user'),
  );

  
}
