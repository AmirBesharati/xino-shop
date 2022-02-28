<?php
/**
 * Created by PhpStorm.
 * User: 7
 * Date: 5/25/2016
 * Time: 4:11 PM
 */

namespace App\Classes\QueryBuilders;


/**
 * Class Pagination
 * @package App\Classes
 */
class Pagination
{
    /**
     * @var int
     */
    private $records_per_page = 20;
    /**
     * @var int
     */
    private $total_records = 20;
    /**
     * @var int
     */
    private $number_of_links = 5;
    /**
     * @var int
     */
    private $current_page = 1;


    /**
     * @return int
     */
    public function getRecordsPerPage()
    {
        return $this->records_per_page;
    }

    /**
     * @param int $records_per_page
     */
    public function setRecordsPerPage($records_per_page)
    {
        $this->records_per_page = $records_per_page;
    }

    /**
     * @return int
     */
    public function getTotalRecords()
    {
        return $this->total_records;
    }

    /**
     * @param int $total_records
     */
    public function setTotalRecords($total_records)
    {
        $this->total_records = $total_records;
    }

    /**
     * @return int
     */
    public function getNumberOfLinks()
    {
        return $this->number_of_links;
    }

    /**
     * @param int $number_of_links
     */
    public function setNumberOfLinks($number_of_links)
    {
        $this->number_of_links = $number_of_links;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
     * @param int $current_page
     */
    public function setCurrentPage($current_page)
    {
        $this->current_page = $current_page;
    }


    /**
     * Pagination constructor.
     */
    public function __construct()
    {


    }


    /**
     * generate pagination link from records
     * this method calculate middle link,number of link or number of pagination links and current page
     * @return array array of pagination generated links
     */
    public function get_PaginationArray(){
        $links = [];
        $pageCount = $this->get_page_count();
        $middleLink =  ($this->number_of_links)/2+1;
        $startLink = 0;
        $endLink = $this->number_of_links;

        if ($this->records_per_page >= $this->total_records){
            return $links;
        }

        if ($this->current_page > $pageCount){
            $this->current_page = $pageCount;
        } else if ($this->current_page <1){
            $this->current_page = 1;
        }

        if ($this->current_page < $middleLink){
            $startLink =1;
            $endLink = $this->number_of_links;
        }elseif ($this->current_page > $pageCount -$middleLink){
            $endLink = $pageCount;
            $startLink = $pageCount - $this->number_of_links + 1;
        }else{
            $startLink = $this->current_page - ($middleLink - 1);
            $endLink = $this->current_page + ($middleLink -1);
        }


        /*if ($startLink>1){
            $links[]=1;
        }*/
        for ($i=$startLink;$i<=$endLink;$i++){
            if ($this->current_page==$i) {
                // current page
                if ($i>$pageCount || $i<1){
                    //$links[]=0;
                } else {
                    $links[] =  $i ;
                }
            }
            else {
                if ($i>$pageCount || $i<1){
                    //$links[]=0;
                } else {
                    $links[] = $i;
                }
            }
        }

        /*if ($pageCount>$endLink){
            $links[]=$pageCount;
        }*/

        return $links;
    }


    /**
     * this method calculate next page from current page for pagination links
     * @return int number of next page
     */
    public function get_next_page()
    {
        $pageCount = floor(($this->total_records-1)/$this->records_per_page)+1;

        if ($this->current_page>=$pageCount) {
            return 0;
        } else{
            return $this->current_page+1;
        }

    }

    /**
     * this method calculate previous page from current page for pagination links
     * @return int number of previous page
     */
    public function get_prev_page()
    {

        if ($this->current_page<=1) {
            return 0;
        } else{
            return $this->current_page-1;
        }

    }

    public function get_page_count()
    {
        return floor(($this->total_records-1)/$this->records_per_page)+1;;
    }

}
