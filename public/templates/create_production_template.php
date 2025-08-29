<?php
// Script untuk membuat template Excel bersih untuk produksi
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

$spreadsheet = new Spreadsheet();

// Sheet pertama - Data User
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data User');

// Header utama
$sheet->setCellValue('A1', 'TEMPLATE IMPORT USER - SISTEM E-VOTING');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1565C0');
$sheet->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getRowDimension('1')->setRowHeight(30);

// Header kolom
$headers = ['Nama', 'Email', 'Kelas', 'Role'];
$column = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($column . '2', $header);
    $column++;
}

// Style header kolom
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E7D32']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000']
        ]
    ]
];
$sheet->getStyle('A2:D2')->applyFromArray($headerStyle);
$sheet->getRowDimension('2')->setRowHeight(25);

// Tambahkan validasi data untuk kolom Role (100 baris ke depan)
for ($i = 3; $i <= 103; $i++) {
    $validation = $sheet->getCell('D' . $i)->getDataValidation();
    $validation->setType(DataValidation::TYPE_LIST);
    $validation->setErrorStyle(DataValidation::STYLE_STOP);
    $validation->setAllowBlank(false);
    $validation->setShowInputMessage(true);
    $validation->setShowErrorMessage(true);
    $validation->setShowDropDown(true);
    $validation->setErrorTitle('Input Error');
    $validation->setError('Nilai harus 1 (Guru) atau 2 (Siswa)');
    $validation->setPromptTitle('Pilih Role');
    $validation->setPrompt('Pilih: 1 untuk Guru/Admin, 2 untuk Siswa');
    $validation->setFormula1('Role!$A$3:$A$4');
}

// Format baris data dengan alternating colors
for ($i = 3; $i <= 103; $i++) {
    $color = ($i % 2 == 0) ? 'F8F9FA' : 'FFFFFF';
    $sheet->getStyle('A' . $i . ':D' . $i)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
}

// Keterangan dan instruksi
$sheet->setCellValue('F1', 'PETUNJUK PENGGUNAAN');
$sheet->getStyle('F1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF9800');
$sheet->getStyle('F1')->getFont()->getColor()->setRGB('FFFFFF');

$instructions = [
    '✓ Mulai mengisi data dari baris ke-3',
    '✓ Jangan mengubah header pada baris ke-2',
    '✓ Email harus unik dan valid',
    '✓ Gunakan dropdown di kolom Role',
    '✓ Format: .xlsx, .xls, .csv (max 5MB)',
    '✓ Password default: 12345678',
    '',
    'CONTOH FORMAT:',
    'Nama: Ahmad Suharto',
    'Email: ahmad.s@sekolah.sch.id',
    'Kelas: XII IPA 1 / Guru MTK',
    'Role: 1 (Guru) atau 2 (Siswa)',
    '',
    'TIPS:',
    '• Gunakan email sekolah',
    '• Konsisten format email',
    '• Cek duplikasi email',
    '• Backup data sebelum import'
];

$row = 2;
foreach ($instructions as $instruction) {
    $sheet->setCellValue('F' . $row, $instruction);
    if (strpos($instruction, '✓') !== false) {
        $sheet->getStyle('F' . $row)->getFont()->getColor()->setRGB('2E7D32');
    } elseif (strpos($instruction, 'CONTOH') !== false || strpos($instruction, 'TIPS') !== false) {
        $sheet->getStyle('F' . $row)->getFont()->setBold(true)->getColor()->setRGB('D32F2F');
    }
    $row++;
}

// Style untuk instruksi
$sheet->getStyle('F2:F20')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3E0');
$sheet->getStyle('F2:F20')->getFont()->setSize(10);

// Auto width untuk kolom utama
foreach (['A', 'B', 'C', 'D'] as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}
$sheet->getColumnDimension('F')->setWidth(35);

// Sheet kedua - Role
$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('Role');

$sheet2->setCellValue('A1', 'DAFTAR ROLE SISTEM');
$sheet2->mergeCells('A1:B1');
$sheet2->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet2->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D32F2F');
$sheet2->getStyle('A1')->getFont()->getColor()->setRGB('FFFFFF');

$sheet2->setCellValue('A2', 'Kode');
$sheet2->setCellValue('B2', 'Nama Role');

// Style header
$sheet2->getStyle('A2:B2')->applyFromArray($headerStyle);

// Data role
$roles = [
    ['1', 'Guru/Admin'],
    ['2', 'Siswa']
];

$row = 3;
foreach ($roles as $role) {
    $sheet2->setCellValue('A' . $row, $role[0]);
    $sheet2->setCellValue('B' . $row, $role[1]);
    $row++;
}

// Style data role
$roleStyle = [
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000']
        ]
    ]
];
$sheet2->getStyle('A3:B4')->applyFromArray($roleStyle);

// Keterangan role
$sheet2->setCellValue('D2', 'KETERANGAN AKSES');
$sheet2->getStyle('D2')->getFont()->setBold(true);
$sheet2->setCellValue('D3', 'Guru/Admin: Kelola user, OSIS, voting, laporan');
$sheet2->setCellValue('D4', 'Siswa: Hanya dapat melakukan voting');
$sheet2->setCellValue('D6', 'PASSWORD DEFAULT: 12345678');
$sheet2->getStyle('D6')->getFont()->setBold(true)->getColor()->setRGB('D32F2F');

// Auto width
$sheet2->getColumnDimension('A')->setAutoSize(true);
$sheet2->getColumnDimension('B')->setAutoSize(true);
$sheet2->getColumnDimension('D')->setWidth(35);

// Kembali ke sheet pertama
$spreadsheet->setActiveSheetIndex(0);

// Simpan file
$writer = new Xlsx($spreadsheet);
$filename = 'template-import-user-production.xlsx';
$writer->save(__DIR__ . '/' . $filename);

echo "Template Excel Production berhasil dibuat: " . $filename . "\n";
