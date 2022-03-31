<div class="container">
    <title>Invoice</title>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr class="top">
                <td colspan="4">
                    <table width="100%" border="0"> 
                        <tr>
                            <td class="title" style="text-align: left;">
                                <img src="{{ asset('/front/img/logo.jpg') }}" style="width:280px;" alt="Yacht-findr image">
                            </td>
                            <td align="right">
                                Invoice #: {{ $order['order_id'] }}
                                <br>{{ date('M d, Y', strtotime($order['order_date'])) }} @ {{ date('h:i A', strtotime($order['order_date'])) }}
                            </td>
                        </tr>
                            <tr>
                            <td>&nbsp;</td>
                            <td align="top" align="right">
                                {{ $user->full_name }} 
                                <br> {{ $user->email }}
                            </td>
                            
                        </tr>

                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <h2 align="center">Invoice</h2>
                </td>
            </tr>
            <hr/>
            <tr class="invoice-content">
                <td><strong>Order #</strong>:&nbsp;{{ $order['order_id'] }}</td>
            </tr>
            <tr class="invoice-content">
                <td><strong>Order Date</strong>:&nbsp;{{ date('M d, Y', strtotime($order['order_date'])) }}</td>
            </tr>
            <tr class="invoice-content">
                <td><strong>Plan Name</strong>:&nbsp;{{ ucfirst($order['plan']) }}</span>
                </td>
            </tr>
            <tr class="invoice-content">
                <td><strong>Duration</strong>:&nbsp;{{ $order['duration'] }}&nbsp;weeks</td>
            </tr>
            @if(count($order['addons']) > 0)
                <tr class="invoice-content">
                    <td><strong>AddOns</strong>:&nbsp;{{ count($order['addons']) }}</td>
                </tr>
            @endif
            <tr class="invoice-content">
                <td><strong>Auto Renew</strong>:&nbsp;{{ ($order['auto_renew'] == 1) ? 'Yes' : 'No' }}</td>
            </tr>
        </table>
        <hr/>
        <table>
            <tr class="invoice-content">
                <td><strong>Total Amount</strong>:&nbsp;${{ number_format($order['order_total'],2,".","") }}</td>
            </tr>
            <tr class="invoice-content">
                <td><strong>Order Status</strong>:&nbsp;{{ ucfirst($order['status']) }}
                </td>
            </tr>
        </table>
    </div> 
</div>

<style>

.invoice-box {
    background-color: #fff !important;
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 14px;
    line-height: 24px;
    font-family: Helvetica, Arial, sans-serif;
    color: #555;
}

.invoice-box table {
    width: 100%;
    /*line-height: inherit;*/
    text-align: left;
}


.invoice-box table tr td:nth-child(2) {
    text-align: right;
}

.invoice-box table tr.top table td {
    /*padding-bottom: 20px;*/
}

.invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
}

.invoice-box table tr.information table td {
    padding-bottom: 40px;
}

.invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.invoice-box table tr.details td {
    padding-bottom: 20px;
}

.invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
    border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
}

.invoice-box table tr.invoice-content td:first-child{
    font-weight: bold;
}

.invoice-box table tr.invoice-content td:nth-child(2){
    text-align: left;
}

.invoice-box table tr.invoice-content td .inner-content{
    font-weight: normal;
}
.invoice-btn{
    margin-right: 19%;
}
@media  only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
}

</style>