<?php

class Ticket extends ActiveRecord\Model {

    static $table_name = 'ticket';

    public static $belongs_to = [
     ['company'],
     ['client'],
     ['user'],
     ['queue'],
     ['type'],
     ['project'],
  ];

    public static $has_many = [
    ['ticket_article'],
    ['ticket_attachment'],
    ];

    public static function newTicketCount($userId, $comp_array)
    {
        $filter = '';
        if ($comp_array != false) {
            $comp_array = ($comp_array == '') ? 0 : $comp_array;
            $filter = "(user_id = $userId 
                    OR company_id in (" . $comp_array . ')) AND ';
        }

        $ticketCount = Ticket::count(
                ['conditions' => $filter . "
                      status = 'New'"
                    ]
            );
        return $ticketCount;
    }

    public function getLastArticle()
    {
        $article = end($this->ticket_article);
        return $article;
    }
}
