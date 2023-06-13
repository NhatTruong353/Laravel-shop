<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\Coupon\CouponServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    private $couponService;
    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $coupons = $this->couponService->getCouponsOnIndex($request);
        return view('admin.coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $coupon = Coupon::where('code', $request->code)->exists();
        if ($coupon) {
            return back()->with('notification','ERROR: Something went wrong');
        } else {
            $this->couponService->create($data);
            return redirect('admin/coupon');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon= $this->couponService->find($id);
        $types = DB::table('coupons')->select('id','type')->get();

        return view('admin.coupon.edit',compact('coupon','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();
        $this->couponService->update($data,$id);

        return redirect('admin/coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->couponService->delete($id);
        return redirect('admin/coupon');
    }
}
