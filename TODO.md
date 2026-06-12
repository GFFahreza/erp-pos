# TODO - Manajemen Karyawan & Cashier

## Done
- [x] Buat UI `resources/views/cashier/index.blade.php` selaras dengan POS (multi-store + offline queue + auto-sync hooks).
- [x] Tambahkan route placeholder di `erp-pos/routes/web.php` untuk `/cashier`, `/stores`, dan `/pos/sync`.
- [x] Buat view manajemen karyawan `resources/views/Manajemen Karyawan/index.blade.php` dengan tema selaras UI POS (table + modal create/edit, filter/search, HRIS future).

## Next (Backend)
- [ ] Buat controller/endpoint asli untuk `/stores`.
- [ ] Implementasikan autentikasi/validasi PIN kasir di backend.
- [ ] Implementasikan transaksi cashier + struk.
- [ ] Implementasikan queue offline di database + idempotency.
- [ ] Implementasikan real-time analytics.
- [ ] Implementasikan endpoint & backend untuk manajemen karyawan (CRUD), dan HRIS integration (future).

