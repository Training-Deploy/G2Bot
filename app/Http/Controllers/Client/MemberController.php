<?php

namespace App\Http\Controllers\Client;

use DataTables;
use Illuminate\Http\Request;
use App\Imports\MembersImport;
use \Maatwebsite\Excel\Exceptions;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Member\MemberRepositoryInterface;

class MemberController extends Controller
{
    /**
     * instance member repository
     *
     * @var App\Repositories\Member\MemberRepositoryInterface $member
     */
    protected $member = null;

    /**
     * Constructor
     *
     * @param MemberRepositoryInterface $member
     */
    public function __construct(MemberRepositoryInterface $member)
    {
        $this->member = $member;
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
            $member = new MembersImport($this->member, $sheet);
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

    public function index()
    {
        return DataTables::of($this->member->getListByUser(Auth::user()->id))
        ->addColumn('action', function ($data) {
            return '<button class="btn btn-primary" data-id="
            '.$data->id.'"><i class="fa fa-fw fa-edit"></i>Edit </button>&nbsp
            <button class="btn btn-danger delete" data-id="'.$data->id.'">
            <i class="fa fa-fw fa-trash-o"></i>Delete </button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show()
    {
        $members = $this->member->getAll();

        return response()->json(['data' => $members]);
    }
}
