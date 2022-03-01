<?php
/**
 * Created by PhpStorm.
 * User: Amirreza
 * Date: 13/08/2017
 * Time: 10:40
 */

namespace App\Classes\QueryBuilders;

/**
 * Class UrlQueryStringMaker<br>
 * A class to add key value pairs to list and convert them to url query string
 * @package App\Classes\Utilities
 */
class UrlQueryStringMaker
{

    private $data = null;

    public function __construct()
    {
        $this->data = [];
    }

    /**
     * Add key value to first of list of data
     * @param $key
     * @param $value
     */
    public function add_to_first($key, $value)
    {
        $this->remove($key);
        $new_item = [$key=>$value];
        $this->data = $new_item + $this->data;
    }

    /**
     * Add key value to list of data
     * @param $key
     * @param $value
     */
    public function add($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * remove a key from list of data
     * @param $key
     */
    public function remove($key)
    {
        if (isset($this->data[$key])){
            unset($this->data[$key]);
        }
    }

    /**
     * get count of keys in the list
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * add query string with ? sign to given url
     * @param string $url full url
     * @return string url
     */
    public function get_url_with_query_string($url='')
    {
        $query_string = http_build_query($this->data);
        if (!empty($query_string)){
            $query_string = '?' . $query_string;
        }
        return $url . $query_string;
    }

}
