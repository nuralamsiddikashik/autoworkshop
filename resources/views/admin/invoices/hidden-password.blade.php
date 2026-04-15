@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap');

    .hidden-page {
        font-family: 'DM Sans', sans-serif;
        padding: 2rem 1.5rem;
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, rgba(16, 185, 129, 0.12), transparent 30%),
            linear-gradient(180deg, #F8FAFC 0%, #EEF2FF 100%);
    }

    .hidden-shell {
        max-width: 540px;
        margin: 0 auto;
    }

    .hidden-head {
        margin-bottom: 20px;
    }

    .hidden-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background: #E2E8F0;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .hidden-title {
        margin-top: 16px;
        font-size: 28px;
        font-weight: 700;
        color: #0F172A;
    }

    .hidden-subtitle {
        margin-top: 8px;
        font-size: 15px;
        color: #64748B;
        line-height: 1.7;
    }

    .access-card {
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(148, 163, 184, 0.3);
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(12px);
    }

    .field-label {
        display: block;
        margin-bottom: 10px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .field-input {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #CBD5E1;
        border-radius: 12px;
        background: #FFFFFF;
        color: #0F172A;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    .field-input:focus {
        border-color: #0F766E;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.12);
    }

    .helper-text {
        margin-top: 10px;
        font-size: 13px;
        color: #64748B;
        line-height: 1.6;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 22px;
    }

    .btn-submit,
    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-submit {
        background: linear-gradient(135deg, #0F766E, #10B981);
        color: #FFFFFF;
        min-width: 180px;
    }

    .btn-submit:hover { transform: translateY(-1px); }

    .btn-back {
        background: #FFFFFF;
        color: #475569;
        border: 1px solid #CBD5E1;
    }

    .btn-back:hover { background: #F8FAFC; }

    .alert {
        margin-bottom: 16px;
        padding: 14px 16px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #047857;
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #B91C1C;
    }
</style>

<div class="hidden-page">
    <div class="hidden-shell">
        <div class="hidden-head">
            <span class="hidden-kicker">Protected Route</span>
            <h1 class="hidden-title">Hidden Invoice Access</h1>
            <p class="hidden-subtitle">
                Enter the password to open the hidden invoice list. Hidden invoices stay out of the normal invoice list until you show them again.
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('password'))
            <div class="alert alert-error">
                {{ $errors->first('password') }}
            </div>
        @endif

        @if($errors->has('error'))
            <div class="alert alert-error">
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="access-card">
            <form action="{{ route('invoices.hidden.unlock') }}" method="POST">
                @csrf

                <label for="password" class="field-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="field-input"
                    placeholder="Enter hidden list password"
                    autocomplete="off"
                    required
                >

                <p class="helper-text">
                    After the correct password is entered, all individually hidden invoices will appear in the hidden invoice list.
                </p>

                <div class="actions">
                    <button type="submit" class="btn-submit">Open Hidden Invoices</button>
                    <a href="{{ route('invoices.index') }}" class="btn-back">Back to Invoice List</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
