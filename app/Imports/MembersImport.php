<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Repositories\Member\MemberRepositoryInterface;

class MembersImport implements ToCollection, WithStartRow, WithHeadingRow, WithMultipleSheets
{
    /**
     * Count Rows Empty
     *
     * @var integer
     */
    private $rowsEmpty = 0;
    /**
     * Count Row Updated
     *
     * @var integer
     */
    private $rowsUpdated = 0;
    /**
     * Validate about errors
     *
     * @var array
     */
    private $validate = [];
    /**
     * Model Member
     *
     * @var MemberRepositoryInterface
     */
    protected $member = null;

    /**
     * Sheet Name Import
     *
     * @var String
     */
    protected $sheet = null;

    /**
     * Construct
     *
     * @param MemberRepositoryInterface $member
     * @param String $sheet
     */
    public function __construct(MemberRepositoryInterface $member, $sheet)
    {
        $this->member = $member;
        $this->sheet = $sheet;
    }
    /**
     * Import to Collection
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        if (!$this->isEmptyColumns('fullname', $rows[0])) {
            $this->validate[] = 'Column fullname not found ! please format name column to fullname';
        }
        
        if (!$this->isEmptyColumns('birthday', $rows[0])) {
            $this->validate[] = 'Column birthday not found ! please format name column to birthday';
        }

        if (count($this->validate) == 0) {
            foreach ($rows as $row) {
                if (!$this->isEmptyRow($row['fullname']) && !$this->isEmptyRow($row['birthday'])) {
                    $this->addRowsToModel($row);
                    $this->rowsUpdated++;
                } else {
                    $this->rowsEmpty++;
                }
            }
        }
    }

    /**
     * @return int
     */
    public function startRow() : int
    {
        return 2;
    }

    /**
     * @return array
     */
    public function sheets() : array
    {
        return [
            $this->sheet => $this,
        ];
    }

    /**
     * Check row is empty
     *
     * @param String $row
     * @return boolean
     */
    private function isEmptyRow($row)
    {
        return isset($row) && !empty($row) ? false : true;
    }

    /**
     * Check empty columns name
     *
     * @param String $columnsName
     * @param Collection $array
     * @return boolean
     */
    private function isEmptyColumns(String $columnsName, $array)
    {
        return array_key_exists($columnsName, $array->toArray());
    }

    /**
     * Get Count Row Updated Success
     *
     * @return integer $rowsUpdated
     */
    public function getRowUpdated()
    {
        return $this->rowsUpdated;
    }

    /**
     * Get Count Row Empty Failed
     *
     * @return integer $rowsEmpty
     */
    public function getRowEmpty()
    {
        return $this->rowsEmpty;
    }

    /**
     * Data validated information
     *
     * @return array $validate
     */
    public function validated()
    {
        return $this->validate;
    }

    /**
     * Add Row to Model
     *
     * @param Collection $row
     * @return void
     */
    private function addRowsToModel(Collection $row)
    {
        $this->member->updateOrCreate([
            'full_name' => $row['fullname'],
            'birthday' => Carbon::instance(Date::excelToDateTimeObject($row['birthday'])),
        ], [
            'company_email' => isset($row['company_email']) ? $row['company_email'] : null,
            'user_id' => Auth::user()->id,
            'phone' => isset($row['phone_number']) ? $row['phone_number'] : null,
            'gmail' => isset($row['gmail']) ? $row['gmail'] : null,
            'github_account' => isset($row['github_account']) ? $row['github_account'] : null,
            'chatwork_account' => isset($row['chatwork_account']) ? $row['chatwork_account'] : null,
            'viblo_link' => isset($row['viblo_account_link']) ? $row['viblo_account_link'] : null,
            'ssh_key' => isset($row['ssh_public_key']) ? $row['ssh_public_key'] : null,
        ]);
    }
}
