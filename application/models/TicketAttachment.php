<?php

class TicketAttachment extends ActiveRecord\Model {
    static $table_name = 'ticket_attachment';

    static $belongs_to = array(
     array('ticket')
  	);
}
