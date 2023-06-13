<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Coupon\CouponServiceInterface;
use App\Services\Order\OrderServiceInterface;
use App\Services\User\UserServiceInterface;
use App\Services\Usermeta\UsermetaServiceInterface;
use App\Utilities\Common;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $userService;
    private $orderService;
    private $usermetaService;
    private $couponService;
    public function __construct(UserServiceInterface $userService,OrderServiceInterface $orderService,UsermetaServiceInterface $usermetaService,CouponServiceInterface $couponService){
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->usermetaService = $usermetaService;
        $this->couponService = $couponService;
    }
    public function login(){
        return view('front.account.login');
    }
    public function checkLogin(Request $request){
        $request->validate([
            'password' => 'required',
            'email' => 'required|email',
        ], [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => Constant::user_level_client,
        ];

        $remember = $request->remember;
        if(Auth::attempt($credentials,$remember)){
//            return redirect('');
            return redirect()->intended('');
        }else{
            return back()->with('notification','ERROR: Email or password is wrong');
        }
    }
    public function logout(){
        Auth::logout();

        return back();
    }
    public function register(){
        return view('front.account.register');
    }
    public function postRegister(Request $request){
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'password_comfirmation' => 'required|min:6'
        ], [
            'name.required' => 'Name is required',
            'password.required' => 'Password is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'password_comfirmation.required' => 'Password Confirm is required',
            'password_comfirmation.min' => 'Password must be more than 5 characters',
            'password.min' => 'Password must be more than 5 characters',
        ]);
        if($request->password != $request->password_comfirmation){
            return back()->with('notification','ERROR: Confirm password does not match');
        }


        $data = [
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'level' =>2,
        ];
        $this->userService->create($data);
        return redirect('account/login')->with('notification','Register Success! Please Login !');
    }

    public function myOrderIndex(){
        $orders = $this->orderService->getOrderByUserId(Auth::id());

        return view('front.account.my-order.index',compact('orders'));
    }
    public function myOrderShow($id){
        $order=$this->orderService->find($id);
        $uid = $order->user_id ;
        $time = $order->created_at;
        $usermeta = $this->usermetaService->getUsermetaByIdAndTime($uid,$time);
        return view('front.account.my-order.show',compact('order','usermeta'));
    }
    public function indexProfile(){
        $user = $this->userService->find(Auth::id());
        return view('front.account.profile.index',compact('user'));
    }
    public function postEditProfile(Request $request){

        $data['name']=$request->name;
        if($request->hasFile('image')){
            //them file moi
            $data['avatar']= Common::uploadFile($request->file('image'),'front/img/user');
            //xoa file cu
            $file_name_old=$request->get('image_old');
            if($file_name_old != ''){
                unlink('front/img/user/'.$file_name_old);
            }
        }
        $this->userService->update($data,Auth::id());
        return redirect('/account/profile');

    }
    public function indexPass(){
        $user = $this->userService->find(Auth::id());
        return view('front.account.changepass.index',compact('user'));
    }
    public function postChangePassword(Request $request){
        $request->validate([
            'new_password' => 'required',
            'password' => 'required|min:6',
            'cf_password' => 'required|min:6',

        ], [
            'password.required' => 'Password is required',
            'cf_password.required' => 'Password Confirm is required',
            'cf_password.min' => 'Password must be more than 5 characters',
            'password.min' => 'Password must be more than 5 characters',
        ]);
        $user=$this->userService->find(Auth::id());
        if (!Hash::check($request->get('password'), $user->password)){
            return back()->with('notification','ERROR: wrong old password ');
        }
        if($request->get('new_password')!= $request->get('cf_password')){
            return back()->with('notification','ERROR: Confirm password does not match');
        }

        $data['password'] = bcrypt($request->get('new_password'));
        $this->userService->update($data,Auth::id());
        return back()->with('notification','ERROR: Change Password Success!');
    }
    public function cancelOrder(Request $request,$id){
        $order = $this->orderService->find($id);
        $idOrder = $order->id;
        $this->orderService->update(['status'=>Constant::order_status_Cancel],$idOrder);
        return back()->with('notification','Cancel Successfull!');;
    }
    public function couponsIndex(){
        $coupons = $this->couponService->all();
        return view('front.account.Coupon.index',compact('coupons'));
    }
}
