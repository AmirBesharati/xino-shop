<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 05/11/2017
 * Time: 10:00 AM
 */

namespace App\Classes\QueryBuilders;

/**
 * Class UrlHelper<br>
 * A class for work with urls
 * @package App\Classes\Utilities
 */
class UrlHelper
{

    /**
     * this method make url format from string<br>
     * first remove some character like [ ' , " , ( , ) ] from string and replace with null space<br>
     * then replace null space with dash character
     * @param $text string
     * @param $sep string seperator for fill null space between words
     * @return mixed string with url format
     */
    public static function PrepareForUrl($text, $sep='-'){

        $new_data = trim($text);
        $new_data = str_replace('ي', 'ی', $new_data);
        $new_data = str_replace('ك', 'ک', $new_data);
        $new_data = str_replace("'", "", $new_data);
        $new_data = str_replace('"', "", $new_data);
        $new_data = str_replace('(', "", $new_data);
        $new_data = str_replace(')', "", $new_data);
        $new_data = str_replace('.', "", $new_data);
        $name = str_replace(' ', "-", $new_data);

        $new_data = preg_replace('/[^\p{L}\p{N}]/u', $sep, $new_data);

        $new_data = str_replace(' ', $sep, $new_data);
        $new_data = str_replace($sep.$sep.$sep.$sep, $sep, $new_data);
        $new_data = str_replace($sep.$sep.$sep, $sep, $new_data);
        $new_data = str_replace($sep.$sep, $sep, $new_data);

        //$new_data=urlencode($new_data);
        return $new_data;

    }

    /**
     * Prepare given text for using in subdomain
     * @param $text
     * @param string $sep
     * @return mixed
     */
    public static function PrepareForSubdomain($text, $sep='-'){
        $new_data = str_replace("'", "", $text);
        $new_data = str_replace('_', "-", $new_data);
        $new_data = str_replace('"', "", $new_data);
        $new_data = str_replace('(', "", $new_data);
        $new_data = str_replace(')', "", $new_data);
        $new_data = str_replace("*", "", $new_data);
        $new_data = str_replace(".", "", $new_data);
        $new_data = str_replace("@", "", $new_data);
        $new_data = preg_replace('/[^\p{L}\p{N}]/u', '', $new_data);

        $new_data = str_replace(' ', '', $new_data);
        $new_data = str_replace($sep.$sep.$sep.$sep, $sep, $new_data);
        $new_data = str_replace($sep.$sep.$sep, $sep, $new_data);
        $new_data = str_replace($sep.$sep, $sep, $new_data);

        $new_data = strtolower($new_data);

        //$new_data=urlencode($new_data);
        return $new_data;
    }


    /**
     * get a base url and add/remove slash character to/from the first and end url
     * @param $base_url
     * @param bool $first_has_slash
     * @param bool $end_has_slash
     * @return string
     */
    public static function AddSlashesToBaseUrl($base_url, $first_has_slash=true, $end_has_slash=true)
    {
        $url = $base_url;
        if (substr($url,0,1)!='/'){
            if ($first_has_slash){
                $url = '/' . $url;
            }
        } else {
            if (!$first_has_slash){
                $url = substr($url,1,strlen($url)-1);
            }
        }
        if (substr($url,strlen($url)-1,1)!='/'){
            if ($end_has_slash){
                $url =  $url . '/';
            }
        } else {
            if (!$end_has_slash){
                $url = substr($url,0,strlen($url)-1);
            }
        }
        return $url;
    }

    /**
     * this method seperate post title from url<br>
     * this operation used for compare title in url with result of PrepareForUrl() from post title<br>
     * @param $text string url string
     * @return mixed url without id
     */
    public static function SeperateTitleFromUrl($text){
        $i=0;
        while($i<strlen($text) AND $text[$i]!='-'  ){
            $i++;
        }
        $i++;

        return substr($text,$i);
    }

    /**
     * this function remove following expression from url : <br>
     *<ul>
     * <li>http://www.</li>
     * <li>https://www.</li>
     * <li>www.</li>
     * <li>http://</li>
     * </ul>
     * @param $url string
     * @return mixed return url withod above items
     */
    public static function excludeHttpFromUrl($url)
    {
        $retStr = str_replace('http://www.', '', $url);
        $retStr = str_replace('https://www.', '', $retStr);
        $retStr = str_replace('www.', '', $retStr);
        $retStr = str_replace('http://', '', $retStr);
        $retStr = str_replace('https://', '', $retStr);
        return $retStr;
    }

    /**
     * this method add http to url<br>
     * this function use from "startsWith__()" function in self<br>
     * @param $url string url that must be added http to it.
     * @return string url included http
     */
    public static function includeHttpToUrl($url)
    {
        $retStr = $url;
        if (!self::startsWith__($url,'http://') && !self::startsWith__($url,'https://')) {
            $retStr = 'http://' . $url;
        }
        return $retStr;
    }

    /**
     * this method get a url and expression like " http " then get substr from <strong>first of  url</strong>  as much as expression lenght<br>
     * then comapre this substr with expression and return true or false
     * @param $haystack string url that get substr from it
     * @param $needle string expression that make get substr from $haystack as much as this
     * @return bool result of compare between $haystack substr and $needle
     */
    public static function startsWith__($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * this method get a url and expression like " http " then get substr from  <strong>end of  url</strong> as much as expression lenght<br>
     * then comapre this substr with expression and return true or false
     * @param $haystack string url that get substr from it
     * @param $needle string expression that make get substr from $haystack as much as this
     * @return bool result of compare between $haystack substr and $needle
     */
    public static function endsWith__($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }

    /**
     * this method generate email format to prevent abuse by robot
     * @param $mail string
     * @return mixed
     */
    public static function make_email_right_format($mail)
    {
        $right_mail = str_replace("@", "[at]", $mail);
        $right_mail = str_replace(".", "[dot]", $right_mail);
        return $right_mail;
    }

}
