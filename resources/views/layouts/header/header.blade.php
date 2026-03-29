<div id="sidebar">

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

  <div style="flex:1;overflow-y:auto;padding:6px 0;">

    <div class="sidebar-section-label">MAIN</div>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fas fa-th-large nav-icon"></i><span class="nav-label">Dashboard</span>
    </a>

    <div class="sidebar-section-label">CUSTOMER</div>
    <div class="nav-item" onclick="toggleSub('sc',this)">
      <i class="fas fa-users nav-icon"></i><span class="nav-label">Customer</span><i class="fas fa-chevron-down chevron nav-label"></i>
    </div>
    <div class="sub-menu" id="sc">
      <a href="{{ route('customers.index') }}" class="sub-item"><i class="fas fa-circle" style="font-size:5px;"></i><span>Customer List</span></a>
    </div>  
  </div>
</div>

<style>
  /* মেনু লিংকগুলোর আন্ডারলাইন রিমুভ করার জন্য */
  .nav-item, .sub-item {
      text-decoration: none !important;
      display: flex;
  }
</style>