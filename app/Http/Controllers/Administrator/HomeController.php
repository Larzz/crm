<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\MeetingMinutes;
use App\Models\Presentations;
use App\Models\Documents;
use App\Models\User;
use App\Models\Notes;

class HomeController extends Controller
{
    public $request;

    public function __construct(Request $request) {
        $this->middleware('role:admin');
        $this->request = $request;
    }

     /**
     * Dashboard index page.
     * @return void
     */
    public function index() {
        $meta = array('active' => 'dashboard', 'title' => 'Dashboard', 'active' => 'dashboard');
        return view('administrator.pages.dashboard', $meta);
    }

    public function client_page() {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'users' => User::where('role', 3)->get());
        return view('administrator.pages.client', $meta);
    }

    public function client_index_page($id) {
        $meta = array('active' => 'client', 'title' => 'Client', 'active' => 'client', 'user' => User::where('id', $id)->first());
        return view('administrator.pages.client.view_client', $meta);
    }

    public function employee_page($id) {
        $meta = array('active' => 'employee', 'user' => User::where('id', $id)->first(), 'active' => 'employee_page','title' => 'Employee');
        return view('administrator.pages.employee', $meta);
    }

    public function leave_request_page() {
        $meta = array('active' => 'leave_request', 'title' => 'Leave Request');
        return view('administrator.pages.leave_request', $meta);
    }

    public function project_page() {
        $meta = array('active' => 'project', 'title' => 'Project');
        return view('administrator.pages.projects', $meta);
    }

    public function meeting_minutes_page() {
        $meta = array(
            'active' => 'meeting_minutes', 
            'title' => 'Meeting Minutes',
            'meeting_minutes' => MeetingMinutes::leftjoin('users', 'users.id','meeting_minutes.client_id')->select('users.name as client_name', 'meeting_minutes.name as filename', 'meeting_minutes.description as filename_desc')->get(),
            'users' => User::where('role', 3)->get(),
        );
        return view('administrator.pages.meeting_minutes', $meta);
    }     


    public function save_minutes() {
        
        $minutes = New MeetingMinutes;
        $minutes->name = $this->request->name;
        $minutes->description = $this->request->description;
        $minutes->meeting_date = $this->request->meeting_date;
        $minutes->attachment = $this->request->attachment;
        $minutes->client_id = $this->request->client_id;
        $minutes->user_id = Auth::User()->id;

        if($minutes->save()) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    public function upload_minutes() {

        if ($this->request->qqfile) {

            $file = $this->request->qqfile;
			$filename = $file->getClientOriginalName() .'-'. time() . '.' . $file->getClientOriginalExtension();
	        $filetype = $file->getClientOriginalExtension();
	        $filesize = filesize($file);

	        if($file->move(public_path('documents'), $filename)) {
	            $response = ['status' => true, 'success' => true, 'filesize' => $filesize, 'filetype' => $filetype, 'filename' => $filename, 'hash_file' => $filename];
	            return json_encode($response);
	        }

        }

        return response()->json(['success' => false]);
    }

    
    public function presentation_page() {
        $meta = array(
                'active' => 'presentations', 
                'title' => 'Presentations',
                'presentations' => Presentations::leftjoin('users', 'users.id','presentation.client_id')->select('users.name as client_name', 'presentation.name as filename', 'presentation.description as filename_desc')->get(),
                'users' => User::where('role', 3)->get(),
            );
        return view('administrator.pages.presentations', $meta);
    }  


    public function save_presentation() {
        
        $documents = New Presentations;
        $documents->name = $this->request->name;
        $documents->description = $this->request->description;
        $documents->date_added = date('Y-m-d');
        $documents->attachment = $this->request->attachment;
        $documents->client_id = $this->request->client_id;
        $documents->user_id = Auth::User()->id;

        if($documents->save()) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    public function upload_presentation() {

        if ($this->request->qqfile) {

            $file = $this->request->qqfile;
			$filename = $file->getClientOriginalName() .'-'. time() . '.' . $file->getClientOriginalExtension();
	        $filetype = $file->getClientOriginalExtension();
	        $filesize = filesize($file);

	        if($file->move(public_path('presentation'), $filename)) {
	            $response = ['status' => true, 'success' => true, 'filesize' => $filesize, 'filetype' => $filetype, 'filename' => $filename, 'hash_file' => $filename];
	            return json_encode($response);
	        }

        }

        return response()->json(['success' => false]);
    }





    public function document_page() {
        $meta = array('active' => 'document', 
            'title' => 'Document', 
            'users' => User::where('role', 3)->get(),
            'documents' => Documents::leftjoin('users', 'users.id','documents.client_id')->select('users.name as client_name', 'documents.name as filename', 'documents.description as filename_desc')->get(),

        );
        return view('administrator.pages.documents', $meta);
    }     



    public function view_note($note_id) {
        
        $note = Notes::where('id', $note_id)->first();
        $meta = array(
            'active' => 'notes', 
            'title' => 'Note', 
            'note' => $note
        );

        return view('administrator.pages.notes', $meta);
    }


    public function save_document() {
        
        $documents = New Documents;
        $documents->name = $this->request->name;
        $documents->description = $this->request->description;
        $documents->attachment = $this->request->attachment;
        $documents->client_id = $this->request->client_id;
        $documents->user_id = Auth::User()->id;

        if($documents->save()) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    public function upload_document() {

        if ($this->request->qqfile) {

            $file = $this->request->qqfile;
			$filename = $file->getClientOriginalName() .'-'. time() . '.' . $file->getClientOriginalExtension();
	        $filetype = $file->getClientOriginalExtension();
	        $filesize = filesize($file);

	        if($file->move(public_path('documents'), $filename)) {
	            $response = ['status' => true, 'success' => true, 'filesize' => $filesize, 'filetype' => $filetype, 'filename' => $filename, 'hash_file' => $filename];
	            return json_encode($response);
	        }

        }

        return response()->json(['success' => false]);
    }


 

}
