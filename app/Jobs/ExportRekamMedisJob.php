<?php

use App\Models\RekamMedisModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportRekamMedisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $data = RekamMedisModel::with(['user', 'pasien'])->get();

        // Header
        foreach ($this->fields as $index => $field) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, ucfirst($field));
        }

        // Rows
        foreach ($data as $rowIndex => $record) {
            foreach ($this->fields as $colIndex => $field) {
                $value = data_get($record, $field); // Bisa nested: user.name
                $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value);
            }
        }

        $filename = 'rekam_medis_export_' . now()->timestamp . '.xlsx';
        $path = storage_path('app/public/exports/' . $filename);

        (new Xlsx($spreadsheet))->save($path);
    }
}
