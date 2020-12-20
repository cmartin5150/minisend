<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Email;
use App\Classes\EmailStatus;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function createEmail()
    {
        return view('create_email');
    }
    
    public function submitEmail(Request $request)
    {        
        error_log(__CLASS__ . '::' . __FUNCTION__ . '() ' . print_r($request->input(), true));
        
        $validator = Validator::make(
            $request->all(),
            [
                'to' => 'required|email',
                'from' => 'required|email',
                'subject' => 'required'
                
            ]            
        );
        
        if($validator->fails()) {
            return redirect(route('create_email'))->withErrors($validator)->withInput();
        }
        
        Email::create([
            'to' => $request->input('to'),
            'from' => $request->input('from'),
            'subject' => $request->input('subject'),
            'content_plain' => $request->input('content_plain'),
            'content_html' => $request->input('content_html'),
        ]);
        
        return view('email_sent');
    }
    
    public function listEmails()
    {
        $statuses = EmailStatus::orderBy('status_id', 'ASC')->get();
        
        $data = [
            'statuses' => $statuses
        ];
        
        return view('list_emails', $data);
    }
    
    public function getEmails(Request $request)
    {   
        //error_log(__CLASS__ . '::' . __FUNCTION__ . '() ' . print_r($request->input(), true));
        
        $results_per_page = 10;
        
        $query = Email::with('status');
        
        if(!empty($request->input('from'))) {
            $query->where('from', 'LIKE', '%' . $request->input('from') . '%');
        }
        
        if(!empty($request->input('to'))) {
            $query->where('to', 'LIKE', '%' . $request->input('to') . '%');
        }
        
        if(!empty($request->input('subject'))) {
            $query->where('subject', 'LIKE', '%' . $request->input('subject') . '%');
        }
        
        if(!empty($request->input('status_id'))) {
            $query->where('status_id', '=', $request->input('status_id'));
        }
                
        $query->orderBy('id', 'DESC');
        
        //error_log(__CLASS__ . '::' . __FUNCTION__ . '() [' . __LINE__ . '] sql ' . $query->toSql());
        
        $email_list = $query->paginate($results_per_page);
        
        return json_encode($email_list);
    }
    
    public function showEmail($id = 0)
    {        
        $email = Email::with('status')
                    ->where('id', '=', $id)
                    ->first();
        
        if(empty($email)) {
            return redirect(route('list_emails'));   
        }
        
        return view('show_email', ['email' => $email]);
    }
}
