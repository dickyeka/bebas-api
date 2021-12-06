<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display all member.
     *
     */

    public function index(Member $member)
    {
        try {
            $members = $member::with('user')->get();
            return response()->json($members);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'something went wrong'
            ], 404);
        }
    }

    /**
     * show member of user.
     *
     */

    public function show($id)
    {
        try {
            $user = User::with('member')->findOrFail($id);
            return response()->json($user);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'data not found'
            ], 404);
        }
    }

    /**
     * Create member
     *
     */

    public function store(CreateMemberRequest $request)
    {
        $result = DB::transaction(function () use ($request) {
            try {
                $member = Member::create([
                    'user_id' => $request->user()->id,
                    'status' => $request->status,
                    'position' => $request->position
                ]);
                return response()->json($member, 201);
            } catch (\Exception $e) {
                return response(['error' => 'something went wrong']);
            }
        });
        return $result;
    }

    /**
     * Update member
     *
     */

    public function update(UpdateMemberRequest $request, $id)
    {
        $result = DB::transaction(function () use ($request, $id) {
            try {
                $member = Member::findOrFail($id);
                $this->authorize('update', $member);

                $member->update([
                    'status' => $request->status,
                    'position' => $request->position,
                ]);

                return response()->json($member, 201);
            } catch (\Exception $e) {
                return $e;
                return response(['error' => 'something went wrong']);
            }
        });

        return $result;
    }

    /**
     * remove member
     *
     */

    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            $this->authorize('delete', $member);
            $member->delete();

            return response([
                'status' => 'deleted'
            ]);
        } catch (\Throwable $th) {
            return response(['error' => 'data not found']);
        }
    }
}
