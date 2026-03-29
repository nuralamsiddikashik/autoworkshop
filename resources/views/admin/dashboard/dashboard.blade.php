@extends('layouts.app')

@section('content')

  <!-- CONTENT -->
  

    <!-- ===== DASHBOARD ===== -->
    <div class="pg on" id="pg-dashboard">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
          <h1 style="font-size:20px;font-weight:700;color:#1e293b;">Welcome Dashboard</h1>
          <p style="font-size:12px;color:#94a3b8;margin-top:2px;" id="dash-time"></p>
        </div>
        <button class="btn btn-blue noprint" onclick="go('new-bill')"><i class="fas fa-plus"></i> New Invoice</button>
      </div>

      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px;margin-bottom:20px;">
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Total Invoices</span>
            <div style="width:34px;height:34px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-file-invoice" style="color:#2563eb;font-size:14px;"></i></div>
          </div>
          <div style="font-size:30px;font-weight:800;color:#1e293b;" id="s-total">0</div>
        </div>
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Total Revenue</span>
            <div style="width:34px;height:34px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-coins" style="color:#16a34a;font-size:14px;"></i></div>
          </div>
          <div style="font-size:24px;font-weight:800;color:#1e293b;font-family:'DM Mono',monospace;" id="s-rev">৳0</div>
        </div>
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Collected</span>
            <div style="width:34px;height:34px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-circle-check" style="color:#16a34a;font-size:14px;"></i></div>
          </div>
          <div style="font-size:24px;font-weight:800;color:#16a34a;font-family:'DM Mono',monospace;" id="s-paid">৳0</div>
        </div>
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Due</span>
            <div style="width:34px;height:34px;background:#fff1f2;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-clock" style="color:#e11d48;font-size:14px;"></i></div>
          </div>
          <div style="font-size:24px;font-weight:800;color:#e11d48;font-family:'DM Mono',monospace;" id="s-due">৳0</div>
        </div>
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Today</span>
            <div style="width:34px;height:34px;background:#faf5ff;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-calendar-day" style="color:#7c3aed;font-size:14px;"></i></div>
          </div>
          <div style="font-size:30px;font-weight:800;color:#1e293b;" id="s-today">0</div>
        </div>
        <div class="stat-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <span style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Customers</span>
            <div style="width:34px;height:34px;background:#fff7ed;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-users" style="color:#ea580c;font-size:14px;"></i></div>
          </div>
          <div style="font-size:30px;font-weight:800;color:#1e293b;" id="s-cust">0</div>
        </div>
      </div>

      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid #f1f5f9;">
          <h2 style="font-size:14px;font-weight:700;color:#1e293b;">Recent Invoices</h2>
          <button class="btn btn-gray btn-sm" onclick="go('bill-list')">View All</button>
        </div>
        <div style="overflow-x:auto;"><table class="tbl"><thead><tr>
          <th>Invoice #</th><th>Customer</th><th>Vehicle</th><th>Date</th><th style="text-align:right;">Amount</th><th>Status</th><th>Action</th>
        </tr></thead><tbody id="dash-tbody"><tr><td colspan="7" style="text-align:center;padding:32px;color:#94a3b8;">No invoices yet.</td></tr></tbody></table></div>
      </div>
    </div>

    <!-- ===== NEW BILL ===== -->
    <div class="pg" id="pg-new-bill">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
        <div><h1 style="font-size:20px;font-weight:700;color:#1e293b;">New Invoice</h1><p style="font-size:12px;color:#94a3b8;">Create a new service invoice</p></div>
        <button class="btn btn-gray" onclick="go('bill-list')"><i class="fas fa-list"></i> Invoice List</button>
      </div>

      <div style="display:grid;grid-template-columns:1fr 320px;gap:18px;align-items:start;">
        <!-- LEFT -->
        <div style="display:flex;flex-direction:column;gap:14px;">

          <!-- Customer -->
          <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px;">
            <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:14px;"><i class="fas fa-user" style="color:#2563eb;margin-right:6px;"></i>Customer & Vehicle Info</h3>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
              <div><label class="lbl">Customer Name *</label><input type="text" id="f-name" class="inp" placeholder="Full name"></div>
              <div><label class="lbl">Mobile Number</label><input type="text" id="f-phone" class="inp" placeholder="01XXXXXXXXX"></div>
              <div><label class="lbl">Vehicle Type</label><select id="f-vtype" class="inp"><option value="">Select type</option><option>Car / Sedan</option><option>SUV / Jeep</option><option>Microbus</option><option>Pickup / Truck</option><option>Motorcycle</option><option>CNG / Auto</option><option>Other</option></select></div>
              <div><label class="lbl">Vehicle Number</label><input type="text" id="f-vnum" class="inp" placeholder="e.g. Dhaka Metro Ka 11-2234"></div>
              <div><label class="lbl">Brand / Model</label><input type="text" id="f-vmodel" class="inp" placeholder="e.g. Toyota Corolla 2019"></div>
              <div><label class="lbl">Mileage (km)</label><input type="number" id="f-mileage" class="inp" placeholder="e.g. 45000"></div>
              <div style="grid-column:span 2;"><label class="lbl">Problem Description</label><textarea id="f-problem" class="inp" rows="2" placeholder="Customer complaint or issue..."></textarea></div>
            </div>
          </div>

          <!-- Items -->
          <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px;">
            <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:10px;"><i class="fas fa-wrench" style="color:#2563eb;margin-right:6px;"></i>Services & Parts</h3>
            <div style="margin-bottom:12px;">
              <p style="font-size:11px;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:6px;">Quick Add</p>
              <div style="display:flex;flex-wrap:wrap;gap:6px;">
                <button class="btn btn-gray btn-sm" onclick="qa('Engine Oil Change',500,'Service')"><i class="fas fa-oil-can"></i> Engine Oil</button>
                <button class="btn btn-gray btn-sm" onclick="qa('Brake Pad Replace',1200,'Part')"><i class="fas fa-circle-stop"></i> Brake Pad</button>
                <button class="btn btn-gray btn-sm" onclick="qa('Air Filter Change',300,'Part')"><i class="fas fa-wind"></i> Air Filter</button>
                <button class="btn btn-gray btn-sm" onclick="qa('Tire Change',2000,'Part')"><i class="fas fa-circle-notch"></i> Tire</button>
                <button class="btn btn-gray btn-sm" onclick="qa('Washing & Polish',400,'Service')"><i class="fas fa-soap"></i> Wash</button>
                <button class="btn btn-gray btn-sm" onclick="qa('Electrical Check',700,'Service')"><i class="fas fa-bolt"></i> Electrical</button>
                <button class="btn btn-gray btn-sm" onclick="qa('AC Service',1500,'Service')"><i class="fas fa-snowflake"></i> AC</button>
              </div>
            </div>
            <div style="border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;margin-bottom:10px;">
              <table class="tbl"><thead><tr>
                <th>Description</th><th>Type</th><th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Price</th><th style="text-align:right;">Total</th><th></th>
              </tr></thead><tbody id="items-body"><tr><td colspan="6" style="text-align:center;padding:18px;color:#94a3b8;font-size:12px;">No items added</td></tr></tbody></table>
            </div>
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1.2fr auto;gap:8px;align-items:end;">
              <div><label class="lbl">Description</label><input type="text" id="i-name" class="inp" placeholder="Item name"></div>
              <div><label class="lbl">Type</label><select id="i-type" class="inp"><option>Service</option><option>Part</option><option>Labor</option></select></div>
              <div><label class="lbl">Qty</label><input type="number" id="i-qty" class="inp" value="1" min="1"></div>
              <div><label class="lbl">Price (৳)</label><input type="number" id="i-price" class="inp" placeholder="0"></div>
              <div><label class="lbl" style="visibility:hidden;">x</label><button class="btn btn-blue" onclick="addItem()"><i class="fas fa-plus"></i> Add</button></div>
            </div>
          </div>

          <!-- Mechanic -->
          <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
              <div><label class="lbl">Mechanic Name</label><input type="text" id="f-mechanic" class="inp" placeholder="Responsible mechanic"></div>
              <div><label class="lbl">Payment Method</label><select id="f-paymethod" class="inp"><option>Cash</option><option>Bkash</option><option>Nagad</option><option>Bank Transfer</option><option>Card</option></select></div>
              <div style="grid-column:span 2;"><label class="lbl">Notes</label><textarea id="f-notes" class="inp" rows="2" placeholder="Next service date, special instructions..."></textarea></div>
            </div>
          </div>
        </div>

        <!-- RIGHT SUMMARY -->
        <div style="position:sticky;top:68px;">
          <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px;">
            <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:14px;"><i class="fas fa-calculator" style="color:#2563eb;margin-right:6px;"></i>Invoice Summary</h3>
            <div style="border:1px solid #f1f5f9;border-radius:8px;overflow:hidden;margin-bottom:12px;font-size:13px;">
              <div style="display:flex;justify-content:space-between;padding:9px 12px;border-bottom:1px solid #f1f5f9;"><span style="color:#64748b;">Service</span><span style="font-family:'DM Mono',monospace;font-weight:500;" id="ss-svc">৳ 0.00</span></div>
              <div style="display:flex;justify-content:space-between;padding:9px 12px;border-bottom:1px solid #f1f5f9;"><span style="color:#64748b;">Parts</span><span style="font-family:'DM Mono',monospace;font-weight:500;" id="ss-pts">৳ 0.00</span></div>
              <div style="display:flex;justify-content:space-between;padding:9px 12px;border-bottom:1px solid #f1f5f9;"><span style="color:#64748b;">Labor</span><span style="font-family:'DM Mono',monospace;font-weight:500;" id="ss-lab">৳ 0.00</span></div>
              <div style="display:flex;justify-content:space-between;padding:9px 12px;background:#f8fafc;"><span style="font-weight:600;color:#334155;">Sub Total</span><span style="font-family:'DM Mono',monospace;font-weight:600;" id="ss-sub">৳ 0.00</span></div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px;">
              <div><label class="lbl">Discount</label><div style="display:flex;gap:4px;"><input type="number" id="f-disc" class="inp" placeholder="0" oninput="calcT()" style="flex:1;"><select id="f-disctype" class="inp" onchange="calcT()" style="width:52px;"><option value="flat">৳</option><option value="pct">%</option></select></div></div>
              <div><label class="lbl">VAT %</label><input type="number" id="f-vat" class="inp" placeholder="0" oninput="calcT()"></div>
            </div>
            <div style="background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:8px;padding:12px;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center;">
              <span style="font-size:14px;font-weight:700;color:#1e293b;">Grand Total</span>
              <span style="font-size:20px;font-weight:800;color:#2563eb;font-family:'DM Mono',monospace;" id="ss-grand">৳ 0.00</span>
            </div>
            <div style="margin-bottom:8px;"><label class="lbl">Amount Paid (৳)</label><input type="number" id="f-paid" class="inp" placeholder="0.00" oninput="calcDue()"></div>
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:8px;padding:9px 12px;display:flex;justify-content:space-between;margin-bottom:10px;">
              <span style="font-size:13px;font-weight:600;color:#be123c;">Due Amount</span>
              <span style="font-family:'DM Mono',monospace;font-weight:700;color:#be123c;" id="ss-due">৳ 0.00</span>
            </div>
            <div style="margin-bottom:14px;"><label class="lbl">Payment Status</label><select id="f-status" class="inp"><option value="paid">Paid ✓</option><option value="pending">Partially Paid</option><option value="due">Due / Unpaid</option></select></div>
            <button class="btn btn-blue" style="width:100%;justify-content:center;padding:10px;font-size:14px;margin-bottom:7px;" onclick="saveBill()"><i class="fas fa-save"></i> Save Invoice</button>
            <button class="btn btn-gray" style="width:100%;justify-content:center;margin-bottom:7px;" onclick="previewCurrent()"><i class="fas fa-eye"></i> Preview</button>
            <button class="btn btn-red" style="width:100%;justify-content:center;" onclick="clearForm()"><i class="fas fa-trash"></i> Clear Form</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== BILL LIST ===== -->
    <div class="pg" id="pg-bill-list">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
        <div><h1 style="font-size:20px;font-weight:700;color:#1e293b;">Invoice List</h1></div>
        <button class="btn btn-blue noprint" onclick="go('new-bill')"><i class="fas fa-plus"></i> New Invoice</button>
      </div>
      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="display:flex;align-items:center;gap:10px;padding:14px 18px;border-bottom:1px solid #f1f5f9;flex-wrap:wrap;">
          <div style="position:relative;flex:1;min-width:180px;">
            <input type="text" id="bl-q" placeholder="Search name, invoice #, vehicle..." class="inp" style="padding-left:34px;" oninput="renderBL()">
            <i class="fas fa-search" style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:12px;"></i>
          </div>
          <select id="bl-st" class="inp" style="width:150px;" onchange="renderBL()"><option value="">All Status</option><option value="paid">Paid</option><option value="pending">Partially Paid</option><option value="due">Due</option></select>
        </div>
        <div style="overflow-x:auto;"><table class="tbl"><thead><tr>
          <th>Invoice #</th><th>Customer</th><th>Vehicle</th><th>Date</th>
          <th style="text-align:right;">Amount</th><th style="text-align:right;">Paid</th>
          <th style="text-align:right;">Due</th><th>Status</th><th>Action</th>
        </tr></thead><tbody id="bl-tbody"><tr><td colspan="9" style="text-align:center;padding:32px;color:#94a3b8;">No invoices found</td></tr></tbody></table></div>
      </div>
    </div>

    <!-- ===== CUSTOMERS ===== -->
    <div class="pg" id="pg-customers">
      <div style="margin-bottom:18px;"><h1 style="font-size:20px;font-weight:700;color:#1e293b;">Customer List</h1></div>
      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="overflow-x:auto;"><table class="tbl"><thead><tr>
          <th>#</th><th>Name</th><th>Phone</th><th>Total Bills</th><th style="text-align:right;">Total Amount</th><th>Last Visit</th>
        </tr></thead><tbody id="cust-tbody"><tr><td colspan="6" style="text-align:center;padding:32px;color:#94a3b8;">No customers yet</td></tr></tbody></table></div>
      </div>
    </div>

    <!-- ===== REPORTS ===== -->
    <div class="pg" id="pg-reports">
      <div style="margin-bottom:18px;"><h1 style="font-size:20px;font-weight:700;color:#1e293b;">Accounting Reports</h1></div>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px;margin-bottom:18px;">
        <div class="stat-card"><p style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Total Invoices</p><p style="font-size:30px;font-weight:800;color:#1e293b;margin-top:6px;" id="r-total">0</p></div>
        <div class="stat-card"><p style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Gross Revenue</p><p style="font-size:24px;font-weight:800;color:#2563eb;margin-top:6px;font-family:'DM Mono',monospace;" id="r-rev">৳0</p></div>
        <div class="stat-card"><p style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Collected</p><p style="font-size:24px;font-weight:800;color:#16a34a;margin-top:6px;font-family:'DM Mono',monospace;" id="r-paid">৳0</p></div>
        <div class="stat-card"><p style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Outstanding</p><p style="font-size:24px;font-weight:800;color:#e11d48;margin-top:6px;font-family:'DM Mono',monospace;" id="r-due">৳0</p></div>
      </div>
      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:18px;">
        <h3 style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:14px;">Revenue by Category</h3>
        <div id="r-breakdown"><p style="color:#94a3b8;font-size:13px;">No data</p></div>
      </div>
    </div>

    <!-- ===== ACCOUNTS ===== -->
    <div class="pg" id="pg-accounts">
      <h1 style="font-size:20px;font-weight:700;color:#1e293b;margin-bottom:18px;">Accounts</h1>
      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:40px;text-align:center;color:#94a3b8;"><i class="fas fa-wallet" style="font-size:40px;margin-bottom:10px;opacity:.3;display:block;"></i>Accounts module — coming soon</div>
    </div>

    <!-- ===== SETTINGS ===== -->
    <div class="pg" id="pg-settings">
      <div style="margin-bottom:18px;"><h1 style="font-size:20px;font-weight:700;color:#1e293b;">Settings</h1></div>
      <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:24px;max-width:520px;">
        <div style="display:grid;gap:12px;">
          <div><label class="lbl">Workshop Name</label><input type="text" id="st-name" class="inp" placeholder="Your workshop name"></div>
          <div><label class="lbl">Address</label><textarea id="st-address" class="inp" rows="2" placeholder="Full address"></textarea></div>
          <div><label class="lbl">Phone</label><input type="text" id="st-phone" class="inp" placeholder="01XXXXXXXXX"></div>
          <div><label class="lbl">Email</label><input type="email" id="st-email" class="inp" placeholder="info@workshop.com"></div>
          <div><label class="lbl">Website</label><input type="text" id="st-web" class="inp" placeholder="www.workshop.com"></div>
          <div style="display:flex;gap:8px;padding-top:4px;">
            <button class="btn btn-blue" onclick="saveSettings()"><i class="fas fa-save"></i> Save Settings</button>
            <button class="btn btn-red" onclick="if(confirm('Delete ALL data?')){bills=[];localStorage.removeItem('ws_bills');updateDash();showToast('All data cleared','w');}"><i class="fas fa-trash"></i> Clear All Data</button>
          </div>
        </div>
      </div>
    </div>



@endsection