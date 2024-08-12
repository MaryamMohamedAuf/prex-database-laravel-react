
<p>Dear {{ $applicant->first_name }},</p>

<p>This is a reminder that your follow-up survey is overdue. Please complete it as soon as possible.</p>

<p>You can access your survey at the following link:</p>
<a href="{{ url('http://localhost:3000/followup/create') }}">Complete Survey</a>

<p>Thank you!</p>
