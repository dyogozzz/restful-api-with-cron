<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use PhpMimeMailParser\Parser;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::where('deleted', false)->get();
        return response()->json($emails);
    }

    public function store(Request $request)
    {
        $rawEmailContent = $request->input('email');
        
        $email = new Email();
        $email->raw_email_content = $rawEmailContent;
        $email->save();

        $this->parseEmail($email);

        return response()->json($email, 201);
    }

    public function show($id)
    {
        $email = Email::findOrFail($id);
        if ($email->deleted) {
            return response()->json(['message' => 'Email not found'], 404);
        }
        return response()->json($email);
    }

    public function update(Request $request, $id)
    {
        $email = Email::findOrFail($id);
        if ($email->deleted) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        $rawEmailContent = $request->input('email');
        $email->raw_email_content = $rawEmailContent;
        $email->processed = false;
        $email->save();

        $this->parseEmail($email);

        return response()->json($email);
    }

    public function destroy($id)
    {
        $email = Email::findOrFail($id);
        $email->deleted = true;
        $email->save();

        return response()->json(['message' => 'Email deleted']);
    }

    private function parseEmail($email)
    {

        $parser = new Parser();
        $parser->setText($email->email);
        $plainText = $parser->getMessageBody('text');
        $plainText = preg_replace('/[^\P{C}\n]+/u', '', $plainText);

        $email->raw_text = $plainText;
        $email->processed = true;
        $email->save();
    }
}