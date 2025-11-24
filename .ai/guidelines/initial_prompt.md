This is an ERP project.

Set `/.ai/guidelines/GEMINI.md` as default guidelines.

The backend user uses `User` model.

There are multiple companies, where each company have multiple branches.

Each company has their own unique products. The product can be connected to multiple branches. The products within each branch can have different prices. The product also have multiple variants, with default variant name of "Original".

Each company has users which is stored into `Admin` model. `Admin` model is authenticable.

Each company has clients. Each client has many invoices.

Please create base payment method of "Cash", "Transfer BCA", "Transfer BRI", and "QRIS". Use `PaymentMethod` model and create the seeder.

Within an invoice there are products and promotions. The product can be added from company's branch products, or from a custom product created on the go when inserting a new invoice. In the invoice there are also a due date and paid date. Each invoice can have multiple payments.

For the backend template use tabler.io. Use laravel logo as the project's logo (temporarily).
