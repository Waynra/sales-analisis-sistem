# Sales Analytics System

A Laravel-based web application for managing and analyzing sales data across multiple e-commerce platforms (Shopee, Tokopedia, and TikTok Shop).

## Features

-   📊 Sales Dashboard with visual analytics
-   📥 Import sales data from multiple sources:
    -   Direct import from Shopee, Tokopedia, and TikTok Shop files
    -   Custom template import support
-   📤 Export data in multiple formats:
    -   Excel (.xlsx)
    -   CSV
    -   PDF
-   📱 Responsive interface with Bootstrap 5
-   📈 Monthly sales tracking
-   🔄 Automatic platform detection for imports

## Requirements

-   PHP >= 8.0
-   Laravel 10.x
-   Composer
-   MySQL/MariaDB

## Installation

1. Clone the repository:

```bash
git clone [repository-url]
cd sales-analytics-system
```

2. Install dependencies:

```bash
composer install
```

3. Set up environment:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_analytics
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Run migrations:

```bash
php artisan migrate
```

6. Start the development server:

```bash
php artisan serve
```

## Usage

### Importing Sales Data

1. **Platform-Specific Import**

    - Access the sales page
    - Use the "Import File Resmi" section
    - Upload files directly from Shopee, Tokopedia, or TikTok Shop
    - System will automatically detect the platform and map the data

2. **Template Import**
    - Use the "Import File Template Sistem" section
    - Required columns:
        - platform
        - date
        - product_name
        - quantity
        - price
        - ads_cost
        - affiliate_fee
        - total

### Exporting Data

The system supports three export formats:

-   Excel: Click "Export Excel" button
-   CSV: Click "Export CSV" button
-   PDF: Click "Export PDF" button

### Dashboard

Access the dashboard to view:

-   Monthly total sales
-   Sales trend chart
-   Daily sales analytics

## Data Structure

Sales data includes:

-   Platform name
-   Sale date
-   Product name
-   Quantity
-   Price
-   Advertising costs
-   Affiliate fees
-   Total amount

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
