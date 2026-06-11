@extends('layouts.student_app')

@section('title','My Fees')

@section('content')

<div class="card">

<div class="card-header">

My Fee Information

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>Invoice</th>
<th>Amount</th>
<th>Paid</th>
<th>Due</th>
<th>Status</th>

</tr>

@foreach($fees as $fee)

<tr>

<td>

{{ $fee->invoice_no }}

</td>

<td>

{{ $fee->amount }}

</td>

<td>

{{ $fee->paid_amount }}

</td>

<td>

{{ $fee->due_amount }}

</td>

<td>

{{ ucfirst($fee->status) }}

</td>

</tr>

@endforeach

</table>

{{ $fees->links() }}

</div>

</div>

@endsection