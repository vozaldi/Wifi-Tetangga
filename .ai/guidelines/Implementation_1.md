# ERP System Implementation Plan
## Goal Description
Implement a multi-company ERP system backend with branch management, product variants, client invoicing, and payment tracking. The system will use Tabler for the UI and `yajra/laravel-datatables` for data presentation. It includes dynamic settings, user groups, and menu management.
## User Review Required
> [!IMPORTANT]
> **User Model Usage**: Confirmed: `Admin` model will be used for Company-level employees. The standard `User` model is reserved for other purposes (e.g., Super Admin).
## Proposed Changes
### Dependencies
#### [NEW] [Yajra DataTables](https://github.com/yajra/laravel-datatables)
- Install `yajra/laravel-datatables` to handle server-side rendering of tables.
- Configure for Bootstrap 5 (Tabler compatible).
#### [NEW] [Tablar](https://github.com/takielias/tablar)
- Install `takielias/tablar` to provide the Tabler dashboard theme and assets.
### Database & Models
#### [NEW] Companies & Branches
- `Company` model & migration.
- `Branch` model & migration (belongs to Company).
#### [NEW] Authentication & Groups (Company Level)
- `Admin` model & migration (belongs to Company, Authenticatable).
- `Group` model & migration.
    - Seeder: "Admin", "Finance".
- `admin_groups` pivot table.
    - Columns: `admin_id`, `group_id`, `company_id`, `branch_id`.
- Configure `auth.php` guards for `admin`.
#### [NEW] Menus
- `Menu` model & migration.
    - Attributes: `name`, `icon`, `order`, `url`, `parent_id`.
    - Seeder Structure:
        - "Dashboard"
        - "Cabang"
        - "Master Data" (Parent)
            - "Produk"
            - "Varian"
        - "Produk" (Parent)
            - "Produk per Cabang"
        - "Invoice"
        - "User"
        - "Pengaturan"
- `group_menus` pivot table.
#### [NEW] Settings
- `Setting` model & migration.
    - Attributes: `key`, `value`, `type` ('global', 'company'), `description`.
- `company_settings` pivot table (for company-specific overrides or values).
#### [NEW] Products & Variants
- `Product` model & migration (belongs to Company).
- `ProductVariant` model & migration (belongs to Product, Company, Branch).
    - Attributes: `name`, `price`, `company_id`, `branch_id`.
- `BranchVariant` model & migration.
    - Links `Branch` and `ProductVariant`.
#### [NEW] Clients & Invoices
- `Client` model & migration (belongs to Company, Branch).
    - *Note*: Added `branch_id` for faster querying/scoping.
- `Invoice` model & migration (belongs to Client, Company, Branch).
- `InvoiceItem` model & migration.
- `PaymentMethod` model & migration.
    - Seeder: "Cash", "Transfer BCA", "Transfer BRI", "QRIS".
- `Payment` model & migration (belongs to Invoice, PaymentMethod).
### Logic & Features
- **Invoice Logic**:
    - Calculate totals.
    - Handle "Custom Product" vs "Branch Product" insertion.
    - Track `due_date` and `paid_date`.
- **Payment Logic**:
    - Support multiple payments per invoice.
- **Menu Logic**:
    - Middleware/Provider to share `menus` with views based on authenticated Admin's group.
## Verification Plan
### Manual Verification
- **Tabler UI**: Verify the dashboard loads with the Laravel logo.
- **Menus**: Verify the nested menu structure.
- **DataTables**: Verify that lists are rendered using DataTables.
- **Database**: Verify seeders populate PaymentMethods, Groups, and Menus.