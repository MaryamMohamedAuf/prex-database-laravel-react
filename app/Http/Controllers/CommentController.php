<?php

namespace App\Http\Controllers;

use App\Http\Requests\applicant as RequestsApplicant;
use App\Models\Comment;
use App\Models\Applicant;
use App\Models\Cohort;
use App\Models\Round1;
use App\Models\Round2;
use App\Models\Round3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function getCommentsByApplicant($applicant_id)
    {
        try {
            $comments = Comment::with(['user', 'applicant', 'cohort', 'round1', 'round2', 'round3'])
                ->where('applicant_id', $applicant_id)
                ->get();

            return response()->json($comments);
        } catch (\Exception $e) {
            Log::error('Error fetching comments by applicant:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error fetching comments by applicant'], 500);
        }
    }
    // public function store(Request $request, $applicant_id, $round1_id = null, $round2_id = null, $round3_id = null)
    // {
    //     try {
    //         $data = $request->validate([
    //             'feedback' => 'nullable|string',
    //             'decision' => 'nullable|in:accepted,rejected',
    //         ]);
    
    //         $user = auth()->user();
    //         if (!$user) {
    //             return response()->json(['message' => 'Unauthorized'], 401);
    //         }
    
    //         $applicant = Applicant::findOrFail($applicant_id);
    //         $data['user_id'] = $user->id;
    //         $data['applicant_id'] = $applicant->id;
    //         $data['cohort_id'] = $applicant->cohort_id;
    
    //         if ($round1_id) {
    //             $round1 = Round1::findOrFail($round1_id);
    //             $data['round1_id'] = $round1->id;
    //         }
    
    //         if ($round2_id) {
    //             $round2 = Round2::findOrFail($round2_id);
    //             $data['round2_id'] = $round2->id;
    //         }
    
    //         if ($round3_id) {
    //             $round3 = Round3::findOrFail($round3_id);
    //             $data['round3_id'] = $round3->id;
    //         }
    
    //         $comment = Comment::create($data);
    
    //         return response()->json(['comment' => $comment], 201);
    //     } catch (\Exception $e) {
    //         Log::error('Error creating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    //         return response()->json(['message' => 'Error creating comment'], 500);
    //     }
    // }
    public function store(Request $request, $applicant_id, $round_id, $round_type)
{
    try {
        $data = $request->validate([
            'feedback' => 'nullable|string',
            'decision' => 'nullable|in:accepted,rejected',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $applicant = Applicant::findOrFail($applicant_id);
        $data['user_id'] = $user->id;
        $data['applicant_id'] = $applicant->id;
        $data['cohort_id'] = $applicant->cohort_id;

        switch ($round_type) {
            case 'round1':
                $round1 = Round1::findOrFail($round_id);
                $data['round1_id'] = $round1->id;
                break;
            case 'round2':
                $round2 = Round2::findOrFail($round_id);
                $data['round2_id'] = $round2->id;
                break;
            case 'round3':
                $round3 = Round3::findOrFail($round_id);
                $data['round3_id'] = $round3->id;
                break;
            default:
                return response()->json(['message' => 'Invalid round type'], 400);
        }

        $comment = Comment::create($data);

        return response()->json(['comment' => $comment], 201);
    } catch (\Exception $e) {
        Log::error('Error creating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json(['message' => 'Error creating comment'], 500);
    }
}

    

    public function index(Request $request)
    {
        $comments = Comment::with(['user', 'applicant', 'cohort', 'round1', 'round2', 'round3'])->get();
        return response()->json($comments);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'applicant_id' => 'required|exists:applicants,id',
                'cohort_id' => 'required|exists:cohorts,id',
                'round1_id' => 'nullable|exists:round1s,id',
                'round2_id' => 'nullable|exists:round2s,id',
                'round3_id' => 'nullable|exists:round3s,id',
                'feedback' => 'nullable|string',
                'decision' => 'nullable|in:accepted,rejected',
            ]);

            $comment = Comment::findOrFail($id);
            $comment->update($data);

            return response()->json(['comment' => $comment], 200);
        } catch (\Exception $e) {
            Log::error('Error updating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error updating comment'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error deleting comment'], 500);
        }
    }
}
