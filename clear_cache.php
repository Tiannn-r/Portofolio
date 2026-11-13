<?php
header('Content-Type: text/html; charset=utf-8');

$isPublic = basename(__DIR__) === 'public';
$baseDir = $isPublic ? dirname(__DIR__) : __DIR__;

// 1. Clear compiled Blade views
$viewDir = $baseDir . '/storage/framework/views';
$vCount = 0;
if (is_dir($viewDir)) {
    foreach (glob($viewDir . '/*.php') as $f) {
        if (is_file($f)) {
            @unlink($f);
            $vCount++;
        }
    }
}

// 2. Clear bootstrap cache
$cacheDir = $baseDir . '/bootstrap/cache';
$cCount = 0;
if (is_dir($cacheDir)) {
    foreach (glob($cacheDir . '/*.php') as $f) {
        if (is_file($f) && basename($f) !== '.gitignore') {
            @unlink($f);
            $cCount++;
        }
    }
}

// 3. Connect to Laravel & Update database schema
$dbStatus = 'Belum dijalankan';
$autoload = $baseDir . '/vendor/autoload.php';
$bootstrap = $baseDir . '/bootstrap/app.php';

if (file_exists($autoload) && file_exists($bootstrap)) {
    require $autoload;
    $app = require_once $bootstrap;
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    try {
        Illuminate\Support\Facades\DB::statement("ALTER TABLE skills MODIFY icon TEXT NULL");
        Illuminate\Support\Facades\DB::statement("ALTER TABLE services MODIFY icon TEXT NULL");
        $dbStatus = '✅ Kolom icon pada tabel skills dan services berhasil diubah ke TEXT!';
    } catch (\Throwable $e) {
        $dbStatus = '⚠️ Database info: ' . htmlspecialchars($e->getMessage());
    }
} else {
    $dbStatus = '⚠️ File Laravel bootstrap tidak ditemukan di ' . htmlspecialchars($baseDir);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cache Cleared & Database Updated</title>
    <style>
        body { background: #051F20; color: #DAF1DE; font-family: system-ui, sans-serif; padding: 40px; }
        .box { background: #0B2B26; border: 1px solid #235347; border-radius: 12px; padding: 25px; max-width: 650px; margin: 0 auto; box-shadow: 0 0 25px rgba(142,182,155,0.2); }
        h1 { color: #8EB69B; margin-top: 0; font-size: 22px; }
        .success { color: #8EB69B; font-weight: bold; }
        ul { line-height: 1.8; }
        a { display: inline-block; margin-right: 15px; margin-top: 20px; padding: 10px 20px; background: #235347; color: #DAF1DE; text-decoration: none; border-radius: 8px; font-weight: bold; }
        a:hover { background: #8EB69B; color: #051F20; }
    </style>
</head>
<body>
    <div class="box">
        <h1>🚀 Cache Website Berhasil Dibersihkan!</h1>
        <ul>
            <li>✅ File View Cache terhapus: <strong><?= $vCount ?></strong> file</li>
            <li>✅ File Bootstrap Cache terhapus: <strong><?= $cCount ?></strong> file</li>
            <li><?= $dbStatus ?></li>
        </ul>
        <p style="margin-top: 20px; font-size: 14px; color: #8EB69B;">
            Sekarang browser akan memuat versi terbaru tanpa terhalang cache lama!
        </p>
        <div>
            <a href="/">Lihat Website Utama &rarr;</a>
            <a href="/admin">Buka Panel Admin &rarr;</a>
        </div>
    </div>
</body>
</html>

