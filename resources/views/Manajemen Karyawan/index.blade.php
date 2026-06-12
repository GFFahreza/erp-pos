<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ERP POS - Manajemen Karyawan</title>

    <script>
        try {
            document.documentElement.dataset.theme = localStorage.getItem('erp-pos-theme') || 'dark';
        } catch (error) {
            document.documentElement.dataset.theme = 'dark';
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html[data-theme="light"] body {
            background: #f6f8fb !important;
            color: #0f172a !important;
        }

        html[data-theme="light"] body > .absolute {
            opacity: 0.45;
        }

        html[data-theme="light"] .bg-white\/5 {
            background-color: rgba(255, 255, 255, 0.94) !important;
        }

        html[data-theme="light"] .bg-white\/10 {
            background-color: #f1f5f9 !important;
        }

        html[data-theme="light"] .bg-slate-950\/70,
        html[data-theme="light"] .bg-slate-950\/60,
        html[data-theme="light"] .bg-slate-950\/50 {
            background-color: #ffffff !important;
        }

        html[data-theme="light"] .bg-slate-900\/80,
        html[data-theme="light"] .bg-slate-900\/90 {
            background-color: #f8fafc !important;
        }

        html[data-theme="light"] .border-white\/10 {
            border-color: #dbe3ea !important;
        }

        html[data-theme="light"] .border-x {
            border-color: #dbe3ea !important;
        }

        html[data-theme="light"] .divide-white\/5 > :not([hidden]) ~ :not([hidden]) {
            border-color: #e2e8f0 !important;
        }

        html[data-theme="light"] .text-white {
            color: #0f172a !important;
        }

        html[data-theme="light"] .text-slate-200,
        html[data-theme="light"] .text-slate-300,
        html[data-theme="light"] .text-slate-400,
        html[data-theme="light"] .text-slate-500 {
            color: #64748b !important;
        }

        html[data-theme="light"] .text-slate-200 {
            color: #334155 !important;
        }

        html[data-theme="light"] .text-rose-300 {
            color: #e11d48 !important;
        }

        html[data-theme="light"] .text-amber-300 {
            color: #b45309 !important;
        }

        html[data-theme="light"] .text-cyan-300\/80,
        html[data-theme="light"] .text-cyan-300\/70,
        html[data-theme="light"] .text-cyan-200 {
            color: #0e7490 !important;
        }

        html[data-theme="light"] .text-emerald-300 {
            color: #047857 !important;
        }

        html[data-theme="light"] input,
        html[data-theme="light"] select,
        html[data-theme="light"] textarea {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        html[data-theme="light"] input::placeholder,
        html[data-theme="light"] textarea::placeholder {
            color: #94a3b8 !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
<div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-r from-emerald-500/30 via-cyan-500/20 to-transparent blur-3xl"></div>

<main class="relative mx-auto flex min-h-screen max-w-7xl flex-col gap-6 px-4 py-6 lg:px-8">

    <section class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-black/30 backdrop-blur-xl">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.35em] text-cyan-300/80">Manajemen Karyawan</p>
                <h1 class="mt-2 text-3xl font-semibold text-white md:text-4xl">Kelola pegawai kasir</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-300">Tambahkan karyawan, atur role, dan siapkan integrasi HRIS (future).</p>
            </div>

            <div class="flex items-center gap-3">
                <button id="themeToggle" type="button" class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-slate-950/70 px-4 py-2 text-sm font-medium text-slate-300 transition hover:border-cyan-400/50 hover:text-white" aria-pressed="false">
                    <span id="themeIcon" aria-hidden="true" class="inline-flex h-4 w-4"></span>
                    <span id="themeLabel">Mode terang</span>
                </button>
            </div>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-3">
            <div>
                <label class="text-sm text-slate-300" for="employeeSearch">Cari karyawan</label>
                <input id="employeeSearch" type="text" placeholder="Nama, email, atau NIK" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
            </div>

            <div>
                <label class="text-sm text-slate-300" for="roleFilter">Role</label>
                <select id="roleFilter" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none focus:border-cyan-400">
                    <option value="">Semua role</option>
                    <option value="cashier">Cashier</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button id="addEmployeeButton" type="button" class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-emerald-400 px-4 py-3 font-semibold text-slate-950 transition hover:brightness-110">Tambah</button>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
        <div class="mb-4 flex items-center justify-between gap-4">
            <h2 class="text-lg font-semibold text-white">Daftar Karyawan</h2>
            <span id="employeesMeta" class="text-sm text-slate-400">0 data</span>
        </div>

        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="min-w-full text-left text-sm text-slate-200">
                <thead class="bg-slate-900/90 text-slate-400">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="employeesTable" class="divide-y divide-white/5 bg-slate-950/60"></tbody>
            </table>
        </div>

        <div id="employeesEmpty" class="mt-4 hidden rounded-2xl border border-dashed border-white/10 bg-slate-950/50 px-4 py-10 text-center text-sm text-slate-400">
            Belum ada data karyawan. Klik tombol <b>Tambah</b> untuk mulai.
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur-xl">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">Integrasi HRIS (Future)</h2>
                <p class="mt-1 text-sm text-slate-300">Sinkronisasi data karyawan, role, dan izin secara otomatis dari HRIS.</p>
            </div>
            <div class="text-sm text-slate-400">Status: Coming Soon</div>
        </div>
    </section>
</main>

<!-- Modal Tambah/Edit (simple, client-side only) -->
<div id="employeeModalOverlay" class="fixed inset-0 z-50 hidden bg-black/60"></div>
<div id="employeeModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
    <div class="w-full max-w-xl rounded-3xl border border-white/10 bg-slate-950/90 p-5 backdrop-blur-xl">
        <div class="flex items-center justify-between">
            <h3 id="employeeModalTitle" class="text-lg font-semibold text-white">Tambah Karyawan</h3>
            <button id="employeeModalClose" type="button" class="rounded-full border border-white/10 bg-white/5 px-3 py-2 text-sm text-slate-300 transition hover:text-white">Tutup</button>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="text-sm text-slate-300" for="empName">Nama</label>
                <input id="empName" type="text" placeholder="Nama lengkap" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
            </div>

            <div>
                <label class="text-sm text-slate-300" for="empNIK">NIK</label>
                <input id="empNIK" type="text" placeholder="Nomor identitas" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
            </div>

            <div>
                <label class="text-sm text-slate-300" for="empEmail">Email</label>
                <input id="empEmail" type="email" placeholder="email@contoh.com" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
            </div>

            <div>
                <label class="text-sm text-slate-300" for="empRole">Role</label>
                <select id="empRole" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none focus:border-cyan-400">
                    <option value="cashier">Cashier</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-slate-300" for="empStatus">Status</label>
                <select id="empStatus" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none focus:border-cyan-400">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm text-slate-300" for="empPin">PIN (untuk kasir)</label>
                <input id="empPin" type="password" inputmode="numeric" placeholder="Min 4 digit" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" />
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
            <p id="employeeModalStatus" class="w-full text-sm text-rose-300 sm:w-auto"></p>
            <button id="employeeSaveButton" type="button" class="rounded-2xl bg-gradient-to-r from-emerald-400 to-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:brightness-110">Simpan</button>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const state = {
        employees: [],
        modalMode: 'create',
        activeEmployeeId: null,
        isLoading: false,
    };


    const refs = {
        themeToggle: document.getElementById('themeToggle'),
        themeIcon: document.getElementById('themeIcon'),
        themeLabel: document.getElementById('themeLabel'),

        employeeSearch: document.getElementById('employeeSearch'),
        roleFilter: document.getElementById('roleFilter'),
        addEmployeeButton: document.getElementById('addEmployeeButton'),

        employeesMeta: document.getElementById('employeesMeta'),
        employeesTable: document.getElementById('employeesTable'),
        employeesEmpty: document.getElementById('employeesEmpty'),

        employeeModalOverlay: document.getElementById('employeeModalOverlay'),
        employeeModal: document.getElementById('employeeModal'),
        employeeModalTitle: document.getElementById('employeeModalTitle'),
        employeeModalClose: document.getElementById('employeeModalClose'),

        empName: document.getElementById('empName'),
        empNIK: document.getElementById('empNIK'),
        empEmail: document.getElementById('empEmail'),
        empRole: document.getElementById('empRole'),
        empStatus: document.getElementById('empStatus'),
        empPin: document.getElementById('empPin'),

        employeeModalStatus: document.getElementById('employeeModalStatus'),
        employeeSaveButton: document.getElementById('employeeSaveButton'),
    };

    const themeStorageKey = 'erp-pos-theme';
    const themeIcons = {
        sun: `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2"></path>
                <path d="M12 20v2"></path>
                <path d="m4.93 4.93 1.41 1.41"></path>
                <path d="m17.66 17.66 1.41 1.41"></path>
                <path d="M2 12h2"></path>
                <path d="M20 12h2"></path>
                <path d="m6.34 17.66-1.41 1.41"></path>
                <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
        `,
        moon: `
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <path d="M12 3a6 6 0 0 0 9 7.5A9 9 0 1 1 12 3Z"></path>
            </svg>
        `,
    };

    const applyTheme = (theme) => {
        document.documentElement.dataset.theme = theme;
        refs.themeIcon.innerHTML = theme === 'light' ? themeIcons.moon : themeIcons.sun;
        refs.themeLabel.textContent = theme === 'light' ? 'Mode gelap' : 'Mode terang';
        refs.themeToggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');

        try { localStorage.setItem(themeStorageKey, theme); } catch (e) {}
    };

    const moneySanitize = (v) => String(v ?? '').trim();

    const roleLabel = (role) => {
        if (role === 'admin') return 'Admin';
        if (role === 'manager') return 'Manager';
        return 'Cashier';
    };

    const statusBadge = (status) => {
        if (status === 'inactive') {
            return 'border-rose-400/30 bg-rose-400/10 text-rose-300';
        }
        return 'border-emerald-400/30 bg-emerald-400/10 text-emerald-300';
    };

    const filteredEmployees = () => {
        const q = String(refs.employeeSearch.value || '').toLowerCase();
        const role = refs.roleFilter.value;

        return (state.employees || []).filter((e) => {
            const matchesQ = !q ||
                String(e.name || '').toLowerCase().includes(q) ||
                String(e.email || '').toLowerCase().includes(q) ||
                String(e.nik || '').toLowerCase().includes(q);

            const matchesRole = !role || String(e.role || '') === role;
            return matchesQ && matchesRole;
        });
    };

    const renderEmployees = () => {
        const list = filteredEmployees();

        refs.employeesTable.innerHTML = '';
        if (!list.length) {
            refs.employeesEmpty.classList.remove('hidden');
            refs.employeesMeta.textContent = '0 data';
            return;
        }

        refs.employeesEmpty.classList.add('hidden');
        refs.employeesMeta.textContent = `${list.length} data`;

        refs.employeesTable.innerHTML = list.map((e) => {
            return `
                <tr>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-white">${e.name}</div>
                    </td>
                    <td class="px-4 py-3 text-slate-300">${e.nik}</td>
                    <td class="px-4 py-3 text-slate-300">${e.email}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-200">${roleLabel(e.role)}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold ${statusBadge(e.status)}">${e.status === 'inactive' ? 'Nonaktif' : 'Aktif'}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button type="button" data-action="edit" data-id="${e.id}" class="text-xs text-cyan-300 hover:text-cyan-200">Edit</button>
                    </td>
                </tr>
            `;
        }).join('');

        refs.employeesTable.querySelectorAll('[data-action="edit"]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const emp = state.employees.find((x) => String(x.id) === String(id));
                if (!emp) return;
                openModal('edit', emp);
            });
        });
    };

    const openModal = (mode, employee = null) => {
        refs.employeeModalStatus.textContent = '';
        refs.employeeModalOverlay.classList.remove('hidden');
        refs.employeeModal.classList.remove('hidden');

        refs.employeeModalTitle.textContent = mode === 'edit' ? 'Edit Karyawan' : 'Tambah Karyawan';
        refs.employeeModal.dataset.mode = mode;

        state.modalMode = mode;
        state.activeEmployeeId = employee ? employee.id : null;

        refs.empName.value = employee?.name || '';
        refs.empNIK.value = employee?.nik || '';
        refs.empEmail.value = employee?.email || '';
        refs.empRole.value = employee?.role || 'cashier';
        refs.empStatus.value = employee?.status || 'active';
        refs.empPin.value = '';
    };

    const closeModal = () => {
        refs.employeeModalOverlay.classList.add('hidden');
        refs.employeeModal.classList.add('hidden');
    };

    const sanitizeText = (v) => String(v ?? '').trim().slice(0, 120);

    const loadEmployeesFromServer = async (q = '', role = '') => {
        const params = new URLSearchParams();
        if (q) params.set('q', q);
        if (role) params.set('role', role);

        const url = '/manajemen-karyawan/list' + (params.toString() ? ('?' + params.toString()) : '');
        const res = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const payload = await res.json().catch(() => ({}));
        if (!res.ok) {
            const msg = payload?.message || (payload?.errors ? Object.values(payload.errors).flat()[0] : null);
            throw new Error(msg || 'Gagal mengambil data karyawan.');
        }

        state.employees = payload.data || [];
        renderEmployees();
    };

    const saveEmployee = async () => {
        refs.employeeModalStatus.textContent = '';


        const name = sanitizeText(refs.empName.value);
        const nik = sanitizeText(refs.empNIK.value);
        const email = sanitizeText(refs.empEmail.value);
        const role = refs.empRole.value;
        const status = refs.empStatus.value;
        const pin = String(refs.empPin.value || '').trim();

        if (!name) return refs.employeeModalStatus.textContent = 'Nama wajib diisi.';
        if (!nik) return refs.employeeModalStatus.textContent = 'NIK wajib diisi.';
        if (!email || !email.includes('@')) return refs.employeeModalStatus.textContent = 'Email tidak valid.';

        // PIN minimal 4 digit (UI validation)
        if (!pin || pin.length < 4) {
            return refs.employeeModalStatus.textContent = 'PIN minimal 4 digit.';
        }

        try {
            refs.employeeSaveButton.disabled = true;
            refs.employeeModalStatus.textContent = 'Menyimpan...';

            const basePayload = {
                name,
                nik,
                email,
                role,
                status,
                pin,
            };

            if (state.modalMode === 'edit') {
                const id = state.activeEmployeeId;
                const res = await fetch('/manajemen-karyawan/' + id, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(basePayload),
                });

                const payload = await res.json().catch(() => ({}));

                if (!res.ok) {
                    const msg = payload?.message || (payload?.errors ? Object.values(payload.errors).flat()[0] : null);
                    throw new Error(msg || 'Gagal update karyawan.');
                }
            } else {
                const res = await fetch('/manajemen-karyawan', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(basePayload),
                });

                const payload = await res.json().catch(() => ({}));

                if (!res.ok) {
                    const msg = payload?.message || (payload?.errors ? Object.values(payload.errors).flat()[0] : null);
                    throw new Error(msg || 'Gagal simpan karyawan.');
                }
            }

            closeModal();
            await loadEmployeesFromServer();
        } catch (e) {
            refs.employeeModalStatus.textContent = e?.message || 'Gagal menyimpan.';
        } finally {
            refs.employeeSaveButton.disabled = false;
        }
    };

    // Events
    refs.themeToggle.addEventListener('click', () => {
        const currentTheme = document.documentElement.dataset.theme === 'light' ? 'light' : 'dark';
        applyTheme(currentTheme === 'light' ? 'dark' : 'light');
    });

    refs.employeeSearch.addEventListener('input', renderEmployees);
    refs.roleFilter.addEventListener('change', renderEmployees);

    refs.addEmployeeButton.addEventListener('click', () => openModal('create'));

    refs.employeeModalClose.addEventListener('click', closeModal);
    refs.employeeModalOverlay.addEventListener('click', closeModal);

    refs.employeeSaveButton.addEventListener('click', saveEmployee);

    // Init
    applyTheme(document.documentElement.dataset.theme === 'light' ? 'light' : 'dark');

    // Load from backend
    const initialQ = (refs.employeeSearch?.value || '').trim();
    const initialRole = refs.roleFilter?.value || '';
    loadEmployeesFromServer(initialQ, initialRole).catch(() => {
        // fallback: show empty state if server fails
        state.employees = [];
        renderEmployees();
    });
</script>
</body>
</html>

