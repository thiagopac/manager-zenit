<?php

class PrivateMessage extends ActiveRecord\Model{
    static $table_name = 'private_message';

    public static function getMessages($limit, $max_value, $qdeleted, $user_id, $client = false)
    {
        $prefix = ($client) ? 'c' : 'u';

        $messages = PrivateMessage::find_by_sql('SELECT * FROM
                (SELECT private_message.id, private_message.`status`,
                private_message.`deleted`,
                private_message.attachment,
                private_message.attachment_link,
                private_message.subject,
                private_message.conversation,
                private_message.sender,
                private_message.recipient,
                private_message.message,
                private_message.`time`,
                client.`userpic` as userpic_c,
                users.`userpic` as userpic_u ,
                users.`email` as email_u ,
                client.`email` as email_c ,
                CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c
				FROM private_message
				LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.sender
				WHERE private_message.recipient = "' . $prefix . $user_id . '" ' . $qdeleted . ' ORDER BY private_message.`time`
                DESC LIMIT ' . $limit . $max_value . ') as messages
                GROUP BY conversation, messages.subject, messages.conversation
                ORDER BY `time` DESC');

                // var_dump($messages);

        return $messages;
    }

    public static function getMessagesWithFilter($limit, $max_value, $filter, $user_id, $client = false)
    {
        $prefix = ($client) ? 'c' : 'u';
        switch ($filter) {
            case 'read':
                $rule = 'LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.sender
				GROUP by private_message.conversation HAVING private_message.recipient = "' . $prefix . $user_id . '" AND (private_message.`status`="Replied" OR private_message.`status`="Read") ORDER BY private_message.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'sent':
                $rule = 'LEFT JOIN client ON CONCAT("c",client.id) = private_message.recipient
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.recipient
				WHERE private_message.sender = "' . $prefix . $user_id . '" ORDER BY private_message.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'marked':
                $rule = 'LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.sender
				WHERE private_message.recipient = "' . $prefix . $user_id . '" AND private_message.`status`="Marked" ORDER BY private_message.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'deleted':
                $rule = 'LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.sender
				WHERE private_message.recipient = "' . $prefix . $user_id . '" AND (private_message.status = "deleted" OR private_message.deleted = 1) ORDER BY private_message.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            default:
                $rule = 'LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
				LEFT JOIN users ON CONCAT("u",users.id) = private_message.sender
				GROUP by private_message.conversation HAVING private_message.recipient = "' . $prefix . $user_id . '" ORDER BY private_message.`time` DESC LIMIT ' . $limit . $max_value;
            break;
        }
        $messages = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.`status`, private_message.subject, private_message.attachment, private_message.attachment_link, private_message.message, private_message.sender, private_message.recipient, private_message.`time`, client.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , client.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c
				FROM private_message
				' . $rule);

        return $messages;
    }
}
