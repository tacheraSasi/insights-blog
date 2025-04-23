<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsoleController extends Controller
{
    public function showEmailForm()
    {
        return view('console.email-form');
    }

    public function sendEmailToAllUsers(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::all();

        foreach ($users as $user) {
            Mail::send('emails.custom', [
                'subject' => $request->subject,
                'messageContent' => $this->messageTemplate($user->name,$request->message),
            ], function ($mail) use ($user, $request) {
                $mail->to($user->email)
                     ->subject($request->subject);
            });
        }

        return redirect()->route('console.email.form')->with('success', 'Emails sent successfully!');
    }

    public function messageTemplate($name,$message){

        return "Hello $name,\n $message";
    }
}