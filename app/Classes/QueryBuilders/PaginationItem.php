<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 04/11/2017
 * Time: 02:41 PM
 */

namespace App\Classes\QueryBuilders;

/**
 * Class PaginationItem
 * @package App\Classes\QueryBuilders
 */
class PaginationItem
{

    const PAGE_TYPE_NEXT = 'next';
    const PAGE_TYPE_PREV = 'prev';
    const PAGE_TYPE_CURRENT = 'current';
    const PAGE_TYPE_NOTHING = null;


    public $page_number = null;
    public  $url = null;
    public  $page_type = self::PAGE_TYPE_NOTHING;
    public  $text = null;
    public  $css_class = null   ;

    /**
     * @return null
     */
    public function getPageNumber()
    {
        return $this->page_number;
    }

    /**
     * @param null $page_number
     */
    public function setPageNumber($page_number)
    {
        $this->page_number = $page_number;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getPageType()
    {
        return $this->page_type;
    }

    /**
     * @param string $page_type
     */
    public function setPageType($page_type)
    {
        $this->page_type = $page_type;
    }

    /**
     * @return null
     */
    public function getText()
    {

        if ($this->text===null){
            return  $this->get_text_by_page_type();
        } else {
            return $this->text;
        }
    }

    /**
     * @param null $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return null
     */
    public function getCssClass()
    {
        if ($this->css_class===null){
            return $this->get_css_class_by_page_type();
        } else {
            return $this->css_class;
        }
    }

    /**
     * @param null $css_class
     */
    public function setCssClass($css_class)
    {
        if ($css_class===null){
            $this->css_class = $this->get_css_class_by_page_type();
        } else {
            $this->css_class = $css_class;
        }
    }




    public function __construct($page_number = null, $url = null, $page_type = self::PAGE_TYPE_NOTHING, $text = null,$css_class = null)
    {
        $this->setPageNumber($page_number);
        $this->setUrl($url);
        $this->setPageType($page_type);
        $this->setText($text);
        $this->setCssClass($css_class);
    }


    /**
     * Return text for current page item, for example 1 , prev , next
     * @return null|string
     */
    public function get_text_by_page_type()
    {
        switch ($this->page_type){
            case self::PAGE_TYPE_PREV:
                return '<i class="fa fa-angle-right"></i>';
                break;
            case self::PAGE_TYPE_NOTHING:
                return $this->page_number;
                break;
            case self::PAGE_TYPE_CURRENT:
                return $this->page_number;
                break;
            case self::PAGE_TYPE_NEXT:
                return '<i class="fa fa-angle-left"></i>';
                break;
            default:
                return $this->page_number;
                break;
        }
    }

    /**
     * Get css class for current page item
     * @return null|string
     */
    public function get_css_class_by_page_type()
    {
        switch ($this->page_type){
            case self::PAGE_TYPE_PREV:
                return 'prev';
                break;
            case self::PAGE_TYPE_NOTHING:
                return '';
                break;
            case self::PAGE_TYPE_CURRENT:
                return 'active';
                break;
            case self::PAGE_TYPE_NEXT:
                return 'next';
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Get css class with class="" term
     * @return string
     */
    public function get_complete_css_class()
    {
        $class_name = $this->getCssClass();
        if ($class_name!=null){
            return 'class="'.$class_name.'"';
        }
        return '';
    }




}