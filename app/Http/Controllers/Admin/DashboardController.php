<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Brand\BrandServiceInterface;
use App\Services\Order\OrderServiceInterface;
use App\Services\Product\ProductServiceInterface;
use App\Services\ProductCategory\ProductCategoryServiceInterface;
use App\Services\ProductComment\ProductCommentServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $productService;
    private $userService;
    private $orderService;
    public function __construct(ProductServiceInterface $productService,
                                UserServiceInterface  $userService,
                                OrderServiceInterface $orderService){
        $this->productService = $productService;
        $this->userService = $userService;
        $this->orderService = $orderService;

    }
    public function index()
    {
        $products =$this->productService->all();
        $orders =$this->orderService->all();
        $users = $this->userService->all();
        $month = now()->month;
        $year = now()->year;

        $bestSellingProducts = DB::table('orders_details')
            ->whereMonth('orders_details.created_at', $month)
            ->whereYear('orders_details.created_at', $year)
            ->join('products', 'orders_details.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'orders_details.order_id')
            ->whereNotIn('orders.status', ['canceled']) // Chỉ lấy những đơn hàng có trạng thái khác "canceled"
            ->join('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.id', '=', DB::raw("(select min(`id`) from `product_images` where `product_id` = `products`.`id`)")); // Lấy hình ảnh đầu tiên của mỗi sản phẩm
            })

            ->select('products.id', 'products.name', 'products.discount', DB::raw('SUM(orders_details.qty) as total_sold'), 'product_images.path')
            ->groupBy('products.id', 'products.name', 'products.discount', 'product_images.path')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        $countCancelledOrders = DB::table('orders')->where('status', 0)->count();
        $cancelledProducts = DB::table('orders_details')
            ->join('products', 'orders_details.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'orders_details.order_id')
            ->where('orders.status', '=', 0)
            ->join('product_images', function ($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                    ->where('product_images.id', '=', DB::raw("(select min(`id`) from `product_images` where `product_id` = `products`.`id`)")); // Lấy hình ảnh đầu tiên của mỗi sản phẩm
            })
            ->select('products.id', 'products.name', DB::raw('SUM(orders_details.qty) as total_cancelled'), 'product_images.path')
            ->groupBy('products.id', 'products.name', 'product_images.path')
            ->orderByDesc('total_cancelled')
            ->limit(5)
            ->get();
        return view('admin.dashboard.index',compact('products','orders','users','bestSellingProducts','countCancelledOrders','cancelledProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = Carbon::parse($data['from_date'])->startOfDay();
        $to_date = Carbon::parse($data['to_date'])->endOfDay();
        $get = DB::table('orders')
            ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
            ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
            ->whereBetween('orders.created_at', [$from_date, $to_date])
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->get();
        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->created_at,
                'order' => $val->order_count,
                'sale' => $val->total_sale,
                'quantity' => $val->total_quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function dashboard_filter(Request $request){


        // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        // $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('d-m-Y H:i:s');
        // $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->format('d-m-Y H:i:s');
        // $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(15)->format('d-m-Y H:i:s');
        // $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->format('d-m-Y H:i:s');
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->toDateString();

        if($data['dashboard_value']=='7ngay'){
            $get = DB::table('orders')
                ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
                ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
                ->whereBetween('orders.created_at', [$sub7days, $now])
                ->groupBy('created_at')
                ->orderBy('created_at', 'ASC')
                ->get();
        }elseif($data['dashboard_value']=='thangtruoc'){
            $get = DB::table('orders')
                ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
                ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
                ->whereBetween('orders.created_at', [$dau_thangtruoc, $cuoi_thangtruoc])
                ->groupBy('created_at')
                ->orderBy('created_at', 'ASC')
                ->get();
        }elseif($data['dashboard_value']=='thangnay'){
            $get = DB::table('orders')
                ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
                ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
                ->whereBetween('orders.created_at', [$dauthangnay,$now])
                ->groupBy('created_at')
                ->orderBy('created_at', 'ASC')
                ->get();
        }else{
            $get = DB::table('orders')
                ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
                ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
                ->whereBetween('orders.created_at', [$sub365days,$now])
                ->groupBy('created_at')
                ->orderBy('created_at', 'ASC')
                ->get();
        }
        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->created_at,
                'order' => $val->order_count,
                'sale' => $val->total_sale,
                'quantity' => $val->total_quantity
            );

        }

        echo $data = json_encode($chart_data);
    }
    public function day_order(){

        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->toDateString();
        $get = DB::table('orders')
            ->join('orders_details', 'orders.id', '=', 'orders_details.order_id')
            ->select(DB::raw('date(orders.created_at) as created_at'), DB::raw('count(distinct orders.id) as order_count'), DB::raw('sum(distinct orders.total_order) as total_sale'), DB::raw('sum(orders_details.qty) as total_quantity'))
            ->whereBetween('orders.created_at', [$sub60days, $now])
            ->groupBy('created_at')
            ->orderBy('created_at', 'ASC')
            ->get();
        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->created_at,
                'order' => $val->order_count,
                'sale' => $val->total_sale,
                'quantity' => $val->total_quantity
            );
        }
        echo $data = json_encode($chart_data);
    }

}
