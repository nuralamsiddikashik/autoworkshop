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

<script>
// STATE
let bills = JSON.parse(localStorage.getItem('ws_bills')||'[]');
let settings = JSON.parse(localStorage.getItem('ws_settings')||'{"name":"Ashik Auto Solution","address":"","phone":"","email":"","web":""}');
let items = [], editId = null;

// CLOCK
setInterval(()=>{ const el=document.getElementById('dash-time'); if(el) el.textContent=new Date().toLocaleString('en-BD',{weekday:'long',year:'numeric',month:'long',day:'numeric',hour:'2-digit',minute:'2-digit'}); },1000);

// SIDEBAR
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('collapsed');
  document.getElementById('main').classList.toggle('expanded');
}
function toggleSub(id,el){
  document.getElementById(id).classList.toggle('open');
  el.classList.toggle('open');
}

// PAGES
function go(id,el){
  document.querySelectorAll('.pg').forEach(p=>p.classList.remove('on'));
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  const pg=document.getElementById('pg-'+id);
  if(pg) pg.classList.add('on');
  if(el) el.classList.add('active');
  if(id==='dashboard') updateDash();
  if(id==='bill-list') renderBL();
  if(id==='customers') renderCust();
  if(id==='reports') renderReports();
  if(id==='settings') loadSettings();
}

// ITEMS
function addItem(){
  const n=document.getElementById('i-name').value.trim();
  const t=document.getElementById('i-type').value;
  const q=parseFloat(document.getElementById('i-qty').value)||1;
  const p=parseFloat(document.getElementById('i-price').value)||0;
  if(!n){showToast('Enter description','w');return;}
  if(!p){showToast('Enter price','w');return;}
  items.push({id:Date.now(),n,t,q,p});
  document.getElementById('i-name').value='';
  document.getElementById('i-price').value='';
  document.getElementById('i-qty').value='1';
  renderItems(); calcT();
}
function qa(n,p,t){ items.push({id:Date.now(),n,t,q:1,p}); renderItems(); calcT(); }
function removeItem(id){ items=items.filter(i=>i.id!==id); renderItems(); calcT(); }

function renderItems(){
  const tb=document.getElementById('items-body');
  if(!items.length){tb.innerHTML='<tr><td colspan="6" style="text-align:center;padding:18px;color:#94a3b8;font-size:12px;">No items added</td></tr>';return;}
  const cls={Service:'background:#eff6ff;color:#2563eb',Part:'background:#faf5ff;color:#7c3aed',Labor:'background:#f0fdf4;color:#15803d'};
  tb.innerHTML=items.map(i=>`<tr>
    <td>${i.n}</td>
    <td><span style="padding:2px 8px;border-radius:99px;font-size:11px;font-weight:600;${cls[i.t]||''}">${i.t}</span></td>
    <td style="text-align:center;">${i.q}</td>
    <td style="text-align:right;font-family:'DM Mono',monospace;">৳${i.p.toLocaleString()}</td>
    <td style="text-align:right;font-family:'DM Mono',monospace;font-weight:600;">৳${(i.q*i.p).toLocaleString()}</td>
    <td style="text-align:center;"><button onclick="removeItem(${i.id})" style="background:none;border:none;color:#e11d48;cursor:pointer;font-size:13px;"><i class="fas fa-times"></i></button></td>
  </tr>`).join('');
}

function calcT(){
  let svc=0,pts=0,lab=0;
  items.forEach(i=>{const v=i.q*i.p; if(i.t==='Service')svc+=v; else if(i.t==='Part')pts+=v; else lab+=v;});
  const sub=svc+pts+lab;
  let disc=parseFloat(document.getElementById('f-disc').value)||0;
  if(document.getElementById('f-disctype').value==='pct') disc=sub*disc/100;
  const vatP=parseFloat(document.getElementById('f-vat').value)||0;
  const vat=(sub-disc)*vatP/100;
  const grand=sub-disc+vat;
  const f=v=>'৳ '+v.toLocaleString('en',{minimumFractionDigits:2,maximumFractionDigits:2});
  document.getElementById('ss-svc').textContent=f(svc);
  document.getElementById('ss-pts').textContent=f(pts);
  document.getElementById('ss-lab').textContent=f(lab);
  document.getElementById('ss-sub').textContent=f(sub);
  document.getElementById('ss-grand').textContent=f(grand);
  calcDue(grand);
}
function calcDue(grand){
  if(grand===undefined) grand=parseFloat(document.getElementById('ss-grand').textContent.replace('৳ ','').replace(/,/g,''))||0;
  const paid=parseFloat(document.getElementById('f-paid').value)||0;
  document.getElementById('ss-due').textContent='৳ '+Math.max(0,grand-paid).toLocaleString('en',{minimumFractionDigits:2});
}

