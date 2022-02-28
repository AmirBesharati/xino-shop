<?php
/**
 * Created by PhpStorm.
 * User: Majid
 * Date: 28/10/2017
 * Time: 01:23 PM
 */

namespace App\Classes\QueryBuilders;


use App\Classes\QueryBuilders\UrlHelper;
use App\Classes\QueryBuilders\UrlQueryStringMaker;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

/**
 * Class BaseFilter<br>
 * Base Filter class for filtering models <br>
 * This class contains some base methods for filtering such as get_result , pagination and ...
 * @package App\Classes\QueryBuilders
 */
abstract class BaseFilter
{

    # static properties

    public static $value_separator = ',';

    //-------------------------static properties




    private $page = 1;
    private $per_page = 20;
    private $start_url_with = '';
    private $anchor_in_url = null;
    private $starter_query = null;


    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page if this parameter is null or negative set it to 1
     */
    public function setPage($page)
    {
        if ($page==null || $page<=0){
            $this->page=1;
        }else {
            $this->page = $page;
        }
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
    }

    /**
     * @return string
     */
    public function getStartUrlWith()
    {
        return $this->start_url_with;
    }

    /**
     * @param string $start_url_with add / to first of parameter and remove / from end of parameter
     */
    public function setStartUrlWith($start_url_with)
    {
        $this->start_url_with = UrlHelper::AddSlashesToBaseUrl($start_url_with);
    }

    /**
     * @return null
     */
    public function getAnchorInUrl()
    {
        return $this->anchor_in_url;
    }

    /**
     * @param null $anchor_in_url
     */
    public function setAnchorInUrl($anchor_in_url)
    {
        $this->anchor_in_url = $anchor_in_url;
    }

    /**
     * @return null
     */
    public function getStarterQuery()
    {
        return $this->starter_query;
    }

    /**
     * @param null $starter_query
     */
    public function setStarterQuery($starter_query)
    {
        $this->starter_query = $starter_query;
    }






    /**
     * return url with default url builder object
     * @return string base url
     */
    public function get_url_from_this_object()
    {
        $final_url = $this->getStartUrlWith();
        $url_builder = $this->get_default_url_builder();

        return $url_builder->get_url_with_query_string($final_url);

    }

    /**
     * Return default UrlQueryStringMaker object <br>
     * It is better to override this method
     * @return UrlQueryStringMaker
     */
    protected function get_default_url_builder()
    {
        $url_builder = new UrlQueryStringMaker();
        //if ($this->getPage()!=null and $this->getPage()>1){
        if ($this->getPage() != null) {
            $url_builder->add_to_first('page',$this->getPage());
        }

        return $url_builder;

    }

    /**
     * read and set properties from Request <br>
     * It is better to first call this method in child classes to set default properties, and then set child properties
     * @param Request $request
     */
    public function make_object_from_request(Request $request)
    {
        $this->setPage($request->get('page'));


    }

    public function make_object_from_request_arr($request)
    {

        if(isset($request['page'])){

            $this->setPage($request['page']);
        }
    }

    /**
     * @return mixed
     */
    abstract public function get_query();


    private $get_count_of_all_holder = null;
    /**
     * get count of this query
     * @return mixed
     */
    public function get_count_of_all()
    {
        if ( $this->get_count_of_all_holder !== null){
            return $this->get_count_of_all_holder;
        }
        $query = $this->get_query();

        $this->get_count_of_all_holder = $query->count();
        return $this->get_count_of_all_holder;
    }

    /**
     * return result by adding pagination query to this objects query
     * @return mixed
     */
    public function get_result()
    {
        $query = $this->get_query();
        if ($this->getPage()!=null){
            // set pagination
            $start = ($this->getPage()-1)*$this->getPerPage();
            $query->skip($start)->take($this->getPerPage());
        }
        $results = $query->get();
        return $results;
    }



