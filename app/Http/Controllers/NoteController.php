<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('category', 'reminders', 'attachments')->get();
        return NoteResource::collection($notes);
    }

    public function indexByUser()
    {
        $user = auth()->user();
        $notes = Note::with('category', 'reminders', 'attachments')->where('user_id', $user->id)->get();
        return NoteResource::collection($notes);
    }

    public function store(NoteRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $note = Note::create($data);
        return new NoteResource($note);
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);
        $note->load('category', 'reminders', 'attachments');
        return new NoteResource($note);
    }

    public function update(NoteRequest $request, $id)
    {
        $note = Note::findOrFail($id);
        $note['category_id'] = 1;
        $note->update($request->validated());
        return new NoteResource($note);
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json(['message' => 'Note deleted successfully.']);
    }
}
