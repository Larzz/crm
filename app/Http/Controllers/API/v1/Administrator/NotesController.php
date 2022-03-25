<?php

namespace App\Http\Controllers\API\v1\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notes;

class NotesController extends Controller
{
    //
    public $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }


    /**
     * Save Notes.
     * @param user_id
     * @return status
     */
    public function addNotes($user_id) {

        $note = new Notes;
        $note->user_id = $user_id;
        $note->title = $this->request->title;
        $note->notes = $this->request->notes;
        $note->added_by = auth()->user()->id;

        if($note->save()) {
            return response()->json(['status' => true, 'note' => $note], 201);
        }

        return response()->json(['status' => false]);
    }


    /**
     * Get Notes by User .
     * @param user_id
     * @return status
     */
    public function getNotesByUserId($user_id) {
        return response()->json(['status' => true, 'notes' => Notes::where('user_id', $user_id)->orderBy('created_at', 'desc')->get()]);
    }


    /**
     * Delete Note .
     * @param note_id
     * @return status
     */
    public function deleteNotes($note_id) {
        $note = Notes::where('id', $note_id)->first();

        if($note) {
           $note->delete();
           return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }


    /**
     * Update Note.
     * @param note_id
     * @param user_id
     * @return status
     */
    public function updateNotes($user_id, $note_id) {
        $note = Notes::where('id', $note_id)->where('user_id', $user_id)->first();

        if($note) {

            Notes::where('id', $note_id)->where('user_id', $user_id)->update([
                'title' => $this->request->title,
                'notes' => $this->request->notes
            ]);

            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

}
