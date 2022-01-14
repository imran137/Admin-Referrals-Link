<h1> Authentication system, Profile Update </h1>

<p>1: The admin user can send email invitations to signup. With that invitation link, the user can create a username and password, after submitting the form the user gets a 6 digit pin to the user's email, confirming this pin, users registered successfully.</p>

<p>2: Users can login to the system and update their profile.</p>
<p>3: User  has these information: name, user_name (min 4, max 20), avatar (dimension: 256px x 256px), email, user_role (admin, user), registered_at, created_at, updated_at
consider the attributes as well.</p>

<b>Technical Information:</b></br>
For the above scenario, we only need API implementation. No front-end work is needed here. Write down the logic and publish it to the API URL. To test your API, you can use postman or any similar platform. While submitting, please provide the postman collection or similar platform information where we can look/test it.</p>

<br><br>
<h1> How it works </h1>

<p> 1: Clone project:  git clone https://github.com/imran137/Admin-Referrals-Link.git </p>

<p> 
    2: Create database and update credentials in .env file then execute command 
    <pre>php artisan migrate</pre>
</p>

<p> 
    3: For passport token install execute command 
    <pre>php artisan passport:install</pre>
</p>

<p> 
    4: To secure the public API execute command
    <pre>php artisan passport:client --client</pre>
    
    After this command add client_id and client_secret in API.
    <pre>http://127.0.0.1:8000/oauth/token</pre>
    after hit this api get the token and use for authorization of register and login api.
</p>
