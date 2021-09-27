<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title> Invoice </title>
    <style>

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 100%;
            height: auto;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-size: 14px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }

        h2 {
            font-weight:normal;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: left;
            margin-top: 11px;
        }

        #logo img {
            height: 55px;
            margin-bottom: 15px;
        }

        #company {

        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.2em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {

        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 5px 10px 7px 10px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td.desc h3, table td.qty h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
            width: 10%;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }


        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total
        {
            font-size: 1.2em;
            text-align: center;
        }

        table td.unit{
            width: 35%;
        }

        table td.desc{
            width: 45%;
        }

        table td.qty{
            width: 5%;
        }

        .status {
            margin-top: 15px;
            padding: 1px 8px 5px;
            font-size: 1.3em;
            width: 80px;
            color: #fff;
            float: right;
            text-align: center;
            display: inline-block;
        }

        .status.unpaid {
            background-color: #E7505A;
        }
        .status.paid {
            background-color: #26C281;
        }
        .status.cancelled {
            background-color: #95A5A6;
        }
        .status.error {
            background-color: #F4D03F;
        }

        table tr.tax .desc {
            text-align: right;
            color: #1BA39C;
        }
        table tr.discount .desc {
            text-align: right;
            color: #E43A45;
        }
        table tr.subtotal .desc {
            text-align: right;
            color: #1d0707;
        }
        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 10px 20px 10px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-bottom: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

        table.billing td {
            background-color: #fff;
        }

        table td div#invoiced_to {
            text-align: left;
        }

        #notes{
            color: #767676;
            font-size: 11px;
        }

    </style>
</head>
<body>
<header class="clearfix">

    <table cellpadding="0" cellspacing="0" class="billing">
        <tr>
            <td>
                <div id="invoiced_to">
                    <small>@lang("app.billedTo"):</small>
                    @if(isset($owner->company_name))
                        <h3 class="name">{{ $owner->company_name }}</h3>
                    @endif
                    @if(isset($owner->email))
                        <h3 class="name">{{ $owner->email }}</h3>
                    @endif

                    @if(isset($owner->address))
                        <div> {{ $owner->address }} </div>
                    @endif
                    @if(isset($owner->website))
                        <div> {{ $owner->website }} </div>
                    @endif
                </div>
            </td>
            <td>
                <div id="company">
                    <small>@lang("app.generatedBy"):</small>
                    <h3 class="name">{{ $vendor }}</h3>
                    @if(isset($street))
                       <div> {{ $street }}</div>
                    @endif
                    @if (isset($location))
                        <div> {{ $location }}</div>
                    @endif
                    @if (isset($phone))
                        <div> {{ $phone }}</div>
                    @endif
                    @if (isset($vendorVat))
                        <div>{{ $vendorVat }}</div>
                    @endif
                    @if (isset($url))
                        <a href="{{ $url }}">{{ $url }}</a>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</header>
<main>
    <div id="details" class="clearfix">

        <div id="invoice">
            <h1>{{ (isset($invoice->id)) ?: $invoice->id }}</h1>
            <div class="date">Issue Date: {{ $invoice->date()->toFormattedDateString() }}</div>
        </div>

    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">@lang("app.description")</th>
            <th class="unit">@lang("app.amount")</th>
        </tr>
        </thead>
        <tbody>
        @php $sr = 1; @endphp
        <tr style="page-break-inside: avoid;">
            <td class="no">{{$sr}}</td>
            <td class="desc">Starting Balance</td>
            <td class="unit">{{ $invoice->startingBalance() }}</td>
        </tr>
        @foreach ($invoice->invoiceItems() as $key => $item)
            @php $sr = $sr +1 @endphp
            <tr style="page-break-inside: avoid;">
                <td class="no">{{ $sr }}</td>
                <td class="desc">{{ $item->description }}</td>
                <td class="unit">{{ $item->total() }}</td>

            </tr>
        @endforeach
        <!-- Display The Subscriptions -->
        @foreach ($invoice->subscriptions() as $key => $subscription)

            <tr>
                <td class="no">{{ $sr }}</td>
                <td class="desc">
                    Subscription ({{ $subscription->quantity }}) -
                    {{ $subscription->startDateAsCarbon()->formatLocalized('%B %e, %Y') }} -
                    {{ $subscription->endDateAsCarbon()->formatLocalized('%B %e, %Y') }}
                </td>
                <td class="unit">{{ $subscription->total() }}</td>
            </tr>
            @php $sr = $sr +1 @endphp
        @endforeach
        <!-- Display The Discount -->
        @if ($invoice->hasDiscount())
            @php $sr = $sr +1 @endphp
            <tr>
                <td class="no">{{ $sr }}</td>

                @if ($invoice->discountIsPercentage())
                    <td class="desc">{{ $invoice->coupon() }} ({{ $invoice->percentOff() }}% Off)</td>
                @else
                    <td class="desc">{{ $invoice->coupon() }} ({{ $invoice->amountOff() }} Off)</td>
                @endif
                <td class="unit">-{{ $invoice->discount() }}</td>
            </tr>
        @endif
        <!-- Display The Tax Amount -->
        @if ($invoice->tax_percent)
            @php $sr = $sr +1 @endphp
            <tr>
                <td class="no">{{ $sr }}</td>

                <td class="desc">Tax ({{ $invoice->tax_percent }}%)</td>

                <td class="desc">--</td>
                <td class="qty"></td>
                <td class="unit">{{ Laravel\Cashier\Cashier::formatAmount($invoice->tax) }}</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr dontbreak="true">
            <td colspan="2">@lang("app.total")</td>
            <td style="text-align: center">{{ $invoice->total() }}</td>
        </tr>
        </tfoot>
    </table>
    <p>&nbsp;</p>
    <hr>

</main>
</body>
</html>