# 🚌 BusGo — Online Bus Ticket Reservation System (Redesigned)

A complete UI/UX redesign of the Online Bus Ticket Reservation System Laravel project.

---

## 📁 Files Redesigned

### Frontend Views (`resources/views/frontend/`)

| File | Description |
|------|-------------|
| `partials/header.blade.php` | Sticky navbar with topbar, brand, nav links, auth buttons |
| `partials/footer.blade.php` | Full footer with links, contact info, social icons |
| `pages/home.blade.php` | Hero section, trip search form, features, how-it-works, popular routes, CTA |
| `pages/show-trips.blade.php` | Search results with filter bar, trip cards, seat availability |
| `pages/book-trips.blade.php` | Interactive seat layout, order summary, booking form |
| `pages/login.blade.php` | Split-layout login & registration pages |

### Admin Views (`resources/views/admin/`)

| File | Description |
|------|-------------|
| `master.blade.php` | Admin layout: dark sidebar, sticky topbar, flash messages |
| `pages/dashboard.blade.php` | Stats cards, recent bookings table, quick actions |
| `pages/Booking/booking-list.blade.php` | Bookings table with filters, status badges, actions |

---

## 🎨 Design Highlights

- **Color Scheme:** Orange (#f97316) primary on dark navy backgrounds
- **Font:** Plus Jakarta Sans (Google Fonts)
- **Framework:** Bootstrap 5.3 + Font Awesome 6.4
- **No external dependencies** beyond CDN links — drop-in replacement

### Frontend Features
- ✅ Responsive sticky navbar with auth state
- ✅ Hero section with animated trip search form
- ✅ Interactive bus seat layout (click to select/deselect)
- ✅ Real-time booking summary sidebar
- ✅ Trip cards with availability indicators
- ✅ Split-screen auth pages (login + register)

### Admin Panel Features
- ✅ Fixed dark sidebar with icon navigation
- ✅ Sticky topbar with page title + breadcrumb
- ✅ Dashboard stat cards with trend indicators
- ✅ Filterable data tables with status badges
- ✅ Quick action shortcuts

---

## 🔧 How to Use

1. **Copy** all files from `resources/views/` into your Laravel project's `resources/views/` directory
2. **Replace** the existing files (make a backup first!)
3. The designs use CDN links — no npm install needed
4. Your existing **controllers, routes, and models remain unchanged**

---

## 📦 Original Project Structure Preserved

All `@yield`, `@section`, `@extends`, `{{ $variable }}`, `{{ route() }}`, `{{ url() }}` directives are maintained exactly as in the original — only the HTML/CSS design is changed.

---

*Redesigned with ❤️ — All logic/backend untouched*
