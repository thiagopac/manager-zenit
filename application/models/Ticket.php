<?php

class Ticket extends ActiveRecord\Model
{
    public static $belongs_to = [
     ['company'],
     ['client'],
     ['user'],
     ['queue'],
     ['type'],
     ['project'],
  ];

    public static $has_many = [
    ['ticket_has_articles'],
    ['ticket_has_attachments'],
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
        $article = end($this->ticket_has_articles);
        return $article;
    }
}

class TicketHasArticle extends ActiveRecord\Model
{
    public static $belongs_to = [
     ['ticket'],
     ['user'],
     [
               'client',
            'foreign_key' => 'email',
            'primary_key' => 'from',
        ],
  ];
    public static $has_many = [
      ['article_has_attachments', 'foreign_key' => 'article_id']
    ];
}
