<?php
/**
 * Created by PhpStorm.
 * User: 7
 * Date: 5/25/2016
 * Time: 4:11 PM
 */

namespace App\Classes\QueryBuilders;


use App\Models\Factor;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class Pagination
 * @package App\Classes
 */
class FactorQueryBuilder extends BaseFilter
{

    private $status = null;
    private $statuses = null;
    private $client_id = null;
    private $user_id = null;
    private $load_factor_contents = false;
    private $follow_up_code = null;

    /**
     * @return null
     */
    public function getFollowUpCode()
    {
        return $this->follow_up_code;
    }

    /**
     * @param null $follow_up_code
     */
    public function setFollowUpCode($follow_up_code): void
    {
        $this->follow_up_code = $follow_up_code;
    }


    /**
     * @return null
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param null $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param null $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return bool
     */
    public function isLoadFactorContents(): bool
    {
        return $this->load_factor_contents;
    }

    /**
     * @param bool $load_factor_contents
     */
    public function setLoadFactorContents(bool $load_factor_contents): void
    {
        $this->load_factor_contents = $load_factor_contents;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return null
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @param null $statuses
     */
    public function setStatuses($statuses): void
    {
        $this->statuses = $statuses;
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
        $query = Factor::query()
            ->orderBy('id','desc');


        if($this->getStatus() != null){
            $query->where('status' , $this->getStatus());
        }

        if($this->getStatus() != null){
            $query->whereIn('status' , $this->getStatuses());
        }

        if($this->isLoadFactorContents()){
            $query->with('factor_contents');
        }

        if($this->getClientId() != null){
            $query->where('client_id' , $this->getClientId());
        }

        if($this->getUserId() != null){
            $query->where('user_id' , $this->getUserId());
        }

        if($this->getFollowUpCode() != null){
            $query->where('follow_up_code' , $this->getFollowUpCode());
        }

        $query->where('is_deleted' , 0);

        return $query->selectRaw('factors.*');
    }

    public function get_result($cache_time = 0)
    {
        // return result from cache if available
        // load from database and store to cache
        $result = parent::get_result();
        return $result;
    }


}
