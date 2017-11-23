<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    
    private $home_dir = '';
    private $pagination_limit = 10;
    private $title = 'Users';
    private $route;

    function __construct(){
        $this->route = route('users');
        $this->home_dir = route('home');
        $this->mainParams = $this->getThisMainParamsArray();
    }

    public function index(Request $request){
        $data = $request->all();
        if(isset($data['search'])){
            $like = $data['search'];
        } else{
            $like = '';
        }
        $page = (isset($data['page']) && isset($data['search'])) ? $data['page'] : 1;
        $users = User::where('name', 'like', '%'.$like.'%')->paginate($this->pagination_limit);
    	return view('admin.user.userList', array('users' => $users, 'page' => $page, 'search' => $like));
    }

    public function add(){
        return view('admin.user.userAdd');
    }

    public function addAction(Request $request){
        try {

            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            if($user['id']) {
              return \Redirect($this->home_dir);
            } else {
              throw new \Error('Impossivel cadastrar user');
            }
        } catch(Exception $err) {
            print_r($err);
        }
    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.user.userAdd', array('user' => $user));
    }

    public function update(Request $request, $id){
        try {

            $data = $request->all();
            
            $user = user::find($id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            if(!empty($data['password'])){
            	$user->password = bcrypt($data['password']);
            }
            $user->save();
            return \Redirect($this->home_dir);
        } catch(Exception $err){
            print_r($err);
        }
    }

    public function remove($id){
        try {
            $user = user::find($id);
            if(isset($user)){
                $user->delete();
            }
            return \Redirect($this->home_dir);

        } catch(Exception $err){
            print_r($err);
        }
    }

    private function remove_image($oldName){
        if(file_exists($this->img_path.'/'.$oldName)){
            unlink($this->img_path.'/'.$oldName);
        }
    }

    private function getThisMainParamsArray(){
        $mainParamsArray = array(
            'title' => $this->title, 
            'route' => $this->route
        );
        return $mainParamsArray;
    }

}
