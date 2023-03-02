<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\HomeSetting;
use App\Models\Testimonials;
use App\Models\Doctors;
use App\Models\Packages;
use App\Models\Publications;
use App\Models\Pre_Existing_Conditon;
use Log;
use DB;
use App\Classes\ErrorsClass;
use App\Models\Menu;

class MenuController extends Controller
{


	public function GetAllMenu(Request $request)
    {
    	try{
    		$menu = Menu::where('menu.status', '1')->where('menu.is_deleted', '0')->orderBy('menu.id', 'ASC')->paginate(10);

    		
    		if($menu){
    			return response()->json(['status'=>true,'message'=>'Menu Listings','error'=>'','data'=>$menu], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of menu','error'=>'','data'=>''], 200);
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
	}
	
	public function deleteMenu(Request $request)
    {
    	try{
    		$menu_id = $request->menu_id;
    		$delete_menu = Menu::where('id', $menu_id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_menu){
    			return response()->json(['status'=>true,'message'=>'Menu deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'Menu not deleted successfully!','error'=>'','data'=>''], 200);
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
	}
	
	public function CreateMenu(Request $request)
    {
    	try{
    	
    		$menutitle = ucwords(trim($request->menu_title));
    	
    	    
    	
    		$checkstatic_menu = Menu::select('title')->where('menu.title',$menutitle)->where('menu.status', '1')->where('menu.is_deleted', '0')->first();
    		
    		
    // 		return $checkstatic_menu;
    		
    		if($checkstatic_menu || $menutitle == 'Book Appointment'){
    		    
    		    return response()->json(['status'=>'title_error','message'=>'Please choose different menu title!','error'=>'','data'=>''], 200);
    		    
    		    
    		}else {
    		    
    		    $menu = new Menu();
    		    $menu->title = $menutitle;
    		    $menu->url = $request->menu_url;
    		    $menu->current_status = $request->menu_current_status;
    		    
    		
        		$save_data = $menu->save();
        		if($save_data){
        			return response()->json(['status'=>'ok','message'=>'Menu created successfully!','error'=>'','data'=>''], 200);
        		} else {
        			return response()->json(['status'=>'notok','message'=>'Menu not created successfully!','error'=>'','data'=>''], 200);
        		}
    		}
    		
    		
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
    }
    
     public function UpdateMenu(Request $request, $id)
    {
    	try{
    	    
    	 
            	$menutitle = ucwords(trim( $request->input('edit_menu_title')));
            	
            
        		$checkstatic_menu = Menu::select('title')->where('menu.id','!=',$id)->where('menu.title',$menutitle)->where('menu.status', '1')->where('menu.is_deleted', '0')->first();
        		
        
        		if($checkstatic_menu || $menutitle == 'Book Appointment'){
        		    
        		    return response()->json(['status'=>'title_error','message'=>'Please choose different menu title!','error'=>'','data'=>''], 200);
        		    
        		    
        		}else {
    	    
    	            $menu = Menu::find($id);
    	    
    	        	$menu['title'] = $menutitle;
    	        	$menu['url'] = $request->input('edit_menu_url');
    	        	$menu['current_status'] = $request->input('edit_current_status');
    			
                	
        		    $update_data = $menu->update();
            		if($update_data){
            			return response()->json(['status'=>'ok','message'=>'Menu updated successfully!','error'=>'','data'=>''], 200);
            		} else {
            			return response()->json(['status'=>'notok','message'=>'Menu not updated successfully!','error'=>'','data'=>''], 200);
            		}
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
    }
    
    public function GetSingleMenu(Request $request, $title)
    {
    	try{
    	    
    	        
    	    
    		$single_menu = Menu::where('title', $title)->first();
    
    		
    		if($single_menu){
    			return response()->json(['status'=>true,'message'=>'Menu Listings','error'=>'','data'=>$single_menu], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Menu','error'=>'','data'=>''], 200);
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
	}
	
	public function AdminSearchMenu(Request $request)
    {
    	try{
    		if(trim($request->keywords)){
	    		$query = DB::table('menu');
	    		$query->select('menu.*');
	    		if(trim($request->keywords)) {
	               $query->where('menu.title', 'like', '%'.trim($request->keywords).'%');
	            }
	            $packges_data = $query->paginate(10);
	        } else {
	        	$packges_data = Menu::where('menu.status', '1')->where('menu.is_deleted', '0')->orderBy('menu.id', 'DESC')->paginate(10);
	        }
    		if($packges_data){
    			return response()->json(['status'=>true,'message'=>'Search Menu Listings','error'=>'','data'=>$packges_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of Menu page','error'=>'','data'=>''], 200);
    		}
    	} catch(\Illuminate\Database\QueryException $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Sql query error','data'=>''], 401); 
	    } catch(\Exception $e) {
	      	$errorClass = new ErrorsClass();
	      	$errors = $errorClass->saveErrors($e);
	      	return response()->json(['status'=>false,'message'=>'','error'=>'Undefined variable error','data'=>''], 401);
	    }
	}
	
	
	
	
}