<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentService
{
    public function getCommentsByApplicant(int $applicant_id)
    {
        try {
            return Comment::with(['user', 'applicant', 'cohort', 'round1', 'round2', 'round3'])
                ->where('applicant_id', $applicant_id)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error fetching comments by applicant:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function createComment(array $data, int $applicant_id, int $round_id, string $round_type): Comment
    {
        try {
            $data['applicant_id'] = $applicant_id;

            switch ($round_type) {
                case 'round1':
                    $data['round1_id'] = $round_id;
                    break;
                case 'round2':
                    $data['round2_id'] = $round_id;
                    break;
                case 'round3':
                    $data['round3_id'] = $round_id;
                    break;
                default:
                    throw new \Exception('Invalid round type');
            }

            return Comment::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function updateComment(int $id, array $data): Comment
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->update($data);

            return $comment;
        } catch (\Exception $e) {
            Log::error('Error updating comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function deleteComment(int $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting comment:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
