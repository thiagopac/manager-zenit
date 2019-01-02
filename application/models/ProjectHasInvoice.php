<?php

class ProjectHasInvoice extends ActiveRecord\Model {
    static $table_name = 'project_has_invoices';

   	
    static $belongs_to = array(
     array('invoice')
  );
  
}
