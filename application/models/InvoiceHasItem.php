<?php

class InvoiceHasItem extends ActiveRecord\Model {
    static $table_name = 'invoice_has_items';

  	static $belongs_to = array(
     array('project_has_task', 'foreign_key' => 'task_id'),
  );
}
