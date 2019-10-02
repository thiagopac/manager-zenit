<?php

class TicketType extends ActiveRecord\Model {
    static $table_name = 'ticket_type';
    static $has_many = [
        ['ticket', "foreign_key" => 'ticket_id']
    ];
}
