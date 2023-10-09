<table>
    <thead>
    ['head_of_family','mobile','epic_no','address','district_id','address','constituency_id','trade_id','department_id','sub_trade_id'];
    ['ac_holder', 'bank_name','branch_name','ac_no', 'ifsc','application_id']
    <tr>
        <th style="font-weight: bold">Head of Family</th>
        <th style="font-weight: bold">Mobile</th>
        <th style="font-weight: bold">EPIC No</th>
        <th style="font-weight: bold">Address</th>
        <th style="font-weight: bold">District</th>
        <th style="font-weight: bold">Department</th>
        <th style="font-weight: bold">Constituency</th>
        <th style="font-weight: bold">Trade</th>
        <th style="font-weight: bold">SubTrade</th>
        <th style="font-weight: bold">Bank AC Holder</th>
        <th style="font-weight: bold">Bank Name</th>
        <th style="font-weight: bold">Branch Name</th>
        <th style="font-weight: bold">Ac No</th>
        <th style="font-weight: bold">IFSC</th>
    </tr>
    </thead>
    <tbody>
    @foreach($applications as $application)
        <tr>
            <td>{{ $application?->head_of_family }}</td>
            <td>{{ $application?->mobile }}</td>
            <td>{{ $application?->epic_no }}</td>
            <td>{{ $application?->address }}</td>
            <td>{{ $application?->district?->name }}</td>
            <td>{{ $application?->department?->name }}</td>
            <td>{{ $application?->constituency?->name }}</td>
            <td>{{ $application?->trade?->name }}</td>
            <td>{{ $application?->subTrade?->name }}</td>
            <td>{{ $application?->bankAccount?->ac_holder }}</td>
            <td>{{ $application?->bankAccount?->bank_name }}</td>
            <td>{{ $application?->bankAccount?->branch_name }}</td>
            <td>{{ $application?->bankAccount?->ac_no }}</td>
            <td>{{ $application?->bankAccount?->ifsc }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
