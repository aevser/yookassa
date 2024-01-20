@extends('layouts.app')

@section('content')

    <h2>Payment Form</h2>
    <form action="{{ route('payment.create') }}" method="post">
        @csrf
        <label for="amount">Enter Amount:</label>
        <input type="number" id="amount" name="amount" required placeholder="1300.RUB">
        <button type="submit">Make Payment</button>
    </form>

    <div>
        @if(cache()->has('balance')) {{ cache()->get('balance') }} @else 0 @endif
    </div>

    <table style="width: 30%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
           @forelse($transactions as $transaction)
               <tr>
                   <td> {{ $transaction->id }}</td>
                   <td> {{ $transaction->amount }}</td>
                   <td> {{ $transaction->status }}</td>
                   <td> {{ $transaction->updated_at->format('d-m--Y H:i') }}</td>
               </tr>
           @empty
               <br>
               <tr>
                   <td colspan="4">  Транзакций нет </td>
               </tr>
           @endforelse
        </tbody>
    </table>

@endsection