// SAVE
function saveBill(){
  const name=document.getElementById('f-name').value.trim();
  if(!name){showToast('Customer name required','w');return;}
  if(!items.length){showToast('Add at least one item','w');return;}
  const grand=parseFloat(document.getElementById('ss-grand').textContent.replace('৳ ','').replace(/,/g,''))||0;
  const paid=parseFloat(document.getElementById('f-paid').value)||0;
  const b={
    id:editId||'INV-'+String(bills.length+1).padStart(4,'0'),
    date:new Date().toISOString(),
    customer:{name,phone:document.getElementById('f-phone').value},
    vehicle:{type:document.getElementById('f-vtype').value,number:document.getElementById('f-vnum').value,model:document.getElementById('f-vmodel').value},
    problem:document.getElementById('f-problem').value,
    items:[...items],
    disc:document.getElementById('f-disc').value,
    discType:document.getElementById('f-disctype').value,
    vat:document.getElementById('f-vat').value,
    grandTotal:grand,paidAmount:paid,dueAmount:Math.max(0,grand-paid),
    payMethod:document.getElementById('f-paymethod').value,
    status:document.getElementById('f-status').value,
    mechanic:document.getElementById('f-mechanic').value,
    notes:document.getElementById('f-notes').value,
  };
  if(editId){bills=bills.map(x=>x.id===editId?b:x);editId=null;}else bills.push(b);
  localStorage.setItem('ws_bills',JSON.stringify(bills));
  showToast('Invoice saved: '+b.id,'s');
  clearForm();
  setTimeout(()=>openInv(b),300);
}

function clearForm(){
  ['f-name','f-phone','f-vtype','f-vnum','f-vmodel','f-mileage','f-problem','f-mechanic','f-notes','f-disc','f-vat','f-paid'].forEach(id=>{
    const el=document.getElementById(id); if(el) el.value=el.tagName==='SELECT'?'':'';
  });
  items=[]; editId=null; renderItems(); calcT();
}

function previewCurrent(){
  const name=document.getElementById('f-name').value.trim();
  if(!name||!items.length){showToast('Fill form first','w');return;}
  const grand=parseFloat(document.getElementById('ss-grand').textContent.replace('৳ ','').replace(/,/g,''))||0;
  const paid=parseFloat(document.getElementById('f-paid').value)||0;
  openInv({id:'DRAFT',date:new Date().toISOString(),customer:{name,phone:document.getElementById('f-phone').value},vehicle:{type:document.getElementById('f-vtype').value,number:document.getElementById('f-vnum').value,model:document.getElementById('f-vmodel').value},items:[...items],disc:document.getElementById('f-disc').value,discType:document.getElementById('f-disctype').value,vat:document.getElementById('f-vat').value,grandTotal:grand,paidAmount:paid,dueAmount:Math.max(0,grand-paid),payMethod:document.getElementById('f-paymethod').value,status:document.getElementById('f-status').value,mechanic:document.getElementById('f-mechanic').value,notes:document.getElementById('f-notes').value});
}

