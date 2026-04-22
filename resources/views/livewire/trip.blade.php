<div>
    <style>
        .sb-search-input option {
            background-color: #000;
            color: #fff;
            padding: 12px;
        }
        
        /* Layout Grid: 2 Columns */
        .trip-layout-grid {
            display: grid;
            grid-template-columns: 310px minmax(0, 1fr); /* Increased to 300px */
            gap: 40px;
            margin-left: -50px;
        }

        @media (max-width: 992px) {
            .trip-layout-grid {
                grid-template-columns: 1fr;
            }
        }

        .sidebar-card {
            background: #000;
            border: 1px solid rgba(255,255,255,0.1); 
            border-radius: 20px;
            padding: 24px;
            position: sticky;
            top: 100px; /* Clear the sticky header (68px) + buffer */
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            z-index: 10;
        }

        .sidebar-title {
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Trip Card Pure Black & Solid Line */
        .ticket-card {
            background: #000 !important;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; 
            display: flex;
            align-items: stretch;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 20px;
            min-height: 200px; 
            width: 100% !important; 
            max-width: 100% !important;
            position: relative;
        }
        
        .ticket-card:hover {
            border-color: rgba(162, 224, 67, 0.6);
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(162, 224, 67, 0.1); 
            background: #050505 !important;
        }

        .card-segment {
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .segment-left { flex: 1.1; border-right: 1px solid rgba(255,255,255,0.08); }
        .segment-middle { flex: 1.6; border-right: 1px solid rgba(255,255,255,0.08); align-items: flex-start; }
        .segment-right { 
            flex: 0.8; 
            align-items: center; 
            background: rgba(255,255,255,0.01); 
            justify-content: center;
            padding: 20px;
        }

        .badge-group { display: flex; gap: 6px; margin-bottom: 12px; }
        .badge-ac { background: #a2e043; color: #000; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 10px; letter-spacing: 0.5px; }
        .badge-non-ac { background: transparent; color: #666; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 10px; border: 1px solid rgba(255,255,255,0.1); }

        .bus-title { 
            font-family: 'DM Sans', sans-serif; 
            font-size: 20px; 
            font-weight: 800; 
            color: #fff; 
            margin-bottom: 4px; 
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        .coach-sub { color: #555; font-size: 12px; font-weight: 600; }

        .journey-info { display: flex; align-items: center; gap: 15px; width: 100%; }
        .city-box { text-align: left; }
        .city-name-lg { font-size: 22px; font-weight: 800; color: #fff; display: block; line-height: 1.1; letter-spacing: -0.5px; }
        .time-label-gr { font-size: 12px; color: #a2e043; font-weight: 700; margin-top: 6px; display: block; }

        .timeline-visual { flex: 1; position: relative; display: flex; align-items: center; justify-content: center; min-width: 60px; }
        .timeline-line-dashed { width: 100%; height: 2px; background: rgba(162, 224, 67, 0.2); }
        .bus-icon-center { position: absolute; background: #000; padding: 0 8px; color: #a2e043; font-size: 16px; z-index: 2; }

        .price-box { text-align: center; margin-bottom: 15px; }
        .price-label-sm { font-size: 9px; color: #555; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 4px; display: block; font-weight: 700; }
        .price-val-lg { font-size: 32px; font-weight: 800; color: #a2e043; line-height: 1; display: flex; align-items: center; justify-content: center; }

        .btn-select-seats {
            background: #a2e043;
            color: #000 !important;
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 11px;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.3s;
            display: block;
            border: none;
            cursor: pointer;
        }
        .btn-select-seats:hover { background: #fff; transform: scale(1.02); }
        
        /* Mini Form Styles */
        .mini-form-group { margin-bottom: 15px; }
        .mini-label { display: block; font-size: 10px; font-weight: 700; text-transform: uppercase; color: #8a9688; margin-bottom: 6px; }
        .mini-input-wrap { position: relative; }
        .mini-input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #555; font-size: 12px; }
        .mini-input { width: 100%; background: #121611; border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 12px 14px 12px 40px; color: #fff; font-size: 13px; outline: none; transition: 0.2s; }
        .mini-input:focus { border-color: #a2e043; }
        .mini-btn { width: 100%; background: #a2e043; color: #000; border: none; border-radius: 10px; padding: 12px; font-size: 13px; font-weight: 900; cursor: pointer; text-transform: uppercase; transition: 0.2s; }
        .mini-btn:hover { background: #b8f55a; transform: translateY(-2px); }

        /* Sliding Drawer (Re-Styled to Premium Dark) */
        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s;
        }
        .drawer-overlay.active { opacity: 1; visibility: visible; }

        .drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: #000;
            border-left: 1px solid rgba(255,255,255,0.1);
            z-index: 9999;
            padding: 60px 40px;
            transition: 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: -20px 0 50px rgba(0,0,0,0.8);
            color: #fff;
            overflow-y: auto;
        }
        .drawer.active { right: 0; }
        .close-drawer {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 28px;
            color: #555;
            cursor: pointer;
            border: none;
            background: transparent;
            transition: 0.3s;
        }
        .close-drawer:hover { color: #fff; }

        .user-profile-mini { text-align: center; }
        .user-avatar { width: 80px; height: 80px; background: #a2e043; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; color: #000; margin: 0 auto 20px; font-weight: 800; border: 4px solid rgba(162, 224, 67, 0.2); }
        .user-name { color: #fff; font-weight: 800; font-size: 18px; margin-bottom: 6px; }
        .user-email { color: #555; font-size: 13px; margin-bottom: 25px; }
        .quick-links { display: flex; flex-direction: column; gap: 12px; }
        .quick-link { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); color: #ccc; padding: 12px 20px; border-radius: 14px; text-decoration: none; font-size: 14px; text-align: left; transition: 0.3s; display: flex; align-items: center; justify-content: space-between; }
        .quick-link:hover { background: rgba(162, 224, 67, 0.08); color: #a2e043; border-color: rgba(162, 224, 67, 0.2); padding-left: 25px; }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <div class="section-wrap" style="padding-top: 20px; padding-bottom: 100px;">
        <div class="trip-layout-grid">
            {{-- Left Section: Filters (Previous Design) --}}
            <aside class="left-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-title">
                        <i class="fa-solid fa-sliders"></i>
                        Filters
                    </div>
                    <form wire:submit.prevent="search">
                        <div class="mini-form-group">
                            <label class="mini-label">From</label>
                            <select class="mini-input" wire:model.live="from" style="padding-left: 16px;">
                                <option value="">Origin</option>
                                @foreach ($origins as $origin)
                                    <option value="{{ $origin }}">{{ $origin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-form-group">
                            <label class="mini-label">To</label>
                            <select class="mini-input" wire:model.live="to" style="padding-left: 16px;">
                                <option value="">Destination</option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination }}">{{ $destination }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-form-group">
                            <label class="mini-label">Journey Date</label>
                            <input type="date" class="mini-input" wire:model.live="date" style="color-scheme: dark; padding-left: 16px;">
                        </div>
                        <div class="mini-form-group">
                            <label class="mini-label">Departure</label>
                            <select class="mini-input" wire:model.live="time" style="padding-left: 16px;">
                                <option value="">All Times</option>
                                @foreach ($times as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mini-form-group">
                            <label class="mini-label">Coach Type</label>
                            <select class="mini-input" wire:model.live="type" style="padding-left: 16px;">
                                <option value="">All Types</option>
                                <option value="ac">AC Coach</option>
                                <option value="non-ac">Non-AC Coach</option>
                            </select>
                        </div>
                        <button type="button" wire:click="$set('from', ''); $set('to', ''); $set('date', ''); $set('time', ''); $set('type', ''); $set('bus_name', '');" class="mini-btn" style="background: rgba(255,255,255,0.03); color: #666; margin-top: 10px; border: 1px solid rgba(255,255,255,0.05);">
                            Reset Filters
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Middle Section: Results (Previous Design) --}}
            <main class="middle-content" style="padding-top: 0;">
                @if ($trips->count() > 0)
                    <div style="margin-top: 0; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 20px;">
                        <h4 style="color: #fff; margin: 0; font-weight: 800; font-family: 'DM Sans', sans-serif; font-size: 22px; line-height: 1.2;">Available Trips ({{ $trips->count() }})</h4>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach ($trips as $trip)
                            <div class="ticket-card">
                                <div class="card-segment segment-left">
                                    <div class="badge-group">
                                        @if(strtolower($trip->bus->bus_type) == 'ac')
                                            <span class="badge-ac">AC</span>
                                            <span class="badge-non-ac">NON-AC</span>
                                        @else
                                            <span class="badge-non-ac" style="background: rgba(255,255,255,0.05);">AC</span>
                                            <span class="badge-ac">NON-AC</span>
                                        @endif
                                    </div>
                                    <h3 class="bus-title">{{ $trip->bus->bus_name }}</h3>
                                    <div class="coach-sub">Coach No. {{ $trip->bus->coach_no }}</div>
                                </div>

                                <div class="card-segment segment-middle">
                                    @php
                                        $timeRaw = $trip->time;
                                        // Extract time pattern like 08:00AM from strings like "Morning (08:00AM)"
                                        preg_match('/(\d{1,2}:\d{2}\s?(AM|PM))/i', $timeRaw, $matches);
                                        $timeToParse = $matches[0] ?? $timeRaw;
                                        
                                        try {
                                            $startTime = \Carbon\Carbon::parse($timeToParse);
                                            $endTime = $startTime->copy()->addHours(8); 
                                            $displayStart = $startTime->format('h:i A');
                                            $displayEnd = $endTime->format('h:i A');
                                        } catch (\Exception $e) {
                                            $displayStart = $timeRaw;
                                            $displayEnd = '--:--';
                                        }
                                    @endphp
                                    <div class="journey-info">
                                        <div class="city-box">
                                            <span class="city-name-lg">{{ $trip->location_from }}</span>
                                            <span class="time-label-gr">{{ $displayStart }}</span>
                                        </div>
                                        <div class="timeline-visual">
                                            <div class="timeline-line-dashed"></div>
                                            <div class="bus-icon-center"><i class="fa-solid fa-shuttle-van"></i></div>
                                        </div>
                                        <div class="city-box">
                                            <span class="city-name-lg">{{ $trip->location_to }}</span>
                                            <span class="time-label-gr">{{ $displayEnd }}</span>
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px; width: 100%;">
                                        <div style="font-size: 14px; font-weight: 700; color: #a2e043; opacity: 0.9; display: flex; align-items: center; gap: 8px;">
                                            <i class="fa-solid fa-chair" style="font-size: 12px;"></i>
                                            {{ $trip->bus->seats->count() - $trip->bookings->count() }} Seats Left
                                        </div>
                                    </div>
                                </div>

                                <div class="card-segment segment-right">
                                    <div style="width: 100%;">
                                        <div class="price-box">
                                            <span class="price-label-sm">PRICE</span>
                                            <div class="price-val-lg">
                                                <span style="font-size: 28px; margin-right: 4px;">৳</span>{{ $trip->fare }}
                                            </div>
                                        </div>
                                        @auth
                                            <a href="{{ route('frontend.bookTrip', $trip->id) }}" class="btn-select-seats">BOOK NOW</a>
                                        @else
                                            <button onclick="toggleDrawer()" class="btn-select-seats">BOOK NOW</button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 100px 20px;">
                        <h3 style="color: #fff;">No trips found. Try adjusting your filters.</h3>
                    </div>
                @endif
            </main>
        </div>
    </div>

    {{-- Drawer Overlay --}}
    <div id="drawerOverlay" class="drawer-overlay" onclick="toggleDrawer()"></div>

    {{-- Sliding Drawer --}}
    <div id="drawer" class="drawer">
        <button class="close-drawer" onclick="toggleDrawer()">&times;</button>
        
        @auth
            <div class="user-profile-mini">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-email">{{ auth()->user()->email }}</div>
                <div class="quick-links">
                    <a href="#" class="quick-link">
                        <span><i class="fa-solid fa-user-gear me-2"></i> My Profile</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
                    </a>
                    <a href="{{ route('booking.details') }}" class="quick-link">
                        <span><i class="fa-solid fa-ticket me-2"></i> My Bookings</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 10px; opacity: 0.5;"></i>
                    </a>
                    <a href="{{ route('user.logout') }}" class="quick-link w-100" style="background: rgba(220, 53, 69, 0.08); color: #ff4d4d; justify-content: center; font-weight: 800; text-decoration: none;">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>
        @else
            <div class="sidebar-title">
                <i class="fa-solid fa-circle-user"></i>
                Login Menu
            </div>
            <form action="{{ route('user.do.login') }}" method="POST">
                @csrf
                <div class="mini-form-group">
                    <label class="mini-label">Email Address</label>
                    <div class="mini-input-wrap">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" class="mini-input" placeholder="email@example.com" required>
                    </div>
                </div>
                <div class="mini-form-group">
                    <label class="mini-label">Password</label>
                    <div class="mini-input-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" class="mini-input" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="mini-btn">Sign In</button>
                <div style="text-align: center; margin-top: 25px;">
                    <a href="{{ route('user.registration') }}" style="color: #a2e043; text-decoration: none; font-size: 13px; font-weight: 800;">Create Account</a>
                </div>
            </form>
        @endauth

        <div class="sidebar-card" style="margin-top: 40px; background: linear-gradient(135deg, rgba(162, 224, 67, 0.05) 0%, rgba(0,0,0,0) 100%);">
            <div style="color: #a2e043; font-size: 16px; font-weight: 800; margin-bottom: 12px;">Need Help?</div>
            <p style="color: #555; font-size: 13px; line-height: 1.7; margin-bottom: 0;">Our support team is available 24/7 to assist with your bookings.</p>
        </div>
    </div>

    <script>
        function toggleDrawer() {
            const drawer = document.getElementById('drawer');
            const overlay = document.getElementById('drawerOverlay');
            if(drawer && overlay) {
                drawer.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        }
    </script>
</div>
