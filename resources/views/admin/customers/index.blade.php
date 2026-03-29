@extends('layouts.app')

@section('content')

<div style="padding: 24px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700; color: #1e293b;">Customer Management</h2>
        
        {{-- Success Message --}}
        @if(session('success'))
            <div id="success-alert" style="background: #dcfce7; color: #15803d; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; border: 1px solid #bbf7d0;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif 
    </div>

    <div style="display: grid; grid-template-columns: 350px 1fr; gap: 24px; align-items: start;">

        {{-- 🔥 Form Section (Create + Edit) --}}
        <div class="stat-card" style="position: sticky; top: 80px;">
            <div style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                <h3 style="font-size: 15px; font-weight: 700; color: #334155;">
                    {{ isset($editCustomer) ? 'Update Customer Details' : 'Register New Customer' }}
                </h3>
            </div>

            <form method="POST" action="{{ isset($editCustomer) ? route('customers.update', $editCustomer->id) : route('customers.store') }}">
                @csrf
                @if(isset($editCustomer)) @method('PUT') @endif

                <div style="margin-bottom: 15px;">
                    <label class="lbl">Account Name</label>
                    <input type="text" name="account_name" class="inp" placeholder="e.g. Acme Corp"
                        value="{{ old('account_name', $editCustomer->account_name ?? '') }}" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="lbl">Customer Name</label>
                    <input type="text" name="customer_name" class="inp" placeholder="e.g. John Doe"
                        value="{{ old('customer_name', $editCustomer->customer_name ?? '') }}" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label class="lbl">Address</label>
                    <textarea name="address" class="inp" rows="2" placeholder="Full address...">{{ old('address', $editCustomer->address ?? '') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                    <div>
                        <label class="lbl">Owner Phone</label>
                        {{-- type="tel" ব্যবহার করা হয়েছে --}}
                        <input type="tel" name="owner_phone" class="inp" placeholder="017xxxxxxxx"
                            value="{{ old('owner_phone', $editCustomer->owner_phone ?? '') }}" required>
                    </div>
                    <div>
                        <label class="lbl">Office Phone</label>
                        <input type="tel" name="office_phone" class="inp" placeholder="02xxxxxxx"
                            value="{{ old('office_phone', $editCustomer->office_phone ?? '') }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 15px;">
                    <div>
                        <label class="lbl">Transport Phone</label>
                        <input type="tel" name="transport_phone" class="inp" placeholder="018xxxxxxxx"
                            value="{{ old('transport_phone', $editCustomer->transport_phone ?? '') }}">
                    </div>
                    <div>
                        <label class="lbl">Driver Phone</label>
                        <input type="tel" name="driver_phone" class="inp" placeholder="019xxxxxxxx"
                            value="{{ old('driver_phone', $editCustomer->driver_phone ?? '') }}">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="lbl">Account Status</label>
                    <select name="is_active" class="inp">
                        <option value="1" {{ (old('is_active', $editCustomer->is_active ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ (old('is_active', $editCustomer->is_active ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-blue" style="width: 100%; justify-content: center; padding: 10px;">
                    <i class="fas {{ isset($editCustomer) ? 'fa-save' : 'fa-plus' }}"></i> 
                    {{ isset($editCustomer) ? 'Update Customer' : 'Create Customer' }}
                </button>

                @if(isset($editCustomer))
                    <a href="{{ route('customers.index') }}" class="btn btn-gray" style="width: 100%; justify-content: center; margin-top: 10px; padding: 10px;">
                        Cancel Editing
                    </a>
                @endif
            </form>
        </div>

        {{-- 📋 Customer List Section --}}
        <div class="stat-card" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                <h3 style="font-size: 14px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Registered Customers</h3>
                <div style="position: relative;">
                    <input type="text" placeholder="Filter customers..." class="inp" style="padding-left: 32px; height: 32px; width: 200px; font-size: 12px;">
                    <i class="fas fa-filter" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 11px;"></i>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">#</th>
                            <th>Account Info</th>
                            <th>Contact Details</th>
                            <th>Status</th>
                            <th style="width: 120px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $key => $customer)
                        <tr>
                            <td style="text-align: center; color: #94a3b8; font-family: 'DM Mono', monospace;">{{ $key + 1 }}</td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ $customer->account_name }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $customer->customer_name }}</div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-phone-alt" style="font-size: 11px; color: #2563eb;"></i>
                                    <span style="font-family: 'DM Mono', monospace; font-size: 13px;">{{ $customer->owner_phone }}</span>
                                </div>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">{{ Str::limit($customer->address, 30) }}</div>
                            </td>
                            <td>
                                @if($customer->is_active)
                                    <span class="badge b-paid" style="padding: 2px 10px;">Active</span>
                                @else
                                    <span class="badge b-due" style="padding: 2px 10px;">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-gray btn-sm" title="Edit">
                                        <i class="fas fa-pen" style="font-size: 10px;"></i>
                                    </a>

                                    <form action="{{ route('customers.delete', $customer->id) }}" method="POST" onsubmit="return confirm('Delete this customer?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-red btn-sm" title="Delete">
                                            <i class="fas fa-trash" style="font-size: 10px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-users" style="font-size: 24px; display: block; margin-bottom: 10px; opacity: 0.3;"></i>
                                No customers found in the system.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    #success-alert {
        animation: slideIn 0.3s ease;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if(alert) alert.style.display = 'none';
    }, 5000);
</script>

@endsection