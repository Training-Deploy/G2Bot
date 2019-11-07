<?php

namespace App\Http\Controllers\Client;

use DB;
use Illuminate\Http\Request;
use App\Imports\MembersImport;
use \Maatwebsite\Excel\Exceptions;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Member\MemberRepositoryInterface;

class MemberController extends Controller
{
    /**
     * instance member repository
     *
     * @var App\Repositories\Member\MemberRepositoryInterface $member
     */
    protected $memberRepository = null;

    /**
     * Constructor
     *
     * @param MemberRepositoryInterface $member
     */
    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Upload File Request
     *
     * @param Request $req
     * @return void
     */
    public function store(Request $req)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login'], 406);
        }

        try {
            $sheet = preg_replace('/&#?[a-z0-9]{2,8};/i', '', $req->sheet);
            $member = new MembersImport($this->memberRepository, $sheet);
            Excel::import($member, $req->file);

            if (count($member->validated()) > 0) {
                return response()->json(['error' => $member->validated()], 500);
            }
        } catch (Exceptions\SheetNotFoundException $e) {
            return response()->json(['error' => ['Sheet ' . $sheet . ' Not found']], 406);
        } catch (Exceptions\NoTypeDetectedException $e) {
            return response()->json(['error' => ['File invalid']], 406);
        } catch (ErrorException $e) {
            return response()->json(['error' => ['Error']], 406);
        }

        return response()->json(
            [
                'success' => 'Imported',
                'updated' => $member->getRowUpdated(),
                'failed' => $member->getRowEmpty(),
                'validate' => $member->validated(),
            ],
            200
        );
    }

    /**
     * Get list user by auth id
     *
     * @return mixed
     */
    public function index()
    {
        $members = $this->memberRepository->getListByUser(Auth::user()->id)->get();

        return response()->json(['data' => $members]);
    }

    /**
     * Update member , user_id match Auth id
     *
     * @param MemberRequest $request
     * @param integer $id
     * @return mixed
     */
    public function update(MemberRequest $request, $id)
    {
        if (Auth::user()->id == $request->user_id) {
            $this->memberRepository->updateMember($id, $request->all());

            return response()->json(true);
        }
    }
    
    /**
     * Destroy member
     *
     * @param integer $id
     * @return mixed
     */
    public function destroy($id)
    {
        $result = $this->memberRepository->deleteMember($id);

        return response()->json($result);
    }


    /**
     * Multiple Delete Members
     *
     * @param Request $req
     * @return mixed
     */
    public function multipleDestroy(Request $req)
    {
        DB::beginTransaction();
        try {
            $result = $this->memberRepository->multipleDelete($req->data_del);
            DB::commit();
        } catch (Exception $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }

        return response()->json($result);
    }
}
