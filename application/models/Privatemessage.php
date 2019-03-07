<?php

class Privatemessage extends ActiveRecord\Model
{
    public static function getMessages($limit, $max_value, $qdeleted, $user_id, $client = false)
    {
        $prefix = ($client) ? 'c' : 'u';

        $messages = Privatemessage::find_by_sql('SELECT * FROM
                (SELECT privatemessages.id, privatemessages.`status`,
                privatemessages.`deleted`,
                privatemessages.attachment,
                privatemessages.attachment_link,
                privatemessages.subject,
                privatemessages.conversation,
                privatemessages.sender,
                privatemessages.recipient,
                privatemessages.message,
                privatemessages.`time`,
                clients.`userpic` as userpic_c,
                users.`userpic` as userpic_u ,
                users.`email` as email_u ,
                clients.`email` as email_c ,
                CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c
				FROM privatemessages
				LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
				WHERE privatemessages.recipient = "' . $prefix . $user_id . '" ' . $qdeleted . ' ORDER BY privatemessages.`time`
                DESC LIMIT ' . $limit . $max_value . ') as messages
                GROUP BY conversation, messages.subject, messages.conversation

                -- GROUP BY conversation, messages.id, messages.status,
                -- messages.deleted, messages.attachment, messages.attachment_link,
                -- messages.subject, messages.conversation, messages.sender,
                -- messages.recipient, messages.message, messages.`time`,
                -- messages.userpic_c, messages.userpic_u, messages.email_u,
                -- messages.email_c, messages.sender_u, messages.sender_c

                ORDER BY `time` DESC');

                // var_dump($messages);

        return $messages;
    }

    public static function getMessagesWithFilter($limit, $max_value, $filter, $user_id, $client = false)
    {
        $prefix = ($client) ? 'c' : 'u';
        switch ($filter) {
            case 'read':
                $rule = 'LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
				GROUP by privatemessages.conversation HAVING privatemessages.recipient = "' . $prefix . $user_id . '" AND (privatemessages.`status`="Replied" OR privatemessages.`status`="Read") ORDER BY privatemessages.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'sent':
                $rule = 'LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.recipient
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.recipient
				WHERE privatemessages.sender = "' . $prefix . $user_id . '" ORDER BY privatemessages.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'marked':
                $rule = 'LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
				WHERE privatemessages.recipient = "' . $prefix . $user_id . '" AND privatemessages.`status`="Marked" ORDER BY privatemessages.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            case 'deleted':
                $rule = 'LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
				WHERE privatemessages.recipient = "' . $prefix . $user_id . '" AND (privatemessages.status = "deleted" OR privatemessages.deleted = 1) ORDER BY privatemessages.`time` DESC LIMIT ' . $limit . $max_value;
            break;
            default:
                $rule = 'LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
				GROUP by privatemessages.conversation HAVING privatemessages.recipient = "' . $prefix . $user_id . '" ORDER BY privatemessages.`time` DESC LIMIT ' . $limit . $max_value;
            break;
        }
        $messages = Privatemessage::find_by_sql('SELECT privatemessages.id, privatemessages.`status`, privatemessages.subject, privatemessages.attachment, privatemessages.attachment_link, privatemessages.message, privatemessages.sender, privatemessages.recipient, privatemessages.`time`, clients.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , clients.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c
				FROM privatemessages
				' . $rule);

        return $messages;
    }
}
