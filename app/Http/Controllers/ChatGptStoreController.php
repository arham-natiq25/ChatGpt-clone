<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class ChatGptStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreChatRequest $request, string $id=null)
    {
        $messages = [];
        if ($id) {
            $chat = Chat::findOrFail($id);
            $messages=$chat->context;
        }
        $messages[] = ['role'=>'user' , 'content'=>$request->input('prompt')];
        $response = OpenAI::chat()->create([
            'model'=>'gpt-4o',
            'messages'=>$messages
        ]);

        $messages[] = ['role'=>'assistant','content'=>$response->choices[0]->message->content];
        // $messagesString = json_encode($messages);
        $chat = Chat::updateOrCreate([
            'id'=>$id,
            'user_id'=>Auth::id(),

        ],
        [
            'context'=>$messages
        ]);

        return redirect()->route('chat.show',[$chat->id]);
        dd($messages);


    }
}
