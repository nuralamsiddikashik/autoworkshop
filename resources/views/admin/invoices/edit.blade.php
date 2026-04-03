@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Edit Invoice</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Job Card --}}
        <div class="mb-3">
            <label>Job Card ID</label>
            <input type="text" name="job_card_id" value="{{ $invoice->job_card_id }}" class="form-control">
        </div>

        {{-- ================= PARTS ================= --}}
        <h4>Parts</h4>
        <table class="table" id="parts-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Buy</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Sell</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->parts as $index => $item)
                <tr>
                    <td><input name="parts[{{ $index }}][name]" value="{{ $item->name }}" class="form-control"></td>
                    <td><input name="parts[{{ $index }}][qty]" value="{{ $item->qty }}" class="form-control"></td>
                    <td><input name="parts[{{ $index }}][buy_price]" value="{{ $item->buy_price }}" class="form-control"></td>

                    <td>
                        <select name="parts[{{ $index }}][unit]" class="form-control">
                            @foreach(config('invoice.units') as $unit)
                                <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input name="parts[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" class="form-control"></td>
                    <td><input name="parts[{{ $index }}][sell_price]" value="{{ $item->sell_price }}" class="form-control"></td>

                    <td><button type="button" onclick="removeRow(this)">X</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" onclick="addRow('parts')">+ Add Part</button>


        {{-- ================= WORKS ================= --}}
        <h4 class="mt-4">Works</h4>
        <table class="table" id="works-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Buy</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Sell</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->works as $index => $item)
                <tr>
                    <td><input name="works[{{ $index }}][name]" value="{{ $item->name }}" class="form-control"></td>
                    <td><input name="works[{{ $index }}][qty]" value="{{ $item->qty }}" class="form-control"></td>
                    <td><input name="works[{{ $index }}][buy_price]" value="{{ $item->buy_price }}" class="form-control"></td>

                    <td>
                        <select name="works[{{ $index }}][unit]" class="form-control">
                            @foreach(config('invoice.units') as $unit)
                                <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input name="works[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" class="form-control"></td>
                    <td><input name="works[{{ $index }}][sell_price]" value="{{ $item->sell_price }}" class="form-control"></td>

                    <td><button type="button" onclick="removeRow(this)">X</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" onclick="addRow('works')">+ Add Work</button>


        {{-- ================= SERVICES ================= --}}
        <h4 class="mt-4">Services</h4>
        <table class="table" id="services-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Buy</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Sell</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->services as $index => $item)
                <tr>
                    <td><input name="services[{{ $index }}][name]" value="{{ $item->name }}" class="form-control"></td>
                    <td><input name="services[{{ $index }}][qty]" value="{{ $item->qty }}" class="form-control"></td>
                    <td><input name="services[{{ $index }}][buy_price]" value="{{ $item->buy_price }}" class="form-control"></td>

                    <td>
                        <select name="services[{{ $index }}][unit]" class="form-control">
                            @foreach(config('invoice.units') as $unit)
                                <option value="{{ $unit }}" {{ $item->unit == $unit ? 'selected' : '' }}>
                                    {{ $unit }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input name="services[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" class="form-control"></td>
                    <td><input name="services[{{ $index }}][sell_price]" value="{{ $item->sell_price }}" class="form-control"></td>

                    <td><button type="button" onclick="removeRow(this)">X</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" onclick="addRow('services')">+ Add Service</button>

        <br><br>

        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>

@endsection


{{-- ================= JS ================= --}}
<script>
function addRow(type) {
    let table = document.querySelector(`#${type}-table tbody`);
    let index = table.children.length;

    let row = `
        <tr>
            <td><input name="${type}[${index}][name]" class="form-control"></td>
            <td><input name="${type}[${index}][qty]" class="form-control"></td>
            <td><input name="${type}[${index}][buy_price]" class="form-control"></td>

            <td>
                <select name="${type}[${index}][unit]" class="form-control">
                    @foreach(config('invoice.units') as $unit)
                        <option value="{{ $unit }}">{{ $unit }}</option>
                    @endforeach
                </select>
            </td>

            <td><input name="${type}[${index}][unit_price]" class="form-control"></td>
            <td><input name="${type}[${index}][sell_price]" class="form-control"></td>

            <td><button type="button" onclick="removeRow(this)">X</button></td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>