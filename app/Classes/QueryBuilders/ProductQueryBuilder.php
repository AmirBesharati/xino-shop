<?php
/**
 * Created by PhpStorm.
 * User: 7
 * Date: 5/25/2016
 * Time: 4:11 PM
 */

namespace App\Classes\QueryBuilders;


use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class Pagination
 * @package App\Classes
 */
class ProductQueryBuilder extends BaseFilter
{

    private $status = null;


    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }



    /**
     * make object from current request object
     * @param Request $request
     */
    public function make_object_from_request(Request $request)
    {
        parent::make_object_from_request($request);

    }

    /**
     * get url from current object properties
     * @return string
     */
    public function get_url_from_this_object()
    {
        $more_url = '';
        $url_builder = $this->get_default_url_builder();


        $final_url = $this->getStartUrlWith();
        if ($more_url != null) {
            /*if ($more_url == 'all-categories' and $url_builder->count() <= 0) {
                $more_url = 'categories';
            }*/
            if ($final_url == null) {
                $final_url = '/' . $more_url;
            } else {
                $final_url = $final_url . $more_url;
            }
        }
        return $url_builder->get_url_with_query_string($final_url);

    }


    /**
     * we makes queries here
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function get_query()
    {
        $query = Product::query()
            ->orderBy('id','desc');


        if($this->getStatus() != null){
            $query->where('status' , $this->getStatus());
        }

        $query->where('is_deleted' , 0);

        return $query->selectRaw('products.*');
    }

    public function get_result($cache_time = 0)
    {
        // return result from cache if available
        // load from database and store to cache
        $result = parent::get_result();
        return $result;
    }


}
