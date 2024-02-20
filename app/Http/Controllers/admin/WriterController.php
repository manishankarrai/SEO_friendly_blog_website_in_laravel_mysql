<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash ;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\Auth ;

class WriterController extends Controller
{
  

    public function index()
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
        $data = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'writer')
            ->orderBy('email', 'asc')
            ->select('users.*')
            ->get();
            //dd($data);
		return view('admin.writer.index',compact('data'));
    }

   
    public function create()
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
        return view('admin.writer.create');
    }

  
    public function store(Request $request)
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                
                'password' => 'required|string|min:6',
                
            ]);

            $pass  =  Hash::make($request->password);
			$writer              =  new User;
			$writer->name        =  $request->name;
            $writer->email       =  $request->email;
           
            $writer->password    =  $pass;
           
			$writer->save();
          
                $writer->assignRole('writer');
           
            
            $writer->save();
            DB::commit();
            return redirect('admin/writer')->with('success','Writer added successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error','Writer not added. Something went wrong'.$e->getMessage());
        }
    }

   
    

   
    public function edit(Request $request)
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
        $id = Crypt::decrypt($request->id);
        
		$data = DB::table('users')->where('id',$id)->first();
      //  dd($data);
		return view('admin.writer.edit', compact('data'));
    }

    
    public function update(Request $request)
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
		$id = Crypt::decrypt($request->id);
        DB::beginTransaction();
        try{
            if($request->name){
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                ]);
            }
           
           
            if($request->password){
                $validatedData = $request->validate([
                    'password' => 'required|string|min:6',
                ]);
            }

            $pass  =  Hash::make($request->password);
			$writer              =  User::find($id);
			$writer->name        =  $request->name;
           
            
            $writer->password    =  $pass;

			$writer->update();
            DB::commit();
            return redirect('admin/writer')->with('success','Writer updated successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Writer not updated. Something went wrong'.$e->getMessage());
        }
    }

    
    public function destroy(Request $request)
    {
        if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
        $id = Crypt::decrypt($request->id);
        $writer = User::find($id);
        if ($writer && $writer->hasRole('writer')) {
            $writer->delete();
        } 
        return redirect('admin/writer')->with('success','Writer deleted successfully');
    }
}
