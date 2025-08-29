<?php
// Script untuk membuat template Excel yang lebih advanced
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

// Contoh data dengan style
$exampleData = [
    ['Ahmad Suharto', 'ahmad.suharto@smk.sch.id', 'Guru Matematika', '1'],
    ['Siti Aminah', 'siti.aminah@smk.sch.id', 'XII IPA 1', '2'],
    ['Budi Santoso', 'budi.santoso@smk.sch.id', 'XI IPS 2', '2']
];

$row = 3;
foreach ($exampleData as $data) {
    $col = 'A';
    foreach ($data as $value) {
        $sheet->setCellValue($col . $row, $value);
        $col++;
    }
    $row++;
}

// Style contoh data
$exampleStyle = [
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E8']],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF4CAF50']
        ]
    ]
];
$sheet->getStyle('A3:D5')->applyFromArray($exampleStyle);

// Tambahkan validasi data untuk kolom Role
for ($i = 6; $i <= 100; $i++) {
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

// Keterangan dan instruksi
$sheet->setCellValue('F1', 'PETUNJUK PENGGUNAAN');
$sheet->getStyle('F1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF9800');
$sheet->getStyle('F1')->getFont()->getColor()->setRGB('FFFFFF');

$instructions = [
    '1. HAPUS contoh data (baris 3-5) sebelum mengisi data real',
    '2. Mulai mengisi data dari baris ke-6',
    '3. Jangan mengubah header pada baris ke-2',
    '4. Email harus unik (tidak boleh sama)',
    '5. Kolom Role: 1 = Guru/Admin, 2 = Siswa',
    '6. Gunakan dropdown di kolom Role untuk memilih',
    '7. Format file: .xlsx, .xls, .csv (max 5MB)',
    '8. Password default: 12345678',
    '',
    'CONTOH EMAIL YANG BAIK:',
    '• nama.lengkap@sekolah.sch.id',
    '• guru.matematika@smk.edu',
    '• siswa123@sekolah.ac.id'
];

$row = 2;
foreach ($instructions as $instruction) {
    $sheet->setCellValue('F' . $row, $instruction);
    if (strpos($instruction, 'CONTOH') !== false || empty($instruction)) {
        $sheet->getStyle('F' . $row)->getFont()->setBold(true);
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
$sheet2->setCellValue('D2', 'KETERANGAN');
$sheet2->getStyle('D2')->getFont()->setBold(true);
$sheet2->setCellValue('D3', 'Guru/Admin: Akses penuh ke sistem');
$sheet2->setCellValue('D4', 'Siswa: Hanya bisa voting');

// Auto width
$sheet2->getColumnDimension('A')->setAutoSize(true);
$sheet2->getColumnDimension('B')->setAutoSize(true);
$sheet2->getColumnDimension('D')->setWidth(30);

// Kembali ke sheet pertama
$spreadsheet->setActiveSheetIndex(0);

// Simpan file
$writer = new Xlsx($spreadsheet);
$filename = 'template-import-user-advanced.xlsx';
$writer->save(__DIR__ . '/' . $filename);

echo "Template Excel Advanced berhasil dibuat: " . $filename . "\n";
