<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class File extends \App\Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Traits\Model\HasFamily;
    use \App\Traits\Model\HasRelations;
    use \App\Traits\Model\HasUser;
    /**
     * 与模型关联的数据表.
     *
     * @var string
     */
    protected $table = "_files";
    /**
     * 追加到模型数组表单的访问器
     *
     * @var array
     */
    protected $appends = [];
    /**
     * 模型的属性默认值。
     *
     * @var array
     */
    protected $attributes = [];
    // protected $primaryKey = 'coid';
    protected $relationshipKey = "file_id";
    protected $fillable = [
        'slug',
        'name',
        'path',
        'type',
        'status',
        'user_id',
        'template',
        'views',
        'parent',
        'count',
        'order',
        'mime_type',
        'created_at',
        'updated_at',
        'release_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getContentAttribute()
    {
        if (!Storage::exists($this->path)) {
            return;
        }
        $path = base_path('storage/app/' . $this->path);
        // dump($path);
        if (!file_exists($path)) {
            throw new \Exception("File does not exist.");
        }
        if (!extension_loaded('zip')) {
            throw new \Exception("ZipArchive extension is not enabled.");
        }
        if (!is_readable($path)) {
            throw new \Exception("File is not readable.");
        }
        $content = null;
        switch ($this->type) {
            case 'json':
                $content = Storage::get($this->path);
                // dump($content);
                $content = json_decode($content, JSON_UNESCAPED_UNICODE);
                break;
            case 'xlsx':
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($path);
                // dd($spreadsheet);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow(); // 总行数
                $highestColumn = $worksheet->getHighestColumn(); // 总列数
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                if ($highestRow - 2 < 0) exit('Excel表格中没有数据');

                for ($row = 1; $row <= $highestRow; ++$row) {
                    $item = [];
                    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                        $item[] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    $content[] = $item;
                }
                break;
            case 'xls':
            case 'csv':
                $content = [];

                // dd($path);
                /**  Identify the type of $inputFileName  **/
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);

                /**  Create a new Reader of the type that has been identified  **/
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

                /**  Load $inputFileName to a Spreadsheet Object  **/
                $spreadsheet = $reader->load($path);

                /**  Convert Spreadsheet Object to an Array for ease of use  **/
                // $schdeules = $spreadsheet->getActiveSheet()->toArray();

                // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow(); // 总行数
                $highestColumn = $worksheet->getHighestColumn(); // 总列数
                $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

                if ($highestRow - 2 < 0) exit('Excel表格中没有数据');

                for ($row = 1; $row <= $highestRow; ++$row) {
                    $item = [];
                    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                        $item[] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    $content[] = $item;
                }
                break;
            default:
                $content = Storage::get($this->path);
                $enc = mb_detect_encoding($content, mb_list_encodings(), true);
                // dump($enc);
                if (strtolower($enc) != 'utf-8') {
                    $content =  mb_convert_encoding($content, 'UTF-8', $enc);
                }
                // dd($content);
                break;
        }
        return $this->attributes['content'] = $content;
    }
}
