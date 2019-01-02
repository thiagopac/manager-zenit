<?php

class TicketHasAttachment extends ActiveRecord\Model {
    static $table_name = 'ticket_has_attachments';

    static $belongs_to = array(
     array('ticket')
  	);
}
