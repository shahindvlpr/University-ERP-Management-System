@extends('layouts.student_app')

@section('title', 'My Fees & Payments')

@section('content')

<style>
    .fees-wrapper {
        padding: 20px 0;
    }

    /* Summary Cards */
    .summary-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .summary-card.total-fees::before {
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .summary-card.paid-fees::before {
        background: linear-gradient(90deg, #43e97b, #38f9d7);
    }

    .summary-card.due-fees::before {
        background: linear-gradient(90deg, #fa709a, #fee140);
    }

    .summary-card.overdue::before {
        background: linear-gradient(90deg, #ff0844, #ffb199);
    }

    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .summary-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 5px;
    }

    /* Payment Progress */
    .payment-progress {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 500;
    }

    .progress-bar-custom {
        height: 10px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    /* Invoice Table */
    .invoice-table {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .invoice-table .table {
        margin-bottom: 0;
    }

    .invoice-table .table thead th {
        background: #f8f9fa;
        padding: 15px;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .invoice-table .table tbody td {
        padding: 15px;
        vertical-align: middle;
        font-size: 14px;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-paid {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-partial {
        background: #dbeafe;
        color: #1e40af;
    }

    .pay-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .pay-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102,126,234,0.4);
    }

    /* Payment History */
    .payment-history {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .history-timeline {
        position: relative;
        padding-left: 30px;
    }

    .history-item {
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-left: 2px solid #e9ecef;
        padding-left: 20px;
    }

    .history-item::before {
        content: '';
        position: absolute;
        left: -7px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }

    .history-date {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .history-amount {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
    }

    .history-method {
        font-size: 12px;
        color: #6c757d;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .pagination-wrapper {
        padding: 20px;
        background: white;
        border-radius: 0 0 20px 20px;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #667eea;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .summary-value {
            font-size: 22px;
        }
        .invoice-table .table {
            font-size: 12px;
        }
        .invoice-table .table thead th,
        .invoice-table .table tbody td {
            padding: 10px;
        }
        .pay-btn {
            padding: 4px 12px;
            font-size: 11px;
        }
    }
</style>

<div class="fees-wrapper">
    @php
        $totalFees = $fees->sum('amount');
        $totalPaid = $fees->sum('paid_amount');
        $totalDue = $fees->sum('due_amount');
        $paymentPercentage = $totalFees > 0 ? round(($totalPaid / $totalFees) * 100) : 0;
        $overdueInvoices = $fees->where('due_amount', '>', 0)->where('due_date', '<', now())->count();
        
        // Sample payment history (you can replace with actual data from controller)
        $paymentHistory = [
            ['date' => '2024-12-15', 'amount' => 25000, 'method' => 'bKash', 'transaction_id' => 'TRX123456'],
            ['date' => '2024-11-10', 'amount' => 25000, 'method' => 'Credit Card', 'transaction_id' => 'TRX123457'],
            ['date' => '2024-10-05', 'amount' => 25000, 'method' => 'Bank Transfer', 'transaction_id' => 'TRX123458'],
        ];
    @endphp

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="summary-card total-fees">
                <div class="summary-icon" style="background: rgba(102,126,234,0.1); color: #667eea;">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="summary-label">Total Fees</div>
                <div class="summary-value">৳ {{ number_format($totalFees) }}</div>
                <small class="text-muted">Including all charges</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card paid-fees">
                <div class="summary-icon" style="background: rgba(67,233,123,0.1); color: #43e97b;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-label">Total Paid</div>
                <div class="summary-value">৳ {{ number_format($totalPaid) }}</div>
                <small class="text-muted">Successfully paid</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card due-fees">
                <div class="summary-icon" style="background: rgba(250,112,154,0.1); color: #fa709a;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="summary-label">Total Due</div>
                <div class="summary-value">৳ {{ number_format($totalDue) }}</div>
                <small class="text-muted">Pending payment</small>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card overdue">
                <div class="summary-icon" style="background: rgba(255,8,68,0.1); color: #ff0844;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="summary-label">Overdue</div>
                <div class="summary-value">{{ $overdueInvoices }}</div>
                <small class="text-muted">Invoices past due date</small>
            </div>
        </div>
    </div>

    {{-- Payment Progress --}}
    <div class="payment-progress">
        <div class="progress-label">
            <span>Payment Progress</span>
            <span><strong>{{ $paymentPercentage }}%</strong> Completed</span>
        </div>
        <div class="progress-bar-custom">
            <div class="progress-fill" style="width: 0%"></div>
        </div>
        <div class="row mt-3 text-center">
            <div class="col-6">
                <small class="text-muted">Paid Amount</small>
                <h6 class="mb-0 text-success">৳ {{ number_format($totalPaid) }}</h6>
            </div>
            <div class="col-6">
                <small class="text-muted">Due Amount</small>
                <h6 class="mb-0 text-warning">৳ {{ number_format($totalDue) }}</h6>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Invoices Table --}}
        <div class="col-lg-8">
            <div class="invoice-table">
                <div style="padding: 20px 20px 0 20px;">
                    <h5 class="section-title" style="margin-bottom: 0; border-bottom: none; padding-bottom: 0;">
                        <i class="fas fa-file-invoice me-2"></i> Fee Invoices
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fees as $fee)
                                @php
                                    $statusClass = match($fee->status) {
                                        'paid' => 'status-paid',
                                        'pending' => 'status-pending',
                                        'overdue' => 'status-overdue',
                                        'partial' => 'status-partial',
                                        default => 'status-pending'
                                    };
                                    $isOverdue = $fee->due_amount > 0 && isset($fee->due_date) && $fee->due_date < now();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $fee->invoice_no }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $fee->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>{{ $fee->description ?? 'Semester Fee' }}</td>
                                    <td>
                                        {{ isset($fee->due_date) ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : 'N/A' }}
                                        @if($isOverdue)
                                            <br><small class="text-danger"><i class="fas fa-clock"></i> Overdue</small>
                                        @endif
                                    </td>
                                    <td>৳ {{ number_format($fee->amount) }}</td>
                                    <td>৳ {{ number_format($fee->paid_amount) }}</td>
                                    <td class="text-warning fw-bold">৳ {{ number_format($fee->due_amount) }}</td>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            @if($fee->status == 'paid')
                                                <i class="fas fa-check-circle me-1"></i>
                                            @elseif($fee->status == 'partial')
                                                <i class="fas fa-hourglass-half me-1"></i>
                                            @else
                                                <i class="fas fa-clock me-1"></i>
                                            @endif
                                            {{ ucfirst($fee->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($fee->due_amount > 0)
                                            <button class="btn pay-btn text-white" onclick="payNow('{{ $fee->invoice_no }}', '{{ $fee->due_amount }}')">
                                                <i class="fas fa-credit-card me-1"></i> Pay Now
                                            </button>
                                        @else
                                            <span class="text-success"><i class="fas fa-check"></i> Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-receipt fa-3x text-muted mb-3 d-block"></i>
                                        No fee records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($fees->hasPages())
                    <div class="pagination-wrapper">
                        {{ $fees->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Payment History & Guidelines --}}
        <div class="col-lg-4">
            {{-- Payment History --}}
            <div class="payment-history mb-4">
                <h5 class="section-title">
                    <i class="fas fa-history me-2"></i> Recent Payments
                </h5>
                <div class="history-timeline">
                    @forelse($paymentHistory as $payment)
                        <div class="history-item">
                            <div class="history-date">
                                <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($payment['date'])->format('d M Y, h:i A') }}
                            </div>
                            <div class="history-amount">
                                ৳ {{ number_format($payment['amount']) }}
                            </div>
                            <div class="history-method">
                                <i class="fas fa-credit-card me-1"></i> {{ $payment['method'] }}
                                <br>
                                <small>Transaction ID: {{ $payment['transaction_id'] }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No payment history</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Payment Guidelines --}}
            <div class="payment-history">
                <h5 class="section-title">
                    <i class="fas fa-info-circle me-2"></i> Payment Guidelines
                </h5>
                <div style="font-size: 13px; line-height: 1.8;">
                    <p class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Pay online via bKash, Nagad, or Credit Card</p>
                    <p class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Bank deposit at any branch of Sonali Bank</p>
                    <p class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Submit proof of payment to accounts office</p>
                    <p class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Late payment fee: 2% per month</p>
                    <p class="mb-0"><i class="fas fa-phone-alt text-primary me-2"></i> Help: 123-456-7890 (Accounts)</p>
                </div>
                <hr class="my-3">
                <div class="text-center">
                    <button class="btn btn-outline-primary w-100" onclick="downloadStatement()">
                        <i class="fas fa-download me-2"></i> Download Fee Statement
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Animate progress bar on load
    window.addEventListener('load', function() {
        const progressFill = document.querySelector('.progress-fill');
        if (progressFill) {
            setTimeout(() => {
                progressFill.style.width = '{{ $paymentPercentage }}%';
            }, 100);
        }
    });

    // Pay Now function
    function payNow(invoiceNo, amount) {
        if (confirm(`Proceed to pay ৳ ${amount} for invoice ${invoiceNo}?`)) {
            // Redirect to payment gateway or show payment modal
            alert('Payment gateway integration - Redirecting to payment page...');
            // window.location.href = `/payment/${invoiceNo}`;
        }
    }

    // Download statement
    function downloadStatement() {
        alert('Downloading fee statement...');
        // window.location.href = '/student/fees/download';
    }
</script>

@endsection