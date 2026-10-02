<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $totalAmount = isset($details) ? $details->sum('amount') : $detail->amount;
        $ticketNumber = $detail->ticket_no ?: ('SB-' . date('y') . '-' . str_pad($detail->id, 6, '0', STR_PAD_LEFT));
        $seatList = isset($details) ? $details->pluck('seat.name')->implode(', ') : ($detail->seat->name ?? 'N/A');
        $seatCount = isset($details) ? $details->count() : 1;
    @endphp
    <title>SwiftBus E-Ticket #{{ $ticketNumber }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        :root {
            --primary: #a2e043;
            --primary-hover: #b4f056;
            --dark: #0b0d11;
            --card-bg: #14171d;
            --border: rgba(255, 255, 255, 0.08);
            --text-dark: #111827;
            --muted-dark: #6b7280;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'DM Sans', sans-serif; 
            background: #0b0d11; 
            padding: 40px 20px 80px;
            color: #ffffff;
            min-height: 100vh;
        }

        /* ─── DEDICATED DOWNLOAD TICKET PDF SECTION ─── */
        .download-ticket-section {
            max-width: 820px;
            margin: 0 auto 30px;
            background: #14171d;
            border: 1px solid rgba(162, 224, 67, 0.25);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(162, 224, 67, 0.05);
            border-radius: 18px;
            padding: 24px 28px;
        }

        .download-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .download-info-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .ticket-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(46, 204, 113, 0.12);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.25);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: fit-content;
        }

        .download-title {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .download-title i {
            color: var(--primary);
        }

        .download-subtext {
            font-size: 13px;
            color: #9ca3af;
        }

        .download-subtext strong {
            color: #ffffff;
        }

        .download-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-download-pdf {
            background: var(--primary);
            color: #0b0d11;
            padding: 12px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 800;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 16px rgba(162, 224, 67, 0.25);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-download-pdf:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(162, 224, 67, 0.35);
        }

        .btn-outline-action {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            padding: 12px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.2s ease;
        }

        .btn-outline-action:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        /* ─── TICKET CONTAINER ─── */
        .ticket-container {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            position: relative;
            color: var(--text-dark);
        }

        /* Ticket Header */
        .ticket-header {
            background: #0f120e;
            padding: 32px 40px;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary);
        }

        .logo { 
            font-family: 'Poppins', sans-serif;
            font-size: 24px; 
            font-weight: 800; 
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo i { color: var(--primary); }
        .logo span { color: var(--primary); }

        .pnr-box { text-align: right; }
        .pnr-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #9ca3af; }
        .pnr-value { font-size: 22px; font-weight: 800; color: var(--primary); font-family: 'Poppins', sans-serif; }

        /* Ticket Body */
        .ticket-body { padding: 36px 40px; position: relative; background: #ffffff; }

        .route-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 34px;
            padding-bottom: 26px;
            border-bottom: 1px dashed #d1d5db;
        }

        .city-box .label { font-size: 11px; font-weight: 700; color: var(--muted-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
        .city-box .val { font-size: 28px; font-weight: 800; color: #111827; }

        .route-path {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
            padding: 0 24px;
        }
        .route-line {
            width: 100%;
            height: 2px;
            background: repeating-linear-gradient(to right, #9ca3af 0, #9ca3af 6px, transparent 6px, transparent 10px);
            position: relative;
        }
        .bus-icon { font-size: 20px; color: #0b0d11; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 30px;
        }

        .info-item .label { font-size: 11px; font-weight: 700; color: var(--muted-dark); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-item .val { font-size: 16px; font-weight: 700; color: #111827; }
        .info-item .val-highlight { font-size: 20px; font-weight: 800; color: #0b0d11; }

        /* Passenger Section */
        .passenger-section {
            background: #f9fafb;
            padding: 24px 40px;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .passenger-title { font-size: 11px; color: var(--muted-dark); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 4px; }
        .passenger-name { font-size: 18px; font-weight: 800; color: #111827; }
        .passenger-email { font-size: 13px; color: var(--muted-dark); }

        .verification-badge {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Barcode simulation strip */
        .ticket-stub {
            background: #ffffff;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px dashed #d1d5db;
        }

        .barcode-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .barcode-bars {
            height: 36px;
            width: 220px;
            background: repeating-linear-gradient(
                90deg,
                #111827 0px,
                #111827 2px,
                transparent 2px,
                transparent 4px,
                #111827 4px,
                #111827 7px,
                transparent 7px,
                transparent 9px,
                #111827 9px,
                #111827 12px,
                transparent 12px,
                transparent 14px
            );
        }

        .barcode-text {
            font-family: monospace;
            font-size: 11px;
            color: var(--muted-dark);
            letter-spacing: 2px;
        }

        .footer-note {
            padding: 16px 40px;
            font-size: 11px;
            color: var(--muted-dark);
            text-align: center;
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }

        /* Print Overrides */
        @media print {
            body { background: #ffffff !important; padding: 0 !important; color: #000000 !important; }
            .no-print, .download-ticket-section { display: none !important; }
            .ticket-container { box-shadow: none !important; border: 1px solid #d1d5db !important; margin: 0 auto !important; max-width: 100% !important; }
        }

        @media (max-width: 680px) {
            .download-header { flex-direction: column; align-items: flex-start; }
            .download-actions { width: 100%; }
            .btn-download-pdf, .btn-outline-action { width: 100%; justify-content: center; }
            .route-row { flex-direction: column; gap: 16px; text-align: center; }
            .info-grid { grid-template-columns: 1fr; }
            .ticket-stub { flex-direction: column; gap: 16px; text-align: center; }
            .ticket-header { padding: 24px; }
            .ticket-body { padding: 24px; }
        }
    </style>
</head>
<body>

    {{-- ─── DEDICATED DOWNLOAD TICKET PDF SECTION ─── --}}
    <div class="download-ticket-section">
        <div class="download-header">
            <div class="download-info-wrap">
                <span class="ticket-status-pill"><i class="fa-solid fa-circle-check"></i> E-Ticket Confirmed</span>
                <div class="download-title">
                    <i class="fa-solid fa-ticket"></i> Download Your Ticket
                </div>
                <div class="download-subtext">
                    Ticket Ref: <strong>#{{ $ticketNumber }}</strong> • Coach: <strong>#{{ $detail->seat->bus->coach_no }}</strong> • Seats: <strong>{{ $seatList }}</strong>
                </div>
            </div>

            <div class="download-actions">
                <button type="button" id="btnDownloadPdf" class="btn-download-pdf" onclick="downloadTicketPDF()">
                    <i class="fa-solid fa-file-pdf"></i> Download Ticket (PDF)
                </button>
                <button type="button" class="btn-outline-action" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <a href="{{ route('booking.details') }}" class="btn-outline-action">
                    <i class="fa-solid fa-list-check"></i> My Bookings
                </a>
                <a href="{{ route('frontend.home') }}" class="btn-outline-action">
                    <i class="fa-solid fa-house"></i> Home
                </a>
            </div>
        </div>
    </div>

    {{-- ─── E-TICKET BOARDING PASS CARD ─── --}}
    <div class="ticket-container" id="ticket">
        <div class="ticket-header">
            <div class="logo">
                <i class="fa-solid fa-bus"></i> Swift<span>Bus</span>
            </div>
            <div class="pnr-box">
                <div class="pnr-label">Ticket Reference</div>
                <div class="pnr-value">{{ $ticketNumber }}</div>
            </div>
        </div>

        <div class="ticket-body">
            <div class="route-row">
                <div class="city-box">
                    <div class="label">Departure From</div>
                    <div class="val">{{ $trip->location_from ?? 'Origin' }}</div>
                </div>
                <div class="route-path">
                    <i class="fa-solid fa-bus bus-icon"></i>
                    <div class="route-line"></div>
                </div>
                <div class="city-box" style="text-align: right;">
                    <div class="label">Arrival Destination</div>
                    <div class="val">{{ $trip->location_to ?? 'Destination' }}</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Journey Date</div>
                    <div class="val">{{ date('D, M d, Y', strtotime($detail->date)) }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Departure Time</div>
                    <div class="val">{{ $detail->time }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Bus Operator</div>
                    <div class="val">{{ $detail->seat->bus->bus_name }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Coach / Course No.</div>
                    <div class="val">#{{ $detail->seat->bus->coach_no }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Seat Number(s)</div>
                    <div class="val" style="color: #059669; font-weight: 800;">{{ $seatList }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Total Paid</div>
                    <div class="val-highlight">৳{{ number_format($totalAmount, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="passenger-section">
            <div>
                <div class="passenger-title">Lead Passenger</div>
                <div class="passenger-name">{{ $detail->user->name }}</div>
                <div class="passenger-email"><i class="fa-regular fa-envelope me-1"></i> {{ $detail->user->email }}</div>
            </div>
            <div style="text-align: right;">
                <div class="verification-badge">
                    <i class="fa-solid fa-check"></i> PAID & CONFIRMED
                </div>
                <div style="font-size: 11px; color: var(--muted-dark); margin-top: 6px;">Issued on: {{ date('M d, Y • h:i A') }}</div>
            </div>
        </div>

        <div class="ticket-stub">
            <div class="barcode-wrap">
                <div class="barcode-bars"></div>
                <div class="barcode-text">*{{ $ticketNumber }}*</div>
            </div>
            <div style="font-size: 12px; color: var(--muted-dark); text-align: right;">
                <div>Show this E-Ticket on mobile or printed copy at boarding counter.</div>
                <div style="font-weight: 700; color: #111827; margin-top: 2px;">Helpline: {{ setting('helpline', '16374') }} (24/7 Support)</div>
            </div>
        </div>

        <div class="footer-note">
            Please arrive at the counter 20 minutes prior to departure. For ticket cancellations or schedule queries, contact {{ setting('site_name', 'SwiftBus') }} support before travel date.
        </div>
    </div>

    <script>
        function downloadTicketPDF() {
            const btn = document.getElementById('btnDownloadPdf');
            const originalHtml = btn.innerHTML;
            
            // Set loading state
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating PDF...';
            btn.style.pointerEvents = 'none';

            const element = document.getElementById('ticket');
            const filename = 'SwiftBus-Ticket-{{ $ticketNumber }}.pdf';

            const opt = {
                margin:       [10, 10, 10, 10],
                filename:     filename,
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, logging: false },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = originalHtml;
                btn.style.pointerEvents = 'auto';
            }).catch(function(err) {
                console.error('PDF Generation failed:', err);
                btn.innerHTML = originalHtml;
                btn.style.pointerEvents = 'auto';
                // Fallback to print dialog
                window.print();
            });
        }
    </script>
</body>
</html>
