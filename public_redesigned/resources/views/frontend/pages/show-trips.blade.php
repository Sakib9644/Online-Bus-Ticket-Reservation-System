@extends('frontend.index')
@section('content')

<div style="background:var(--ink); padding:60px 40px 48px;">
    <div style="max-width:1100px; margin:0 auto;">
        <span class="sb-badge" style="background:#1a1a1a; color:#888; margin-bottom:16px;">Find your ride</span>
        <h1 class="syne" style="color:#fff; font-size:clamp(28px,4vw,48px); font-weight:800; margin-bottom:8px;">Search Trips</h1>
        <p style="color:#666;">Select your route, date, and preferred time</p>

        <div style="background:#111; border:1px solid #1e1e1e; border-radius:16px; padding:28px; margin-top:32px;">
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr 1.4fr auto; gap:14px; align-items:start;">
                <div>
                    <label style="display:block; color:#555; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">From</label>
                    <select class="sb-search-input" wire:model="from" required>
                        <option value="">Select origin</option>
                        @foreach ($locationFroms as $location)
                            <option value="{{ $location->location_from }}">{{ $location->location_from }}</option>
                        @endforeach
                    </select>
                    @error('from') <span style="color:#ff4d1c; font-size:12px; margin-top:4px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display:block; color:#555; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">To</label>
                    <select class="sb-search-input" wire:model="to" required>
                        <option value="">Select destination</option>
                        @foreach ($locationTos as $location)
                            <option value="{{ $location->location_to }}">{{ $location->location_to }}</option>
                        @endforeach
                    </select>
                    @error('to') <span style="color:#ff4d1c; font-size:12px; margin-top:4px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display:block; color:#555; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Date</label>
                    <input type="date" class="sb-search-input" wire:model="date" required />
                    @error('date') <span style="color:#ff4d1c; font-size:12px; margin-top:4px;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label style="display:block; color:#555; font-size:11px; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Departure Time</label>
                    <select class="sb-search-input" wire:model="time" required>
                        <option value="">Choose time</option>
                        <option value="Morning (07:00AM)">🌅 Morning (07:00AM)</option>
                        <option value="Morning (09:00AM)">🌅 Morning (09:00AM)</option>
                        <option value="Morning (11:00AM)">🌅 Morning (11:00AM)</option>
                        <option value="Afternoon (01:00PM)">☀️ Afternoon (01:00PM)</option>
                        <option value="Afternoon (03:00PM)">☀️ Afternoon (03:00PM)</option>
                        <option value="Afternoon (05:00PM)">☀️ Afternoon (05:00PM)</option>
                        <option value="Night (07:00PM)">🌙 Night (07:00PM)</option>
                        <option value="Night (09:00PM)">🌙 Night (09:00PM)</option>
                        <option value="Night (11:00PM)">🌙 Night (11:00PM)</option>
                    </select>
                    @error('time') <span style="color:#ff4d1c; font-size:12px; margin-top:4px;">{{ $message }}</span> @enderror
                </div>
                <div style="padding-top:23px;">
                    <button wire:click="search" style="background:#ff4d1c; color:#fff; border:none; border-radius:10px; padding:13px 24px; font-family:'Syne',sans-serif; font-weight:700; font-size:14px; cursor:pointer; width:100%; white-space:nowrap; transition:background .2s;" onmouseover="this.style.background='#e03a0e'" onmouseout="this.style.background='#ff4d1c'">
                        Search →
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-wrap">
    <livewire:trip :trips="$trips" />
</div>

<style>
.sb-search-input {
    width: 100%;
    background: #1a1a1a;
    border: 1px solid #2a2a2a;
    border-radius: 10px;
    padding: 12px 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #fff;
    outline: none;
    transition: border-color .2s;
    appearance: none;
}
.sb-search-input:focus { border-color: #ff4d1c; }
.sb-search-input option { background: #1a1a1a; }
@media (max-width: 900px) {
    .sb-search-input { font-size: 13px; }
}
</style>

@endsection
