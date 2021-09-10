<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{


    function __construct(){
        
        $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request){
        $data = User::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * PAGINATION_COUNT);
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(){
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'status' => 'required|in:0,1',
            'roles_name' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'same' => 'كلمه المرور غير متطابقه حاول مره اخره',
            'in' => 'اختر حاله المستخدم بشكل صحيح',
            'unique' => 'هذا الايميل موجود منن قبل من فضلك ادخل ايميل اخر',
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.index')
            ->with(['success' => "تم اضافه المستخدم بنجاح"]);
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
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
        
        
         $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|same:confirm-password',
            'status' => 'required|in:0,1',
            'roles_name' => 'required'
        ],[
            'required' => 'هذا الحقل مطلوب',
            'same' => 'كلمه المرور غير متطابقه حاول مره اخره',
            'in' => 'اختر حاله المستخدم بشكل صحيح',
            'unique' => 'هذا الايميل موجود منن قبل من فضلك ادخل ايميل اخر',
        ]);
        

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input, ['password']);
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.index')
            ->with('success','تم تحديث معلومات المستخدم بنجاح');
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','تم حذف المستخدم بنجاح');
    }
}