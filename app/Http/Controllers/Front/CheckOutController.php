<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Usermeta;
use App\Services\Order\OrderServiceInterface;
use App\Services\OrderDetail\OrderDetailServiceInterface;
use App\Services\User\UserServiceInterface;
use App\Services\Usermeta\UsermetaServiceInterface;
use App\Utilities\Constant;
use App\Utilities\VNPay;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;
    private $userService;
    private $usermetaService;
    public function __construct(OrderServiceInterface $orderService,
                                OrderDetailServiceInterface $orderDetailService,
                                UserServiceInterface $userService,UsermetaServiceInterface $usermetaService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->userService=$userService;
        $this->usermetaService=$usermetaService;
    }

    public function index(Request $request)
    {
        $carts = Cart::instance('cart')->content();
        $total = Cart::instance('cart')->total(0,'','');
        $subtotal = Cart::instance('cart')->subtotal(0,'','');
        $discountCodes = Coupon::all();

        $usermeta = $this->usermetaService->getUsermetaById(Auth::id());

        return view('front.checkout.index',compact('carts','total','subtotal','usermeta','discountCodes' ));
    }
    public function addOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'street_address' => 'required',
            'country' => 'required',
            'postcode_zip' => 'required',
            'town_city' => 'required',

            'phone' => 'required',
        ], [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'company_name.required' => 'Company nameis required',
            'street_address.required' => 'Street address name is required',
            'country.required' => 'Country is required',
            'town_city.required' => 'Town / City Confirm is required',
            'phone.required' => 'Phone Confirm is required',
            'postcode_zip.required' => 'Postcode/Zip Confirm is required',
        ]);
        //1.Them Don Hang
        $data= [
            'user_id' => $request->user_id,
            'name_title' => $request->name_order,
            'payment_type' => $request->payment_type,
            'discount' => $request->discount ?? 0,
            'total_order' => $request->total_order ?? Cart::instance('cart')->total(0,'',''),
        ];
        $data1 = [
            'user_id' => $request->user_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_name' => $request->company_name,
            'country' => $request->country,
            'street_address' => $request->street_address,
            'postcode_zip' => $request->postcode_zip,
            'town_city' => $request->town_city,
            'phone' => $request->phone,
        ];

        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = $this->orderService->create($data);
        $usermeta=$this->usermetaService->create($data1);
