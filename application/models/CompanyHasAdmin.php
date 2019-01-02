<?php

class CompanyHasAdmin extends ActiveRecord\Model {
    static $table_name = 'company_has_admins';

    static $belongs_to = array(
     array('user'),
     array('company')
  );
  
}