<?php

class CompanyAdmin extends ActiveRecord\Model {
    static $table_name = 'company_admin';

    static $belongs_to = array(
     array('user'),
     array('company')
  );
  
}