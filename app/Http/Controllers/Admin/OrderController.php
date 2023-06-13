<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Order\OrderServiceInterface;
use App\Services\Usermeta\UsermetaServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;
    private $usermetaService;
    public function __construct(OrderServiceInterface $orderService,UsermetaServiceInterface $usermetaService)
    {
        $this->orderService=$orderService;
        $this->usermetaService=$usermetaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orders = $this->orderService->getOrdersOnInDex($request);
//        $orders = $this->orderService->all();

        return view('admin.order.index',compact('orders'));
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
        $order=$this->orderService->find($id);
        $uid = $order->user_id ;
        $time = $order->created_at;
        $usermeta = $this->usermetaService->getUsermetaByIdAndTime($uid,$time);
        return view('admin.order.show',compact('order','usermeta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderService->find($id);

        return view('admin.order.edit',compact('order'));
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
        $data=$request->all();
        $this->orderService->update($data,$id);
        return redirect('admin/order');
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
}
