<!DOCTYPE html>
<html>

<head>
    <style>
        #employee-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #employee-table td,
        #employee-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        /* #employee-table tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        #employee-table tr:hover {
            background-color: #ddd;
        }

        #employee-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>
    @if (is_array($mailData['lateEmployees']))
        <p>
            Dear HR Admin,<br>

            I hope this email finds you well. I am writing to bring to your attention an important matter regarding an
            employee's recent absence from their scheduled shift.<br><br>

            Employee Details:<br>
        <table id="employee-table">
            <tr>
                <td>Name</td>
                <td>Employee ID</td>
                <td>Designation</td>
                <td>Scheduled Shift</td>
            </tr>
            @foreach ($mailData['lateEmployees'] as $employee)
                <tr>
                    <td>{{ $employee->user->name }}</td>
                    <td>{{ 'Emp-' . $employee->id }}</td>
                    <td>{{ $employee->designation->name }}</td>
                    <td>{{ $employee->shift->name .' [' .\Carbon\Carbon::parse($employee->shift->start_time)->timezone(setting('timezone'))->format('h:i a') .'-' .\Carbon\Carbon::parse($employee->shift->end_time)->timezone(setting('timezone'))->format('h:i a') .']' }}
                    </td>
                </tr>
            @endforeach
        </table><br>

        Our records indicate that on the aforementioned date and time, the mentationed Employees were expected to be
        present
        for their scheduled shift but was unable to fulfill this obligation. As the owner of the company, we believe it
        is crucial for you to be informed about such instances that may impact the smooth functioning of our
        operations.<br><br>

        While we strive to maintain a reliable and efficient workforce, unforeseen circumstances can occasionally
        arise, leading to employee absences. We have established protocols in place to address such situations promptly
        and
        effectively. However, it is vital to investigate the reasons behind this absence and take appropriate action
        to ensure continuity and adherence to company policies.<br><br>

        We kindly request your attention to the following actions:<br>
        1. Review the employee's attendance record and any previous instances of absenteeism.<br>
        2. Assess the impact of this absence on the workflow, customer service, and team dynamics.<br>
        3. Determine whether any immediate actions are required to mitigate the effects of the absence, such as
        arranging for alternative coverage or redistributing workload.<br>
        4. Consider scheduling a meeting with the employee to discuss the circumstances surrounding the missed shift
        and
        obtain their explanation.<br><br>

        Additionally, we recommend documenting this incident and any subsequent actions taken for future reference
        and
        possible follow-up actions, including performance evaluations or corrective measures as per our company
        policies.
        </p>
    @else
        <p>
            Dear {{ $mailData['lateEmployees']->user->name }},<br>

            I hope this email finds you well. I am writing to inform you that our records indicate you were scheduled
            for a shift on {{ \Carbon\Carbon::today()->toDateString() }} at
            {{ \Carbon\Carbon::parse($mailData['lateEmployees']->shift->start_time)->timezone($mailData['lateEmployees']->user->timezone)->format('h:i a') }},
            but you were not present or accounted for during that time. It is important
            for all employees to fulfill their scheduled shifts to maintain a smooth workflow and ensure proper service
            to our valued employee-table.<br><br>

            We understand that unforeseen circumstances can sometimes arise, which may prevent you from attending work
            as scheduled. However, it is crucial that you notify your supervisor or the HR department in advance if you
            are unable to make it to your shift due to an emergency or any other valid reason. This allows us to make
            necessary arrangements to ensure adequate coverage and avoid disruptions to our operations.<br><br>

            Your consistent attendance is essential for the efficient functioning of our organization. In light of your
            recent absence, we kindly request that you provide a detailed explanation for your missed shift within
            [specified time, e.g., 24 hours] of receiving this email. Please include any supporting documentation, such
            as medical certificates or other relevant documents, if applicable.<br><br>


            If there were extenuating circumstances that prevented you from notifying us in advance or attending the
            shift, we encourage you to communicate with your immediate supervisor or the HR department as soon as
            possible. We believe in open communication and understanding, and we are committed to working with you to
            find appropriate solutions.<br><br>

            It is our expectation that you prioritize your attendance and communicate any future absences promptly, as
            we rely on your dedication and commitment to fulfilling your assigned responsibilities.<br><br>

            If you require any assistance or have any questions regarding this matter, please feel free to reach out to
            your supervisor or the HR department. We are here to support you.<br><br>

            Thank you for your immediate attention to this matter. We look forward to your prompt response.<br><br>

            Best regards,<br>
            HR Admin
        </p>
    @endif

</body>

</html>








<h4></h4>
<table class="table table-bordered">

</table>