// INVOICE MODAL
function openInv(b){
  const sn=settings.name||'Ashik Auto Solution';
  const d=new Date(b.date).toLocaleDateString('en-BD',{day:'2-digit',month:'short',year:'numeric'});
  const sc=b.status==='paid'?'#15803d':b.status==='pending'?'#854d0e':'#b91c1c';
  const sb=b.status==='paid'?'#dcfce7':b.status==='pending'?'#fef9c3':'#fee2e2';
  const sl=b.status==='paid'?'Paid':b.status==='pending'?'Partially Paid':'Due / Unpaid';
  const rows=(b.items||[]).map(i=>`<tr style="border-bottom:1px solid #f1f5f9;"><td style="padding:9px 12px;font-size:13px;">${i.n}</td><td style="padding:9px 12px;font-size:11px;color:#64748b;">${i.t}</td><td style="padding:9px 12px;text-align:center;font-size:13px;">${i.q}</td><td style="padding:9px 12px;text-align:right;font-family:monospace;font-size:13px;">৳${Number(i.p).toLocaleString()}</td><td style="padding:9px 12px;text-align:right;font-family:monospace;font-size:13px;font-weight:600;">৳${(i.q*i.p).toLocaleString()}</td></tr>`).join('');
  document.getElementById('inv-box').innerHTML=`<div style="font-family:'DM Sans',sans-serif;color:#1e293b;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;padding-bottom:18px;border-bottom:2px solid #e2e8f0;margin-bottom:18px;">
      <div><div style="font-size:22px;font-weight:800;">${sn}</div><div style="font-size:12px;color:#64748b;margin-top:2px;">${settings.address||''}</div><div style="font-size:12px;color:#64748b;">${settings.phone?'📞 '+settings.phone:''} ${settings.email?'✉ '+settings.email:''}</div></div>
      <div style="text-align:right;"><div style="font-size:22px;font-weight:800;color:#2563eb;font-family:monospace;">#${b.id}</div><div style="font-size:12px;color:#64748b;">Date: ${d}</div><span style="display:inline-block;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;background:${sb};color:${sc};margin-top:5px;">${sl}</span></div>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
      <div style="background:#f8fafc;border-radius:8px;padding:12px;"><div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.1em;margin-bottom:7px;">Customer</div><div style="font-weight:700;font-size:14px;">${b.customer.name}</div><div style="font-size:12px;color:#64748b;font-family:monospace;">${b.customer.phone||'—'}</div></div>
      <div style="background:#f8fafc;border-radius:8px;padding:12px;"><div style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.1em;margin-bottom:7px;">Vehicle</div><div style="font-weight:700;font-size:14px;">${b.vehicle.model||b.vehicle.type||'—'}</div><div style="font-size:12px;color:#64748b;font-family:monospace;">${b.vehicle.number||'—'}</div></div>
    </div>
    <table style="width:100%;border-collapse:collapse;margin-bottom:14px;"><thead><tr style="background:#f8fafc;"><th style="padding:9px 12px;text-align:left;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">Description</th><th style="padding:9px 12px;font-size:11px;font-weight:700;color:#64748b;">Type</th><th style="padding:9px 12px;text-align:center;font-size:11px;font-weight:700;color:#64748b;">Qty</th><th style="padding:9px 12px;text-align:right;font-size:11px;font-weight:700;color:#64748b;">Price</th><th style="padding:9px 12px;text-align:right;font-size:11px;font-weight:700;color:#64748b;">Total</th></tr></thead><tbody>${rows}</tbody></table>
    <div style="display:flex;justify-content:flex-end;margin-bottom:14px;"><div style="min-width:240px;">${b.disc?`<div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;color:#64748b;"><span>Discount</span><span style="font-family:monospace;">- ৳${Number(b.disc).toLocaleString()}</span></div>`:''}<div style="display:flex;justify-content:space-between;padding:10px 12px;background:#eff6ff;border-radius:8px;border:1.5px solid #bfdbfe;margin-top:6px;"><span style="font-size:14px;font-weight:700;">Grand Total</span><span style="font-size:18px;font-weight:800;color:#2563eb;font-family:monospace;">৳${Number(b.grandTotal).toLocaleString('en',{minimumFractionDigits:2})}</span></div><div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;color:#15803d;"><span>Paid</span><span style="font-family:monospace;">৳${Number(b.paidAmount||0).toLocaleString('en',{minimumFractionDigits:2})}</span></div>${b.dueAmount>0?`<div style="display:flex;justify-content:space-between;padding:4px 0;font-size:13px;color:#b91c1c;font-weight:700;"><span>Due</span><span style="font-family:monospace;">৳${Number(b.dueAmount).toLocaleString('en',{minimumFractionDigits:2})}</span></div>`:''}</div></div>
    ${b.notes?`<div style="background:#f8fafc;border-left:3px solid #2563eb;padding:9px 12px;font-size:12px;color:#475569;margin-bottom:12px;"><strong>Notes:</strong> ${b.notes}</div>`:''}
    <div style="display:flex;justify-content:space-between;padding-top:12px;border-top:1px dashed #e2e8f0;font-size:11px;color:#94a3b8;"><span>Payment: <strong style="color:#475569;">${b.payMethod||'Cash'}</strong>${b.mechanic?' • Mechanic: <strong style="color:#475569;">'+b.mechanic+'</strong>':''}</span><span>Thank you 🙏</span></div>
    <div style="display:flex;gap:8px;margin-top:16px;padding-top:14px;border-top:1px solid #f1f5f9;" class="noprint"><button onclick="window.print()" class="btn btn-blue"><i class="fas fa-print"></i> Print</button><button onclick="closeM()" class="btn btn-gray"><i class="fas fa-times"></i> Close</button></div>
  </div>`;
  document.getElementById('inv-modal').classList.add('on');
}
function closeM(e){ if(!e||e.target===document.getElementById('inv-modal')) document.getElementById('inv-modal').classList.remove('on'); }

// BILL LIST
function renderBL(){
  const q=(document.getElementById('bl-q').value||'').toLowerCase();
  const st=document.getElementById('bl-st').value;
  const fl=[...bills].reverse().filter(b=>{
    const m=b.customer.name.toLowerCase().includes(q)||b.id.toLowerCase().includes(q)||(b.vehicle.number||'').toLowerCase().includes(q);
    return m&&(!st||b.status===st);
  });
  const tb=document.getElementById('bl-tbody');
  if(!fl.length){tb.innerHTML='<tr><td colspan="9" style="text-align:center;padding:32px;color:#94a3b8;">No invoices found</td></tr>';return;}
  tb.innerHTML=fl.map(b=>{
    const d=new Date(b.date).toLocaleDateString('en-BD',{day:'2-digit',month:'short',year:'numeric'});
    const bc=b.status==='paid'?'b-paid':b.status==='pending'?'b-pending':'b-due';
    const bl=b.status==='paid'?'Paid':b.status==='pending'?'Partial':'Due';
    return `<tr><td style="font-family:monospace;font-weight:600;color:#2563eb;">${b.id}</td><td><div style="font-weight:500;">${b.customer.name}</div><div style="font-size:11px;color:#94a3b8;">${b.customer.phone||''}</div></td><td style="font-size:12px;color:#64748b;">${b.vehicle.number||b.vehicle.model||'—'}</td><td style="font-size:12px;color:#64748b;">${d}</td><td style="text-align:right;font-family:monospace;font-weight:600;">৳${Number(b.grandTotal).toLocaleString()}</td><td style="text-align:right;font-family:monospace;color:#15803d;">৳${Number(b.paidAmount||0).toLocaleString()}</td><td style="text-align:right;font-family:monospace;color:#b91c1c;">৳${Number(b.dueAmount||0).toLocaleString()}</td><td><span class="badge ${bc}">${bl}</span></td><td><div style="display:flex;gap:4px;"><button onclick='openInv(bills.find(x=>x.id==="'+b.id+'"))' class="btn btn-gray btn-sm"><i class="fas fa-eye"></i></button><button onclick="delBill('${b.id}')" class="btn btn-red btn-sm"><i class="fas fa-trash"></i></button></div></td></tr>`;
  }).join('');
}
function delBill(id){
  if(!confirm('Delete invoice?'))return;
  bills=bills.filter(b=>b.id!==id);
  localStorage.setItem('ws_bills',JSON.stringify(bills));
  renderBL(); updateDash(); showToast('Deleted','w');
}

// CUSTOMERS
function renderCust(){
  const map={};
  bills.forEach(b=>{const k=b.customer.phone||b.customer.name; if(!map[k])map[k]={name:b.customer.name,phone:b.customer.phone,cnt:0,total:0,last:null}; map[k].cnt++; map[k].total+=b.grandTotal; if(!map[k].last||new Date(b.date)>new Date(map[k].last))map[k].last=b.date;});
  const list=Object.values(map);
  const tb=document.getElementById('cust-tbody');
  if(!list.length){tb.innerHTML='<tr><td colspan="6" style="text-align:center;padding:32px;color:#94a3b8;">No customers yet</td></tr>';return;}
  tb.innerHTML=list.map((c,i)=>`<tr><td style="color:#94a3b8;">${i+1}</td><td style="font-weight:500;">${c.name}</td><td style="font-family:monospace;color:#64748b;">${c.phone||'—'}</td><td>${c.cnt}</td><td style="text-align:right;font-family:monospace;font-weight:600;color:#2563eb;">৳${c.total.toLocaleString()}</td><td style="font-size:12px;color:#64748b;">${c.last?new Date(c.last).toLocaleDateString('en-BD',{day:'2-digit',month:'short',year:'numeric'}):''}</td></tr>`).join('');
}

// REPORTS
function renderReports(){
  const rev=bills.reduce((s,b)=>s+b.grandTotal,0);
  const paid=bills.reduce((s,b)=>s+(b.paidAmount||0),0);
  const due=bills.reduce((s,b)=>s+(b.dueAmount||0),0);
  document.getElementById('r-total').textContent=bills.length;
  document.getElementById('r-rev').textContent='৳'+rev.toLocaleString();
  document.getElementById('r-paid').textContent='৳'+paid.toLocaleString();
  document.getElementById('r-due').textContent='৳'+due.toLocaleString();
  const bk={};
  bills.forEach(b=>b.items.forEach(i=>{bk[i.t]=(bk[i.t]||0)+i.q*i.p;}));
  const mx=Math.max(...Object.values(bk),1);
  const colors={Service:'#2563eb',Part:'#7c3aed',Labor:'#16a34a'};
  document.getElementById('r-breakdown').innerHTML=Object.entries(bk).map(([k,v])=>`<div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;"><div style="width:70px;font-size:13px;color:#475569;font-weight:500;">${k}</div><div style="flex:1;height:10px;background:#f1f5f9;border-radius:99px;overflow:hidden;"><div style="height:100%;width:${(v/mx*100).toFixed(1)}%;background:${colors[k]||'#2563eb'};border-radius:99px;"></div></div><div style="width:90px;text-align:right;font-family:'DM Mono',monospace;font-size:13px;font-weight:600;">৳${v.toLocaleString()}</div></div>`).join('')||'<p style="color:#94a3b8;font-size:13px;">No data</p>';
}

