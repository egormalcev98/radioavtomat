<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Chat\ChatService as Service;
use App\Http\Requests\Chat\SendMessageRequest;

class ChatController extends Controller
{ 
    public function __construct(Service $service) {
		$this->service = $service;
	}
	
	public function sendMessage(SendMessageRequest $request)
    {
		if ($request->ajax()) {
			
			$this->service->saveMessage($request);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(404);
    }
	
	public function selectChannel(Request $request)
    {
		if ($request->ajax()) {
			
			$messages = $this->service->saveChannelAndGetMessages($request);
			
			return response()->json([
				'status' => 'success',
				'messages' => $messages,
			]);
		}
		
		return abort(404);
    }
	
	public function readMessages(Request $request)
    {
		if ($request->ajax()) {
			
			$this->service->saveReadMessages($request);
			
			return $this->ajaxSuccessResponse();
		}
		
		return abort(404);
    }
}
