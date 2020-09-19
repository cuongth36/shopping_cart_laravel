<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    function __construct()
    {
       
    }

    function login(){
        return view('customer.login');
    }

    function register(){
        return view('customer.register');
    }

    function signin(){
        return view('customer.form-login');
    }

    function loginCustomer(Request $request){
        if(session()->exists('login')){
            $id = session('id');
            return redirect("customer/profile/{$id}");
         }else{
            return view('customer.form-login');
            // return redirect('sign-in');
         }
    }

    function profile(Request $request){
        
            $id = session('id');
            $count_id = 0;
            $db_select = DB::select("SELECT count('id') as id FROM customers where id = $id ");
            foreach ($db_select as $item){
               $count_id = $item->id;
            }
           
           
            if($count_id > 0){
                $customer = Customer::find($id);
                $customer_id = session('id');
                $order_history = DB::select("SELECT *, SUM(order_details.qty) as total_qty, orders.created_at as date_order,colors.title as color_name, products.title as product_name , 
                sizes.name as size_name,products.id as prd_id,  order_details.product_id FROM order_details  INNER JOIN  orders on order_details.order_id = orders.id  
                INNER JOIN products on order_details.product_id = products.id 
                INNER JOIN sizes on order_details.size = sizes.id
                INNER JOIN colors on order_details.color = colors.id
                WHERE orders.customer_id ={$customer_id}  GROUP by order_details.product_id");
                return view('customer.profile', compact('customer', 'order_history'));
    
            }else{
                return view('errors.404');
            }
    }

    function checkSignin(Request $request){
        $user = Customer::where('email', '=',  $request->input('email'))->first();
        if($user){
            $customer_info = Hash::check($request->input('password'), $user->password);
            if($customer_info){
                session([
                    'login' => true,
                    'email' => $request->input('email'),
                    'id'    => $user->id,
                    'name'  => $user->name,
                ]);
                return redirect("customer/profile/{$user->id}");
            }
            return redirect('sign-in-customer')->with('error','Email hoặc mật khẩu không tồn tại trong hệ thống');
        }else{
            return redirect('sign-in-customer')->with('error','Email hoặc mật khẩu không tồn tại trong hệ thống');
        }
    }

    public function checkLogin( Request $request){
        $user = Customer::where('email', '=',  $request->input('email'))->first();
        if($user){
            $customer_info = Hash::check($request->input('password'), $user->password);
            if($customer_info){
                session([
                    'login' => true,
                    'email' => $request->input('email'),
                    'id'    => $user->id,
                ]);
                return redirect('checkout');
            }
            return redirect('login-customer')->with('error','Email hoặc mật khẩu không tồn tại trong hệ thống');
        }else{
            return redirect('login-customer')->with('error','Email hoặc mật khẩu không tồn tại trong hệ thống');
        }
    }

   
    function create(Request $request){
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => '|unique:customers|required|email',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address' => 'max:255',
            'phone' => 'required |regex:/^[0]{1}[0-9]{9}$/',
            'remember' => 'required'
        ],
        [
            'required' => ':attribute không được bỏ trống',
            'fullname. max' => 'Độ dài tối đa của tên là 255 ký tự ',
            'address. max' => 'Độ dài tối đa của địa chỉ là 255 ký tự ',
            'string' => 'Chuỗi',
            'confirmed' => 'Mật khẩu không khớp',
            'min' => 'Độ dài tối thiếu của mật khẩu là 6 ký tự',
            'regex' => 'Số điện thoại không đúng định dạng'
        ],
        [
            'fullname' => 'Họ và tên',
            'password' => 'Mật khẩu',
            'email' => 'Email',
            'address'  => 'Địa chỉ',
            'phone'    => 'Số điện thoại',
            'remember' => 'Điều khoản'
        ]);

        Customer::create([
            'name'     =>   trim($request->input('fullname')),
            'email'    => trim($request->input('email')),
            'password' => trim(Hash::make($request->input('password'))),
            'address'  => trim($request->input('address')),
            'phone'    => trim($request->input('phone'))
        ]);
        return redirect('register-customer')->with('status', 'Đăng ký tài thành công');
    }

    function update(Request $request){
        $arg_rules = [
            'fullname' => 'required|string|max:255',
            'address' => 'max:255',
            'phone' => 'required |regex:/^[0]{1}[0-9]{9}$/',
        ];
        $arg_message = [
            'required' => ':attribute không được bỏ trống',
            'max' => 'Độ dài tối đa',
            'string' => 'Chuỗi',
            'regex' => 'Số điện thoại không đúng định dạng'
        ];
        $id = session('id');
        $password = $request->input('password');
        if(!empty($password)){
            $arg_rules['password'] = 'required|string|min:6|confirmed';
            $arg_message['pasword.required'] = 'Mật khẩu không được bỏ trống';
            $arg_message['pasword.min'] = 'Độ dài tối thiểu của mật khẩu là 6 ký tự';
            $arg_message['password.confirmed'] = 'Mật khẩu không khớp';
        }else{
           
            $password = Customer::find($id)->password;
        }
        $password_confirm = $request->input('password_confirmation');

        if( $password_confirm !== $password){

            return redirect("customer/profile/{$id}")->with('error', 'Bạn cần nhập mật khẩu trước khi cập nhật');
        }
    
        Validator::make($request->all(),$arg_rules, $arg_message)->validate();
        Customer::find($id)->where('id', $id)->update([
            'name' => trim($request->input('fullname')),
            'address'  => trim($request->input('address')),
            'phone'    => trim($request->input('phone')),
            'password' => trim(Hash::make($password))      
        ]);

        return redirect("customer/profile/{$id}")->with('status', 'Bạn đã cập nhập thông tin thành công');
        
    }

    function logout(Request $request){
        $request->session()->flush();
        return redirect('sign-in-customer');
    }

    function updateOrderHistory(Request $request){
       
    }
}
