<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getCommentsByApplicant($applicant_id)
    {
        try {
            $comments = $this->commentService->getCommentsByApplicant($applicant_id);

            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching comments by applicant'], 500);
        }
    }

    public function store(CommentRequest $request, $applicant_id, $round_id, $round_type)
    {
        try {
            $comment = $this->commentService->createComment($request->validated(), $applicant_id, $round_id, $round_type);

            return response()->json(['comment' => $comment], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating comment'], 500);
        }
    }

    // public function index()
    // {
    //     try {
    //         $comments = $this->commentService->getAllComments();
    //         return response()->json($comments);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Error fetching comments'], 500);
    //     }
    // }

    public function update(CommentRequest $request, $id)
    {
        try {
            $comment = $this->commentService->updateComment($id, $request->validated());

            return response()->json(['comment' => $comment], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating comment'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->commentService->deleteComment($id);

            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting comment'], 500);
        }
    }
}
