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
use App\Models\NewsEvents;
use Log;
use App\Classes\ErrorsClass;

class NewsEventsController extends Controller
{
	public function SaveNewsEvents(Request $request)
    {
    	try{
    		$NewsEvents = new NewsEvents();
    		$NewsEvents['news_events_title'] = $request->news_events_title;
    		$NewsEvents['news_events_desc'] = $request->news_events_desc;
    		if($request->file('news_events_pic')){
            	$file= $request->file('news_events_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('NewsEventsImg'), $filename);
            	$NewsEvents['news_events_pic']= $filename;
        	}
        	$save_data = $NewsEvents->save();
    		if($save_data){
    			return response()->json(['status'=>true,'message'=>'NewsEvents saved successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'NewsEvents not saved successfully','error'=>'','data'=>''], 200);
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
	public function GetAllNewsEvents(Request $request)
    {
    	try{
    		$news_events_data = NewsEvents::where('status', '1')->where('is_deleted', '0')->paginate(2);
    		if($news_events_data){
    			return response()->json(['status'=>true,'message'=>'NewsEvents Listings','error'=>'','data'=>$news_events_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of NewsEvents','error'=>'','data'=>''], 200);
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
	public function GetSingleNewsEvents(Request $request, $id)
    {
    	try{
    		$single_news_events_data = NewsEvents::where('id', $id)->where('status', '1')->where('is_deleted', '0')->first();
    		if($single_news_events_data){
    			return response()->json(['status'=>true,'message'=>'NewsEvents Listings','error'=>'','data'=>$single_news_events_data], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'No result Found of NewsEvents','error'=>'','data'=>''], 200);
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
	public function UpdateNewsEvents(Request $request, $id)
    {
    	try{
    		$NewsEvents = NewsEvents::find($id);
	        $NewsEvents['news_events_title'] = $request->input('edit_news_events_title');
	        $NewsEvents['news_events_desc'] = $request->input('edit_news_events_desc');
	        if($request->file('edit_news_events_pic')){
            	$file= $request->file('edit_news_events_pic');
            	$filename= date('YmdHi').$file->getClientOriginalName();
            	$file-> move(public_path('NewsEventsImg'), $filename);
            	$NewsEvents['news_events_pic']= $filename;
        	}
	        $update_data = $NewsEvents->update();
    		if($update_data){
    			return response()->json(['status'=>true,'message'=>'NewsEvents updated successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'NewsEvents not updated successfully','error'=>'','data'=>''], 200);
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
	public function deleteNewsEvents(Request $request, $id)
    {
    	try{
    		$delete_newsevents_data = NewsEvents::where('id', $id)->update(['status' => '0', 'is_deleted' => '1']);
    		if($delete_newsevents_data){
    			return response()->json(['status'=>true,'message'=>'NewsEvents deleted successfully!','error'=>'','data'=>''], 200);
    		} else {
    			return response()->json(['status'=>false,'message'=>'NewsEvents not deleted successfully!','error'=>'','data'=>''], 200);
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