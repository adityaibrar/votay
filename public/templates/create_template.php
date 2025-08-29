<?php
// Script untuk membuat template Excel
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$spreadsheet = new Spreadsheet();

// Sheet pertama - Data User
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data User');

// Header utama
$sheet->setCellValue('A1', 'Template Import User');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50');
$sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

// Header kolom
$sheet->setCellValue('A2', 'Nama');
$sheet->setCellValue('B2', 'Email');
$sheet->setCellValue('C2', 'Kelas');
$sheet->setCellValue('D2', 'Role');

// Style header kolom
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2196F3']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
];
$sheet->getStyle('A2:D2')->applyFromArray($headerStyle);

// Contoh data
$sheet->setCellValue('A3', 'John Doe');
$sheet->setCellValue('B3', 'john.doe@example.com');
$sheet->setCellValue('C3', 'XII IPA 1');
$sheet->setCellValue('D3', '2');

$sheet->setCellValue('A4', 'Jane Smith');
$sheet->setCellValue('B4', 'jane.smith@example.com');
$sheet->setCellValue('C4', 'XI IPS 2');
$sheet->setCellValue('D4', '2');

// Keterangan
$sheet->setCellValue('F2', 'PETUNJUK PENGGUNAAN');
$sheet->getStyle('F2')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('F2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFC107');

$sheet->setCellValue('F3', '1. Pengisian data dimulai dari baris ke-3');
$sheet->setCellValue('F4', '2. Kolom D (Role) diisi dengan kode dari sheet "Role"');
$sheet->setCellValue('F5', '3. Jangan mengubah header pada baris ke-2');
$sheet->setCellValue('F6', '4. Email harus unik (tidak boleh sama)');
$sheet->setCellValue('F7', '5. Hapus contoh data sebelum import');
$sheet->setCellValue('F8', '6. Format file: .xlsx, .xls, atau .csv');
$sheet->setCellValue('F9', '7. Maksimal ukuran file: 5MB');

// Style keterangan
$sheet->getStyle('F3:F9')->getFont()->setSize(10);
$sheet->getStyle('F3:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFACD');

// Auto width
foreach (range('A', 'F') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

// Sheet kedua - Role
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Role');

$sheet2->setCellValue('A1', 'Daftar Role');
$sheet2->mergeCells('A1:B1');
$sheet2->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet2->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF5722');
$sheet2->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

$sheet2->setCellValue('A2', 'Kode');
$sheet2->setCellValue('B2', 'Nama Role');

// Style header
$sheet2->getStyle('A2:B2')->applyFromArray($headerStyle);

$sheet2->setCellValue('A3', '1');
$sheet2->setCellValue('B3', 'Guru/Admin');
$sheet2->setCellValue('A4', '2');
$sheet2->setCellValue('B4', 'Siswa');

// Style data
$sheet2->getStyle('A3:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Auto width
$sheet2->getColumnDimension('A')->setAutoSize(true);
$sheet2->getColumnDimension('B')->setAutoSize(true);

// Kembali ke sheet pertama
$spreadsheet->setActiveSheetIndex(0);

// Simpan file
$writer = new Xlsx($spreadsheet);
$filename = 'template-import-user.xlsx';
$writer->save(__DIR__ . '/' . $filename);

echo "Template Excel berhasil dibuat: " . $filename . "\n";
