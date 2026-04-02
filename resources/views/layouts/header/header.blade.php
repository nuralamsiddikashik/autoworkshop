<div id="sidebar" style="background: #1e293b; height: 100vh; width: 250px; display: flex; flex-direction: column;">

  <div id="sidebar-logo" style="display:flex;align-items:center;gap:10px;padding:16px;border-bottom:1px solid rgba(255,255,255,.06);">
    <div style="width:36px;height:36px;min-width:36px;background:linear-gradient(135deg,#2563eb,#60a5fa);border-radius:8px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-car-side" style="color:#fff;font-size:15px;"></i>
    </div>
    <div class="logo-text">
      <div style="font-size:13px;font-weight:700;color:#f1f5f9;line-height:1.2;">Ashik Auto</div>
      <div style="font-size:10px;color:#64748b;">Solution</div>
    </div>
  </div>

  <div class="user-info" style="padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.04);">
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="width:32px;height:32px;min-width:32px;border-radius:50%;background:#243044;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-user" style="color:#60a5fa;font-size:12px;"></i>
      </div>
      <div>
        <div style="font-size:12px;font-weight:600;color:#e2e8f0;">MD Nur Alam Siddik</div>
        <div style="font-size:10px;color:#64748b;">admin</div>
      </div>
    </div>
  </div>

  <div style="flex:1; overflow-y:auto; padding:10px 0;">

    <div class="sidebar-section-label">MAIN</div>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fas fa-th-large nav-icon"></i>
      <span class="nav-label">Dashboard</span>
    </a>

    <div class="sidebar-section-label">CUSTOMER</div>
    <a href="{{ route('customers.index') }}" class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
      <i class="fas fa-users nav-icon"></i>
      <span class="nav-label">Customer List</span>
    </a>

    <div class="sidebar-section-label">CARS MANAGEMENT</div>
    
    <a href="{{ route('cars.brands.index') }}" class="nav-item {{ request()->routeIs('cars.brands.*') ? 'active' : '' }}">
      <i class="fas fa-tags nav-icon"></i>
      <span class="nav-label">Car Brands</span>
    </a>

    <a href="{{ route('cars.models.index') }}" class="nav-item {{ request()->routeIs('cars.models.*') ? 'active' : '' }}">
      <i class="fas fa-car nav-icon"></i>
      <span class="nav-label">Car Models</span>
    </a>
    
    <a href="{{ route('car-receives.index') }}" class="nav-item {{ request()->routeIs('car-receives.index') ? 'active' : '' }}">
      <i class="fas fa-receipt nav-icon"></i>
      <span class="nav-label">Car Receives</span>
    </a>

    <a href="{{ route('car-receives.create') }}" class="nav-item {{ request()->routeIs('car-receives.create') ? 'active' : '' }}">
      <i class="fas fa-receipt nav-icon"></i>
      <span class="nav-label">Car Receives Create</span>
    </a>

    <div class="sidebar-section-label">JOB CARDS</div>
    <a href="{{ route('job-cards.create') }}" class="nav-item {{ request()->routeIs('job-cards.create') ? 'active' : '' }}">
      <i class="fas fa-file nav-icon"></i>
      <span class="nav-label">Job Cards Create</span>
    </a>

    <div class="sidebar-section-label">INVOICES</div>
  
    <a href="{{ route('invoices.create') }}" class="nav-item {{ request()->routeIs('invoices.create') ? 'active' : '' }}">
      <i class="fas fa-file nav-icon"></i>
      <span class="nav-label">Invoices Create</span>
    </a>
      
  </div>
</div>

<style>
/* সাইডবার স্ক্রলবার হাইড করার জন্য */
div[style*="overflow-y:auto"]::-webkit-scrollbar {
    width: 4px;
}
div[style*="overflow-y:auto"]::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.nav-item {
    text-decoration: none !important;
    display: flex;
    align-items: center;
    padding: 12px 16px;
    margin: 2px 12px;
    color: #94a3b8;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-item:hover {
    background: rgba(255,255,255,0.05);
    color: #f1f5f9;
}

.nav-item.active {
    background: rgba(37, 99, 235, 0.15); /* নীলচে ব্যাকগ্রাউন্ড */
    color: #60a5fa !important;
}

.nav-item.active i {
    color: #60a5fa !important;
}

.nav-label {
    font-size: 13px;
    font-weight: 500;
    margin-left: 12px;
}

.nav-icon {
    width: 20px;
    font-size: 14px;
    color: #64748b;
    text-align: center;
}

.sidebar-section-label {
    font-size: 10px;
    font-weight: 700;
    color: #475569;
    padding: 20px 24px 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
</style>