//        $usermeta=$this->usermetaService->update($data1,$request->user_id);
//        $check = Usermeta::where('user_id',$request->user_id)->count();
//        if($check <= 0){
//            $usermeta=$this->usermetaService->create($data1);
//        }else {
//            $usermeta=$this->usermetaService->update($data1,$request->user_id);
//        }



        //2.Them chi tiet don hang
        $carts = Cart::instance('cart')->content();
        foreach ($carts as $cart){
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'qty' => $cart->qty,
                'amount' => $cart->price,
                'total' => $cart->qty * $cart->price,
            ];
            DB::table('products')
                ->where('id', $cart->id)         // lọc sản phẩm có ID cần giảm số lượng
                ->update(['qty' => DB::raw("qty - $cart->qty")]);
            $this->orderDetailService->create($data);

        }

        if($request->payment_type == 'pay_later'){
            if($request->total_order == 0){
                $total = Cart::instance('cart')->total();
            }else{
                $total=$request->total_order;
            }
            $subtotal=Cart::instance('cart')->subtotal();
            $order=$this->orderService->find($order->id);
            $time = $order->created_at;
            $usermeta = $this->usermetaService->getUsermetaByIdAndTime($order->user_id,$time);
            $this->sendEmail($order,$usermeta,$subtotal);
            Cart::instance('cart')->destroy();

            //3.Xoa Gio hang

            //4.tra ve ket qua thong bao
            return redirect('checkout/result')
                ->with('notification','Success! You Will pay on delivery.Please Check Your Email!.');
        }
        if($request->payment_type == 'online_payment'){
            //01.Lay URL
            $data_url=VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id,//Id don hang
                'vnp_OrderInfo'=>'Mô tả đơn hàng ở đây...',
                'vnp_Amount' => ($request->total_order ?? Cart::total(0,'',''))  * 24510, //Tong gia tri don hang, duoc chuyen sang tien Viet Nam
            ]);
            //02.Chuyen huong toi url lay duoc
            return redirect()->to($data_url);
        }
    }
    public  function vnPayCheck(Request $request){
        //01.Lay data tu URL

        $vnp_ResponseCode = $request->get('vnp_ResponseCode');//Ma phan hoi thanh cong
        $vnp_TxnRef=$request->get('vnp_TxnRef');//order id
        $vnp_Amount=$request->get('vnp_Amount');//So tien thanh toan


        //02.Kiem tra data,xem ket qua giao dich tra ve tu VNpay hop le hay khong
        if($vnp_ResponseCode != null){
            //Neu thanh cong
            if($vnp_ResponseCode == 00){
                //Cap nhat trang thai
                $this->orderService->update(['status'=>Constant::order_status_Paid],$vnp_TxnRef);
                $order=$this->orderService->find($vnp_TxnRef);
                $time = $order->created_at;
                $usermeta = $this->usermetaService->getUsermetaByIdAndTime($order->user_id,$time);
                $subtotal=Cart::instance('cart')->subtotal();
                $this->sendEmail($order,$usermeta,$subtotal);


                Cart::instance('cart')->destroy();

                return redirect('checkout/result')
                    ->with('notification','Success! Has paid Online. Please Check Your Email!.');
            }else{
                $carts = Cart::instance('cart')->content();
                foreach ($carts as $cart) {
                    // Lấy số lượng sản phẩm hiện tại và tăng lên
                    $qty = $cart->qty;
                    DB::table('products')
                        ->where('id', $cart->id)
                        ->update(['qty' => DB::raw("qty + $qty")]);
                }
                $this->orderService->delete($vnp_TxnRef);
                return redirect('checkout/result')
                    ->with('notification',' ERROR: Payment failed or canceled.');
            }
        }

    }
    public function result()
    {
        $notification = session('notification');
        return view('front.checkout.result',compact('notification'));
    }
    private function sendEmail($order,$usermeta,$subtotal){
        $email_to=$order->users->email;
        Mail::send('front.checkout.email',compact('order','usermeta','subtotal'),
            function ($message) use ($email_to) {
                $message->from('pingotau353@gmail.com','T-Shop Ecom');
                $message->to($email_to,$email_to);
                $message->subject('Order Notification');
        });
    }
    public function apply_coupon_code(Request $request){

        $result=DB::table('coupons')->where(['code'=>$request->coupon_code])->get();

        if (count($result) > 0){
            $Value = $result[0]->value;
            $Type = $result[0]->type;
            $status = "Success";
            $msg="Please enter valid coupon code";
            $min_order_amt=$result[0]->cart_value;
            $totalPrice = Cart::instance('cart')->total(0,'','');
            if($min_order_amt < $totalPrice){
                $status = "Success";
                $msg="Coupon code applied";
            }else{
                $status = "Error";
                $msg="Cannot apply coupon code";
                $newPrice = $Type = 0;
            }
        }else{
            $status = "Error";
            $msg="Coupon is not valid";
            $totalPrice = Cart::instance('cart')->total(0,'','');
            $Value = $newPrice = $Type = 0;
        }

        if($status=='Success'){
            $newPrice = ceil($totalPrice * ($Value/100));
            if($Type==0){
                $totalPrice = ceil($totalPrice - $Value);

            }if($Type==1){
                $totalPrice = ceil($totalPrice - $newPrice);
            }
        }
        return response()->json(['status'=>$status,'msg'=>$msg,'totalPrice'=>$totalPrice,'Value'=>$Value,'newPrice'=>$newPrice,'Type'=>$Type]);
    }
    public function remove_coupon_code(Request $request){

        $result=DB::table('coupons')->where(['code'=>$request->coupon_code])->get();

        $totalPrice = Cart::instance('cart')->total();


        return response()->json(['status'=>'Success','msg'=>'Coupon code removed','totalPrice'=>$totalPrice]);
    }


}
