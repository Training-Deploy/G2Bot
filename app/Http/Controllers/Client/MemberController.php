<?php

namespace App\Http\Controllers\Client;

use DB;
use Illuminate\Http\Request;
use App\Imports\MembersImport;
use \Maatwebsite\Excel\Exceptions;
use PhpOffice\PhpSpreadsheet\Exception;
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
            return response()->json(['message' => 'Please login'], 422);
        }

        try {
            $sheet = preg_replace('/&#?[a-z0-9]{2,8};/i', '', $req->sheet);
            $member = new MembersImport($this->memberRepository, $sheet);
            Excel::import($member, $req->file);

            if (!is_null($member->validated())) {
                return response()->json(['message' => $member->validated()], 422);
            }
        } catch (Exceptions\SheetNotFoundException $e) {
            return response()->json(['message' => 'Sheet ' . $sheet . ' Not found'], 422);
        } catch (Exceptions\NoTypeDetectedException $e) {
            return response()->json(['message' => 'File invalid'], 422);
        } catch (\ErrorException $e) {
            return response()->json(['message' => 'Please check format datetime'], 422);
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

            return response()->json(['success' => 'Updated Member !!']);
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
        if ($result) {
            return response()->json(['success' => 'Deleted Member !!']);
        }
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

        if ($result) {
            return response()->json(['success' => 'Deleted Multiple Member !!']);
        }
    }
}
