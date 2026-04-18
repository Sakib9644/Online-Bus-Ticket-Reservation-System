<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwiftBus E-Ticket | Course #{{ $detail->seat->bus->coach_no }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        :root {
            --primary: #a2e043;
            --dark: #0f120e;
            --slate: #2d342c;
            --text: #1a1e19;
            --muted: #718096;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'DM Sans', sans-serif; 
            background: #f4f7f6; 
            padding: 40px 20px;
            color: var(--text);
        }

        .no-print {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-print {
            background: var(--dark);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
        }
        .btn-print:hover { opacity: 0.9; }

        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Ticket Header */
        .ticket-header {
            background: var(--dark);
            padding: 40px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo { font-size: 24px; font-weight: 800; letter-spacing: -1px; }
        .logo span { color: var(--primary); }

        .pnr-box { text-align: right; }
        .pnr-label { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.6; }
        .pnr-value { font-size: 24px; font-weight: 800; color: var(--primary); }

        /* Ticket Body */
        .ticket-body { padding: 40px; position: relative; }

        .route-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px dashed #e2e8f0;
        }

        .city-box .label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 8px; }
        .city-box .val { font-size: 28px; font-weight: 800; }

        .plane-icon { font-size: 24px; color: var(--primary); margin-top: 25px; opacity: 0.3; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .info-item .label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
        .info-item .val { font-size: 16px; font-weight: 700; }

        /* Stub Section */
        .passenger-section {
            background: #f8fafc;
            padding: 30px 40px;
            border-top: 1px solid #e2e8f0;
        }

        .passenger-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            background: #def7ec;
            color: #03543f;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .footer-note {
            padding: 20px 40px;
            font-size: 12px;
            color: var(--muted);
            text-align: center;
            background: #fff;
        }

        /* Print Overrides */
        @media print {
            body { background: #fff; padding: 0; }
            .no-print { display: none; }
            .ticket-container { box-shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <a href="{{ route('frontend.home') }}" style="color: var(--dark); text-decoration: none; font-weight: 700;"><i class="fa fa-arrow-left"></i> Back to Home</a>
        <button class="btn-print" onclick="window.print()">
            <i class="fa fa-download"></i> DOWNLOAD E-TICKET
        </button>
    </div>

    <div class="ticket-container" id="ticket">
        <div class="ticket-header">
            <div class="logo">Swift<span>Bus</span></div>
            <div class="pnr-box">
                <div class="pnr-label">Course Number</div>
                <div class="pnr-value">{{ $detail->seat->bus->coach_no }}</div>
            </div>
        </div>

        <div class="ticket-body">
            <div class="route-row">
                <div class="city-box">
                    <div class="label">Departure From</div>
                    <div class="val">{{ $trip->location_from ?? 'N/A' }}</div>
                </div>
                <i class="fa fa-bus plane-icon"></i>
                <div class="city-box" style="text-align: right;">
                    <div class="label">Arrival To</div>
                    <div class="val">{{ $trip->location_to ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Date</div>
                    <div class="val">{{ date('D, M d Y', strtotime($detail->date)) }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Departure Time</div>
                    <div class="val">{{ $detail->time }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Bus Name</div>
                    <div class="val">{{ $detail->seat->bus->bus_name }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Seat Number(s)</div>
                    <div class="val">
                        @if(isset($details))
                            @foreach($details as $d)
                                {{ $d->seat->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        @else
                            {{ $detail->seat->name }}
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Total Amount</div>
                    <div class="val">৳{{ $detail->amount }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Course Number</div>
                    <div class="val">{{ $detail->seat->bus->coach_no }}</div>
                </div>
            </div>
        </div>

        <div class="passenger-section">
            <div class="passenger-row">
                <div>
                    <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Main Passenger</div>
                    <div style="font-size: 18px; font-weight: 800;">{{ $detail->user->name }}</div>
                    <div style="font-size: 13px; color: var(--muted);">{{ $detail->user->email }}</div>
                </div>
                <div style="text-align: right;">
                    <div class="status-badge">PAID & CONFIRMED</div>
                    <div style="font-size: 11px; color: var(--muted); margin-top: 8px;">Issued on: {{ date('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="footer-note">
            In case you want to cancel your ticket online, please call 16374 before the Departure day. Thank you for choosing SwiftBus.
        </div>
    </div>

</body>
</html>
