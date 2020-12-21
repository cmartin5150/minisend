<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Email;
use App\Classes\EmailStatus;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Classes\EmailAttachment;

class EmailController extends Controller
{
    public function createEmail()
    {
        return view('create_email');
    }
    
    public function submitEmail(Request $request)
    {        
        //error_log(__CLASS__ . '::' . __FUNCTION__ . '() ' . print_r($request->input(), true));
        
        
        $attachment_max_size_mb = 2;
        $attachment_max_size_kb = 1000 * $attachment_max_size_mb;
        
        $validator = Validator::make(
            $request->all(),
            [
                'to' => 'required|email',
                'from' => 'required|email',
                'subject' => 'required',
                'attachment.*' => 'max:' . $attachment_max_size_kb
            ],
            [
                // custom validation messages
                'attachment.*.max' => 'Maximum attachment size: ' . $attachment_max_size_mb . ' Mb'
            ]
        );
        
        if($validator->fails()) {
            return redirect(route('create_email'))->withErrors($validator)->withInput();
        }
        
        $email = Email::create([
            'to' => $request->input('to'),
            'from' => $request->input('from'),
            'subject' => $request->input('subject'),
            'content_plain' => $request->input('content_plain') ?? '',
            'content_html' => $request->input('content_html') ?? '',
        ]);
        
        if(!empty($email)) {                                
            if($request->hasFile('attachment')) {                
                foreach ($request->file('attachment') as $file) {
                    
                    // persist attachment to local storage
                    $path = $file->store('uploads');
                    
                    if(Storage::disk()->exists($path)) {
                        
                        // persist attachment to database
                         $attachment = EmailAttachment::make();
                         $attachment->email_id = $email->id;
                         $attachment->name = $file->getClientOriginalName();                         
                         $attachment->data = Storage::get($path);
                         $attachment->mime_type = $file->getClientMimeType();
                         $attachment->size = $file->getClientSize();
                         $attachment->save();
                                                
                        // delete local file
                        Storage::delete($path);
                    }
                }                
            }
        }
        
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
        $email = Email::with('status', 'attachments')
                    ->where('id', '=', $id)
                    ->first();
        
        if(empty($email)) {
            return redirect(route('list_emails'));   
        }
        
        return view('show_email', ['email' => $email]);
    }
    
    public function downloadAttachment($id = 0)
    {
        // get file from database
        $attachment = EmailAttachment::where('id', '=', $id)->first();
        
        if(empty($attachment)) {
            return 'attachment not found';
        }
                
        // build file download response       
        $response = response($attachment->data)
                ->header('Cache-Control', 'no-cache private')
                ->header('Content-Description', 'File Transfer')
                ->header('Content-Type', $attachment->mime_type)
                ->header('Content-Length', $attachment->size)
                ->header('Content-Disposition', 'attachment; filename=' . $attachment->name)
                ->header('Content-Transfer-Encoding', 'binary');

        // ensure that the output buffer is clean
        ob_end_clean();
                
        return $response;
    }
}
