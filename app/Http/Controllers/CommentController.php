<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterCommentRequest;
use App\Http\Requests\RieltorCommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addRieltorComment(RieltorCommentRequest $request, CommentService $commentService)
    {
        try {
            $commentService->addCommentRieltor($request->user(), $request->all());
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function addMasterComment(MasterCommentRequest $request, CommentService $commentService){
        try {
            $commentService->addCommentMaster($request->user(), $request->all());
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