    /**
     * return pagination array
     * @param $absolute bool
     * @return array array of PaginationItem
     */
    public function get_pagination_links($absolute=false)
    {
        $paging = $this->get_pagination_object();
        $links = $paging->get_PaginationArray();
        $new_filter = clone $this;
        $urlArray = [];
        $prevPage = $paging->get_prev_page();
        $page_url = "";
        if ($prevPage>0){
            $new_filter->setPage($prevPage);
            $page_url = $new_filter->get_url_from_this_object();
            if ($absolute){
                $page_url = url($page_url);
            }
            $pagination_item = new PaginationItem($prevPage, $page_url,PaginationItem::PAGE_TYPE_PREV );
            $urlArray[] = $pagination_item;
        }

        foreach ($links as $li) {
            $new_filter->setPage($li);
            //$li==$this->jobalert_user_filter_->getPage())?'current':'';
            $page_url = $new_filter->get_url_from_this_object();

            if ($absolute){
                $page_url = url($page_url);
            }
            if ($li==$this->getPage()){
                $pagination_item = new PaginationItem($li, $page_url,PaginationItem::PAGE_TYPE_CURRENT );
            } else {
                $pagination_item = new PaginationItem($li, $page_url );
            }
            $urlArray[] = $pagination_item;
        }


        $nextPage = $paging->get_next_page();
        if ($nextPage>0){
            $new_filter->setPage($nextPage);
            $page_url = $new_filter->get_url_from_this_object();
            if ($absolute){
                $page_url = url($page_url);
            }
            $pagination_item = new PaginationItem($nextPage, $page_url,PaginationItem::PAGE_TYPE_NEXT );
            $urlArray[] = $pagination_item;
        }
        return $urlArray;

    }

    /**
     * Return pagination Object associated with this object
     * @return Pagination
     */
    public function get_pagination_object()
    {

        $paging = new Pagination();
        $paging->setCurrentPage($this->getPage());
        $paging->setNumberOfLinks(20);
        $paging->setRecordsPerPage($this->getPerPage());
        $paging->setTotalRecords($this->get_count_of_all());

        return $paging;
    }

    public function get_page_count()
    {
        $paging = $this->get_pagination_object();
        return $paging->get_page_count();
    }

    public function has_next_page()
    {
        return $this->get_page_count() > $this->getPage();
    }
    /**
     * return pagination view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_pagination_view()
    {
        $links = $this->get_pagination_links();
        return view('widgets.general.pagination-links',['links'=>$links]);
    }

    /**
     * return html string for next and prev meta
     * @return string
     */
    public function get_prev_next_meta_html_view()
    {
        $links = $this->get_pagination_links(true);
        $str_links = '';
        foreach ($links as $link) {
            /** @var PaginationItem $link */
            if ($link->getPageType() == PaginationItem::PAGE_TYPE_PREV){
                $url = $link->getUrl();
                $str_links .= "<link rel=\"prev\" href=\"$url\" />";
            } elseif ($link->getPageType() == PaginationItem::PAGE_TYPE_NEXT){
                $url = $link->getUrl();
                $str_links .= "<link rel=\"next\" href=\"$url\" />";
            }
        }
        return $str_links;
    }

    /**
     * Get a table_name and Return true if this table already exists in joins
     * @param $table_name string
     * @return bool
     */
    public function has_join($table_name)
    {

        $joins = $this->get_query()->getQuery()->joins;
        if ($joins==null) {
            return false;
        }
        foreach ($joins as $join) {
            /** @var JoinClause $join */
            if ($join->table == $table_name){
                return true;
            }
        }
        return false;

    }

    function getPureSql()
    {
        $sql = $this->get_query()->toSql();
        $binds = $this->get_query()->getBindings();

        $result = "";

        $sql_chunks = explode('?', $sql);

        foreach ($sql_chunks as $key => $sql_chunk) {
            if (isset($binds[$key])) {
                $result .= $sql_chunk . '"' . $binds[$key] . '"';
            }
        }

        $result = $result . $sql_chunks[sizeof($sql_chunks) - 1];

        return $result;
    }

}

