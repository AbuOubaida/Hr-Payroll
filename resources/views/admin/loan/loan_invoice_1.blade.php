<div style="width:768px;margin:0 auto!important;background:#f5f5f5;padding:30px 40px;min-height:500px;font-family: sans-serif;">
    <div>
        <a href="" style="text-decoration: none;">
            <h1 style="font-size: 28.3px;font-weight: 700;color: #11e770;width:100%;display:block;text-align: center;font-family: sans-serif;text-decoration: none;">
                {{$comp_name}}</h1>
        </a>
    </div>
    <div><b>Dear</b>, {{$client_name}}</div>
    <br>
    <div>This is a notice that an invoice has been generated on <b> {{date('M-d,Y',strtotime(now()))}}</b> about office loan, which applied by your self at <b>{{date('M-d,Y',strtotime($apply_date))}}</b></div>
    <br>
    <div style="text-align: justify">Your applied loan status is <span style="color: #00bb00">Approved</span> by your office admin. <span style="color:#00bb00;"> So your requested loan are activated. Your loan amount ({{$proposed_loan_amount}}/-) will add at the next month ({{date('F,Y',strtotime($nextMonth))}}) with your salary. The first installment ({{$ins_amount = ceil($proposed_loan_amount/$loan_type_installment)}})/- will be taken from your salary in the next month in which you has taken the loan. </span></div>
    <br>
    <div style="font-size:24px;">Invoice ID: <b style="color:#11251e;font-size:24px;"># {{$invoiceID}}</b></div>
    <br>
    <div>Loan Amount: <b style="color:#11251e;font-size:20px;">{{$proposed_loan_amount}}/-</b></div>
    <br>
    <b>Invoice Item</b>
    <hr style="color:#000;border-bottom:2px silod #000;">
    <br>
    <table border="1" width="100%" style="font-family:Trebuchet MS,Arial,Helvetica,sans-serif;border-collapse:collapse;width:100%">
        <tbody><tr>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Loan Title</th>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Loan Type</th>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Installment</th>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Ins. Amount</th>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Duration</th>
            <th style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Loan Amount</th>
        </tr>
        <tr>
            <td style="border:1px solid #ddd;padding:8px">{{$proposed_loan_title}}</td>
            <td style="border:1px solid #ddd;padding:8px">{{$loan_type_title}}</td>
            <td style="border:1px solid #ddd;padding:8px">{{$loan_type_installment}}</td>
            <td style="border:1px solid #ddd;padding:8px">{{$ins_amount}}/-</td>
            <td style="border:1px solid #ddd;padding:8px">{{$loan_type_duration}}</td>
            <td style="border:1px solid #ddd;padding:8px">{{$proposed_loan_amount}}/-</td>
        </tr>
        <tr>
            <th colspan="5" style="border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">Total Loan Amount</th>
            <th style="text-align:center;border:1px solid #ddd;padding:8px;padding-top:12px;padding-bottom:12px;text-align:left;background-color:#4caf50;color:white">{{$proposed_loan_amount}}/-</th>
        </tr>
        </tbody>
    </table>
    <br>
    <div>More information to login your panel  <a href="{{url("/login")}}" target="_blank" >Click to login</a></div>
    <br>
    <div><h3>Feel free to contact us</h3></div>
    <br>
    <div>Email: {{$comp_email}} <br>Phone: +880 {{$comp_phone}}</div>
    <br><br><br>
    <div style="text-align:center;width:100%;margin:0 auto;"><a href="{{url('/')}}" target="_blank">visit our website</a> | <a href="{{url("/login")}}" target="_blank">log in to your account</a></div>
    <br>
    <div style="text-align:center;">Copyright © {{$comp_name}}, All rights reserved.</div>
</div>
