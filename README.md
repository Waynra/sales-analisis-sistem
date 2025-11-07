# Sales Analytics System

Dokumentasi singkat proyek "Sales Analytics System" — aplikasi Laravel untuk mengimpor, mengelola, menganalisis, dan mengekspor data penjualan dari beberapa platform e‑commerce (Shopee, Tokopedia, TikTok Shop).

## Ringkasan fitur

-   📊 Dashboard analitik sederhana (chart & total bulanan)
-   📥 Import data dari:
    -   File resmi platform (Shopee / Tokopedia / TikTok Shop) — sistem mendeteksi header dan memetakan kolom secara otomatis
    -   Template sistem (header standar: platform, date, product_name, quantity, price, ads_cost, affiliate_fee, total)
-   📤 Export ke Excel (.xlsx), CSV, dan PDF
-   🌓 Tema layout dasar tersedia (dark style pada `resources/views/layouts/app.blade.php`)

## Dependensi penting

-   PHP >= 8.0
-   Laravel 10.x
-   Composer
-   Database: MySQL / MariaDB (atau database lain yang didukung Laravel)
-   Paket composer yang digunakan di kode sumber ini:
    -   rap2hpoutre/fast-excel (import/export Excel/CSV)
    -   barryvdh/laravel-dompdf (generate PDF)

## Instalasi (singkat, Windows / PowerShell)

1. Clone repo:

```powershell
git clone <repository-url>
cd sales-analisis-sistem
```

2. Install dependencies:

```powershell
composer install
```

3. Siapkan environment dan key:

```powershell
copy .env.example .env
php artisan key:generate
```

4. Edit file `.env` untuk konfigurasi database dan APP_URL.

5. Jalankan migrasi:

```powershell
php artisan migrate
```

6. (Opsional) Jalankan server lokal:

```powershell
php artisan serve
```

## Route utama (yang tersedia saat ini)

Berikut route utama yang ada di `routes/web.php`:

-   GET / -> redirect ke route `sales.index`
-   GET /sales -> `SalesController@index` (lihat: `resources/views/sales/index.blade.php`)
-   POST /sales/import -> `SalesController@import` (import template sistem)
-   POST /sales/import-platform -> `SalesImportController@import` (import file resmi platform)
-   GET /sales/export/excel -> `SalesController@exportExcel`
-   GET /sales/export/csv -> `SalesController@exportCSV`
-   GET /sales/export/pdf -> `SalesController@exportPDF`

Catatan: nama route dapat dilihat di file `routes/web.php` dan digunakan di Blade (navbar dan tombol export).

## Struktur tampilan penting

-   `resources/views/layouts/app.blade.php` — layout utama (navbar + dark theme). Contoh:

    -   Navbar memiliki link: Sales Data (`sales.index`), Analytics (`sales.analytics`), dan dropdown Export.
    -   Bootstrap 5 + Chart.js digunakan untuk chart.

-   `resources/views/sales/index.blade.php` — halaman untuk mengimpor dan melihat tabel penjualan.
-   `resources/views/sales/pdf.blade.php` — template untuk export PDF.
-   `resources/views/dashboard.blade.php` — tampilan dashboard analitik.

## Import & mapping

-   `SalesController@import` mengimpor file dengan header template sistem.
-   `SalesImportController@import` menerima file dari platform resmi dan mencoba mendeteksi platform berdasarkan header (mis. `Order ID`/`Order Date` untuk Shopee; `Created Time` untuk TikTok; `No Pesanan` untuk Tokopedia), lalu memetakan kolom ke model `Sale`.

    Contoh header template yang diharapkan (CSV / XLSX):

    ```
    platform,date,product_name,quantity,price,ads_cost,affiliate_fee,total
    ```

    Jika nilai `total` tidak tersedia, sistem akan menghitungnya dari `quantity * price`.

    ## Model & Database

    -   Model utama: `App\\Models\\Sale` (fillable: platform, date, product_name, quantity, price, ads_cost, affiliate_fee, total)
    -   Migration: `database/migrations/2025_11_06_075522_create_sales_table.php` (kolom: platform, date, product_name, quantity, price, ads_cost, affiliate_fee, total)

    ## Menjalankan export

    -   Dari UI: gunakan tombol Export pada halaman Sales (atau dropdown Export di navbar pada layout).
    -   Endpoint yang sama tersedia untuk pemanggilan langsung (lihat routes di atas).

    ## Tips dan catatan pengembangan

    -   Pastikan timezone dan format tanggal pada `.env` sesuai data yang diimpor. Model mengasumsikan kolom `date` kompatibel dengan tipe `date` pada database.
    -   Untuk file besar, perhatikan memory limit PHP saat impor; pertimbangkan queue / chunking jika dataset tumbuh.
    -   Tema dark pada layout menggunakan inline CSS di `resources/views/layouts/app.blade.php` — ubah bila butuh skin terang.

    ## Kontribusi

    1. Fork repo
    2. Buat branch fitur: `git checkout -b feature/your-feature`
    3. Commit perubahan dan push
    4. Buka Pull Request

    ## Lisensi

    Proyek ini mengikuti lisensi MIT (lihat file LICENSE jika ada). Laravel framework sendiri berlisensi MIT: https://opensource.org/licenses/MIT
