<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ashik Auto Solution — Billing System</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;background:#f1f5f9;color:#334155;min-height:100vh;}

/* SIDEBAR */
#sidebar{width:230px;min-height:100vh;background:#1a2332;position:fixed;left:0;top:0;bottom:0;z-index:40;display:flex;flex-direction:column;transition:width .25s ease;overflow:hidden;}
#sidebar.collapsed{width:64px;}
#sidebar.collapsed .nav-label,#sidebar.collapsed .sidebar-section-label,#sidebar.collapsed .user-info,#sidebar.collapsed .logo-text,#sidebar.collapsed .chevron{display:none;}
#sidebar.collapsed #sidebar-logo{justify-content:center;padding:16px 0;}

.nav-item{display:flex;align-items:center;gap:10px;padding:9px 14px;cursor:pointer;border-radius:6px;margin:1px 8px;color:#94a3b8;font-size:13px;font-weight:500;transition:all .18s;text-decoration:none;}
.nav-item:hover{background:#243044;color:#e2e8f0;}
.nav-item.active{background:#2563eb;color:#fff;}
.nav-item .nav-icon{width:18px;min-width:18px;text-align:center;font-size:14px;}
.nav-item .chevron{margin-left:auto;font-size:10px;transition:transform .2s;}
.nav-item.open .chevron{transform:rotate(180deg);}

.sub-menu{max-height:0;overflow:hidden;transition:max-height .25s ease;}
.sub-menu.open{max-height:300px;}
.sub-item{display:flex;align-items:center;gap:8px;padding:7px 14px 7px 40px;font-size:12px;color:#64748b;cursor:pointer;border-radius:6px;margin:1px 8px;transition:all .15s;}
.sub-item:hover{background:#243044;color:#cbd5e1;}

.sidebar-section-label{font-size:10px;font-weight:700;letter-spacing:.12em;color:#475569;padding:14px 16px 4px;text-transform:uppercase;}

/* MAIN */
#main{margin-left:230px;min-height:100vh;display:flex;flex-direction:column;transition:margin-left .25s ease;}
#main.expanded{margin-left:64px;}

/* TOPBAR */
#topbar{background:#fff;border-bottom:1px solid #e2e8f0;padding:0 24px;height:56px;display:flex;align-items:center;gap:10px;position:sticky;top:0;z-index:30;}

/* CARDS */
.stat-card{background:#fff;border-radius:10px;padding:18px;border:1px solid #e2e8f0;transition:box-shadow .2s;}
.stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.07);}

/* TABLE */
.tbl{width:100%;border-collapse:collapse;font-size:13px;}
.tbl th{background:#f8fafc;padding:10px 14px;text-align:left;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border-bottom:1px solid #e2e8f0;}
.tbl td{padding:11px 14px;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
.tbl tr:hover td{background:#f8fafc;}
.tbl tr:last-child td{border-bottom:none;}

/* FORM */
.lbl{font-size:12px;font-weight:600;color:#475569;margin-bottom:5px;display:block;}
.inp{width:100%;border:1px solid #e2e8f0;border-radius:7px;padding:8px 12px;font-size:13px;color:#334155;background:#fff;outline:none;transition:.15s;font-family:'DM Sans',sans-serif;}
.inp:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1);}
.inp::placeholder{color:#94a3b8;}
select.inp{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;appearance:none;}

/* BADGE */
.badge{display:inline-flex;align-items:center;padding:2px 9px;border-radius:99px;font-size:11px;font-weight:600;}
.b-paid{background:#dcfce7;color:#15803d;}
.b-pending{background:#fef9c3;color:#854d0e;}
.b-due{background:#fee2e2;color:#b91c1c;}

/* BUTTON */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;border:none;transition:.15s;font-family:'DM Sans',sans-serif;}
.btn:hover{filter:brightness(.95);}
.btn-blue{background:#2563eb;color:#fff;}
.btn-blue:hover{background:#1d4ed8;}
.btn-gray{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
.btn-red{background:#fee2e2;color:#b91c1c;}
.btn-sm{padding:5px 10px;font-size:12px;}

/* PAGE */
.pg{display:none;animation:fi .2s ease;}
.pg.on{display:block;}
@keyframes fi{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}

/* MODAL */
.modal{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:60;display:none;align-items:center;justify-content:center;padding:16px;}
.modal.on{display:flex;}
.mbox{background:#fff;border-radius:12px;padding:24px;width:100%;max-width:680px;max-height:92vh;overflow-y:auto;}

/* TOAST */
#toast{position:fixed;bottom:24px;right:24px;z-index:99;display:none;}

::-webkit-scrollbar{width:5px;}
::-webkit-scrollbar-track{background:#f1f5f9;}
::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:3px;}

@media print{
  #sidebar,#topbar,.noprint{display:none!important;}
  #main{margin-left:0!important;}
  body{background:#fff;}
}
</style>
</head>
<body>

    @include('layouts.header.header')

<!-- ============================= MAIN ============================= -->
<div id="main">
    <!-- TOPBAR -->
  <div id="topbar">
    <button onclick="toggleSidebar()" class="btn btn-gray" style="padding:7px 10px;">
      <i class="fas fa-bars" style="font-size:14px;"></i>
    </button>
    <button class="btn btn-gray" style="padding:7px 10px;">
      <i class="fas fa-expand" style="font-size:14px;"></i>
    </button>
    <div style="position:relative;flex:1;max-width:320px;">
      <input type="text" placeholder="Search" class="inp" style="padding-left:36px;background:#f8fafc;">
      <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
    </div>
    <div style="margin-left:auto;display:flex;align-items:center;gap:12px;">
      <button class="btn btn-blue btn-sm noprint" onclick="go('new-bill')"><i class="fas fa-plus"></i> New Invoice</button>
      <div style="position:relative;cursor:pointer;">
        <i class="fas fa-bell" style="color:#94a3b8;font-size:16px;"></i>
        <span style="position:absolute;top:-3px;right:-3px;width:7px;height:7px;background:#ef4444;border-radius:50%;"></span>
      </div>
      <div style="width:32px;height:32px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-user" style="font-size:12px;color:#2563eb;"></i>
      </div>
    </div>
  </div>
<div style="padding:24px;flex:1;">
    @yield('content')
</div>


  @include('layouts.footer.footer')
</div>

<!-- INVOICE MODAL -->
<div class="modal" id="inv-modal" onclick="closeM(event)">
  <div class="mbox" id="inv-box"></div>
</div>

<!-- TOAST -->
<div id="toast">
  <div id="toast-inner" style="display:flex;align-items:center;gap:9px;padding:11px 16px;border-radius:9px;font-size:13px;font-weight:600;box-shadow:0 6px 20px rgba(0,0,0,.12);">
    <i id="toast-icon"></i><span id="toast-msg"></span>
  </div>
</div>


@yield('scripts')

</body>
</html>