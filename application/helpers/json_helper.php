<?php 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function json_response($status = false, $message = false, $data = false)
{
    header('Content-Type: application/json');
    $array = array(
                    "status" => $status,
                    "message" => $message,
                    "data" => $data
                  );

    $json = json_encode($array);
    echo $json;
    exit;
}

function object_to_array($object = false, $user = false)
{
    $data = array();
    foreach ($object as $p) {
        $res = $p->to_array();
        if ($user && is_object($p->user)) {
            $res['user'] = $p->user->to_array(array("only" => array('firstname', 'lastname', 'email', 'userpic')));
            $res['user']['userpic'] = get_user_pic($res['user']['userpic'], $res['user']['email']);
        }
        array_push($data, $res);
    }

    // $data = "[".implode(",", $data)."]";
    // $data = str_replace('":', '":"', $data);
    // $data = str_replace(',"', '","', $data);
    // $data = str_replace('""', '"', $data);
    return $data;
}

class JsonSerializer extends SimpleXmlElement implements JsonSerializable
{
    /**
     * SimpleXMLElement JSON serialization
     *
     * @return null|string
     *
     * @link http://php.net/JsonSerializable.jsonSerialize
     * @see JsonSerializable::jsonSerialize
     */
    public function jsonSerialize()
    {
        if (count($this)) {
            // serialize children if there are children
            foreach ($this as $tag => $child) {
                // child is a single-named element -or- child are multiple elements with the same name - needs array
                if (count($child) > 1) {
                    $child = [$child->children()->getName() => iterator_to_array($child, false)];
                }
                $array[$tag] = $child;
            }
        } else {
            // serialize attributes and text for a leaf-elements
            foreach ($this->attributes() as $name => $value) {
                $array["_$name"] = (string) $value;
            }
            $array["__text"] = (string) $this;
        }

        if ($this->xpath('/*') == array($this)) {
            // the root element needs to be named
            $array = [$this->getName() => $array];
        }

        return $array;
    }
}
