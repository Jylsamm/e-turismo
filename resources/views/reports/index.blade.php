<x-app-layout>
    @push('head')
    <style>
        .admin-card-hover {
            transition: all 0.3s ease-in-out !important;
        }
        .admin-card-hover:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1) !important;
            border-color: #bbf7d0 !important;
        }

        /* ── Modal ──────────────────────────────────────────────────── */
        #report-modal-backdrop {
            display: none;
            position: fixed; inset: 0; z-index: 50;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(3px);
            align-items: flex-start;
            justify-content: center;
            padding: 2rem 1rem;
            overflow-y: auto;
        }
        #report-modal-backdrop.open { display: flex; }
        #report-modal {
            background: #fff;
            border-radius: 1rem;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 25px 60px -10px rgba(0,0,0,0.35);
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }
        #report-modal-body {
            overflow-y: auto;
            flex: 1;
            padding: 1.25rem 1.5rem;
        }
        #report-modal-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            gap: 0.75rem;
            color: #4b5563;
        }
        .modal-spinner-ring {
            width: 48px; height: 48px;
            border: 4px solid #d1fae5;
            border-top-color: #059669;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Print styles ───────────────────────────────────────────── */
        @media print {
            body * { visibility: hidden !important; }
            #visitor-record-preview,
            #visitor-record-preview * { visibility: visible !important; }
            #visitor-record-preview {
                position: fixed !important;
                top: 0; left: 0;
                width: 100%;
                font-size: 9pt;
            }
            #report-modal-backdrop { display: none !important; }
        }
    </style>
    @endpush

    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">📊 Reports Dashboard</h1>
    </x-slot>

    <div class="pb-8 pt-0 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Filter Form --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow p-6 admin-card-hover">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Filter &amp; Preview</h2>
            <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Destination</label>
                    <select id="filter-destination" name="destination_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                        <option value="">All Destinations</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" {{ $filters['destination_id'] == $dest->id ? 'selected' : '' }}>
                                {{ $dest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Date From</label>
                    <input id="filter-date-from" type="date" name="date_from" value="{{ $filters['date_from'] }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1 uppercase">Date To</label>
                    <input id="filter-date-to" type="date" name="date_to" value="{{ $filters['date_to'] }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-400 outline-none">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-brand-700 hover:bg-brand-800 text-white rounded-lg py-2.5 text-sm font-medium transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @php
            $cards = [
                ['label'=>'Total Bookings','value'=>$stats['total_bookings'],'color'=>'brand'],
                ['label'=>'Confirmed','value'=>$stats['confirmed'],'color'=>'green'],
                ['label'=>'Declined','value'=>$stats['declined'],'color'=>'red'],
                ['label'=>'Pending','value'=>$stats['pending'],'color'=>'amber'],
                ['label'=>'Actual Visitors','value'=>$stats['total_visitors'],'color'=>'blue'],
            ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow p-5 border-l-4 border-{{ $card['color'] }}-500 border-t border-r border-b border-gray-200 admin-card-hover">
                <p class="text-xs text-gray-500 uppercase font-medium">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Generate Button --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow p-6 flex flex-col sm:flex-row gap-4 items-end admin-card-hover">
            <div class="flex-1">
                <p class="text-sm text-gray-600 font-medium mb-1">Tourism Attraction Visitor Record</p>
                <p class="text-xs text-gray-400">Generate a structured daily visitor breakdown by residence type and gender for the selected destination and month.</p>
            </div>
            <div class="flex items-end shrink-0">
                <button id="btn-generate-report" type="button"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-6 py-3 text-sm font-semibold shadow-sm transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate
                </button>
            </div>
        </div>

    </div>

    {{-- ─────────────── Report Preview Modal ─────────────── --}}
    <div id="report-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div id="report-modal">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 shrink-0">
                <h3 id="modal-title" class="text-base font-bold text-gray-800">Tourism Attraction Visitor Record</h3>
                <div class="flex items-center gap-2">
                    {{-- Export DOCX (inside modal only) --}}
                    <a id="btn-export-docx" href="#"
                        class="hidden inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export DOCX
                    </a>
                    {{-- Print (inside modal only) --}}
                    <button id="btn-print" type="button"
                        class="hidden inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print
                    </button>
                    {{-- Close --}}
                    <button id="btn-modal-close" type="button"
                        class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div id="report-modal-body">
                <div id="report-modal-spinner">
                    <div class="modal-spinner-ring"></div>
                    <span class="text-sm">Generating report…</span>
                </div>
                <div id="report-modal-content" class="hidden"></div>
                <div id="report-modal-error" class="hidden text-red-600 text-sm p-4 bg-red-50 rounded-lg"></div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const backdrop   = document.getElementById('report-modal-backdrop');
        const spinner    = document.getElementById('report-modal-spinner');
        const content    = document.getElementById('report-modal-content');
        const errorBox   = document.getElementById('report-modal-error');
        const btnExport  = document.getElementById('btn-export-docx');
        const btnPrint   = document.getElementById('btn-print');
        const btnClose   = document.getElementById('btn-modal-close');
        const btnGenerate = document.getElementById('btn-generate-report');

        // ── Helpers ───────────────────────────────────────────────────
        function openModal()  { backdrop.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal() { backdrop.classList.remove('open'); document.body.style.overflow = ''; }

        function showSpinner() {
            spinner.classList.remove('hidden');
            content.classList.add('hidden');
            errorBox.classList.add('hidden');
            btnExport.classList.add('hidden');
            btnPrint.classList.add('hidden');
        }

        function showContent(html, exportUrl) {
            spinner.classList.add('hidden');
            errorBox.classList.add('hidden');
            content.innerHTML = html;
            content.classList.remove('hidden');
            btnExport.href = exportUrl;
            btnExport.classList.remove('hidden');
            btnPrint.classList.remove('hidden');
        }

        function showError(msg) {
            spinner.classList.add('hidden');
            content.classList.add('hidden');
            errorBox.textContent = msg;
            errorBox.classList.remove('hidden');
        }

        // ── Generate (fetch HTML preview) ─────────────────────────────
        btnGenerate.addEventListener('click', function () {
            const destId   = document.getElementById('filter-destination')?.value ?? '';
            const dateFrom = document.getElementById('filter-date-from')?.value ?? '';
            const dateTo   = document.getElementById('filter-date-to')?.value ?? '';

            if (!dateFrom) {
                alert('Please select a Date From before generating.');
                return;
            }

            openModal();
            showSpinner();

            const previewUrl = '{{ route('reports.generate-visitor-record') }}';
            const exportUrl  = '{{ route('reports.export-visitor-record') }}';

            const params = new URLSearchParams();
            if (destId)   params.set('destination_id', destId);
            if (dateFrom) params.set('date_from',      dateFrom);
            if (dateTo)   params.set('date_to',        dateTo);

            const fullExportUrl = exportUrl + '?' + params.toString();

            fetch(previewUrl + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (!response.ok) throw new Error('Server returned ' + response.status);
                return response.text();
            })
            .then(html => {
                showContent(html, fullExportUrl);
            })
            .catch(err => {
                showError('Failed to generate report: ' + err.message);
            });
        });

        // ── Close modal ───────────────────────────────────────────────
        btnClose.addEventListener('click', closeModal);
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        // ── Print ─────────────────────────────────────────────────────
        btnPrint.addEventListener('click', function () {
            window.print();
        });
    })();
    </script>
    @endpush

</x-app-layout>
