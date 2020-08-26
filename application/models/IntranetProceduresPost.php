<?php

class IntranetProceduresPost extends ActiveRecord\Model {

    static $table_name = 'intranet_procedures_post';

    static $belongs_to = array(
        array('intranet_project')
    );

}