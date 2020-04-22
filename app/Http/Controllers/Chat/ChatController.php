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
}
