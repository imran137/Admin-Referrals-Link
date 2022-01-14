<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
</head>
<body>
    <h1>Confirmation Email</h1>
    <p>Please this six digit pin {{ $details['random_number'] }} use to activate your account <br> by using this post api: {{ 'http://127.0.0.1:8000/api/account-activate' }} </p>
   
    <p>Thank you</p>
</body>
</html>