// SETTINGS
function loadSettings(){
  document.getElementById('st-name').value=settings.name||'';
  document.getElementById('st-address').value=settings.address||'';
  document.getElementById('st-phone').value=settings.phone||'';
  document.getElementById('st-email').value=settings.email||'';
  document.getElementById('st-web').value=settings.web||'';
}
function saveSettings(){
  settings={name:document.getElementById('st-name').value,address:document.getElementById('st-address').value,phone:document.getElementById('st-phone').value,email:document.getElementById('st-email').value,web:document.getElementById('st-web').value};
  localStorage.setItem('ws_settings',JSON.stringify(settings));
  showToast('Settings saved','s');
}

// DASHBOARD
function updateDash(){
  const today=new Date().toDateString();
  const tb=bills.filter(b=>new Date(b.date).toDateString()===today);
  const rev=bills.reduce((s,b)=>s+b.grandTotal,0);
  const paid=bills.reduce((s,b)=>s+(b.paidAmount||0),0);
  const due=bills.reduce((s,b)=>s+(b.dueAmount||0),0);
  const custs=new Set(bills.map(b=>b.customer.phone||b.customer.name)).size;
  document.getElementById('s-total').textContent=bills.length;
  document.getElementById('s-rev').textContent='৳'+rev.toLocaleString();
  document.getElementById('s-paid').textContent='৳'+paid.toLocaleString();
  document.getElementById('s-due').textContent='৳'+due.toLocaleString();
  document.getElementById('s-today').textContent=tb.length;
  document.getElementById('s-cust').textContent=custs;
  const tbody=document.getElementById('dash-tbody');
  const rec=[...bills].reverse().slice(0,7);
  if(!rec.length){tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:28px;color:#94a3b8;font-size:13px;">No invoices yet. <a href="#" onclick="go(\'new-bill\')" style="color:#2563eb;">Create one?</a></td></tr>';return;}
  const bc=s=>s==='paid'?'b-paid':s==='pending'?'b-pending':'b-due';
  const bl=s=>s==='paid'?'Paid':s==='pending'?'Partial':'Due';
  tbody.innerHTML=rec.map(b=>`<tr><td style="font-family:monospace;color:#2563eb;font-weight:600;">${b.id}</td><td style="font-weight:500;">${b.customer.name}</td><td style="font-size:12px;color:#64748b;">${b.vehicle.number||b.vehicle.model||'—'}</td><td style="font-size:12px;color:#64748b;">${new Date(b.date).toLocaleDateString('en-BD',{day:'2-digit',month:'short'})}</td><td style="text-align:right;font-family:monospace;font-weight:600;">৳${Number(b.grandTotal).toLocaleString()}</td><td><span class="badge ${bc(b.status)}">${bl(b.status)}</span></td><td><button onclick='openInv(bills.find(x=>x.id==="'+b.id+'"))' class="btn btn-gray btn-sm"><i class="fas fa-eye"></i></button></td></tr>`).join('');
}

// TOAST
function showToast(msg,type='s'){
  const s={s:{bg:'#f0fdf4',c:'#15803d',b:'#bbf7d0',i:'fa-circle-check'},w:{bg:'#fffbeb',c:'#854d0e',b:'#fde68a',i:'fa-triangle-exclamation'}};
  const x=s[type]||s.s;
  const ti=document.getElementById('toast-inner');
  ti.style.cssText=`display:flex;align-items:center;gap:9px;padding:11px 16px;border-radius:9px;font-size:13px;font-weight:600;box-shadow:0 6px 20px rgba(0,0,0,.12);background:${x.bg};color:${x.c};border:1px solid ${x.b};`;
  document.getElementById('toast-icon').className='fas '+x.i;
  document.getElementById('toast-msg').textContent=msg;
  const t=document.getElementById('toast');
  t.style.display='block';
  setTimeout(()=>t.style.display='none',3000);
}

// INIT
renderItems(); updateDash(); loadSettings();
</script>
</body>
</html>