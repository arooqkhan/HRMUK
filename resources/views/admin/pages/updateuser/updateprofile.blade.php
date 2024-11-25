@extends('admin.master.main')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 20px;
        background-color: #f8f9fa;
    }
    .container {
        background-color: none; /* Black background */
        color: #fff; /* White text for contrast */
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #ffc107; /* Accent color for heading */
        font-size: 24px;
        font-weight: bold;
    }
    input[type="text"], input[type="email"], input[type="file"], input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ced4da;
        border-radius: 5px;
        font-size: 14px;
        background-color: #1c1c1c; /* Dark input background */
        color: #fff; /* White text for inputs */
        transition: border-color 0.3s ease-in-out;
    }
    input[type="text"]:focus, input[type="email"]:focus, input[type="file"]:focus, input[type="password"]:focus {
        border-color: #ffc107; /* Accent border color */
        outline: none;
    }
    button {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: green;
        color: #000; /* Black text for contrast */
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }
    button:hover {
        background-color: #e0a800; /* Slightly darker accent on hover */
    }
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
        color: white;
    }
    .alert.bg-success {
        background-color: #28a745;
    }
    .alert.bg-danger {
        background-color: #dc3545;
    }
    .profile-image {
        margin-top: 20px;
    }
    .profile-image img {
        border-radius: 50%;
        border: 2px solid #dee2e6;
        padding: 5px;
        margin-left: 26px;
    }
    label {
        font-weight: bold;
        color: #ffc107; /* Accent color for labels */
        margin-bottom: 5px;
        display: block;
    }
</style>

<div class="container">
    <h2>Update Profile</h2>
    @if(session('success'))
        <div class="alert bg-success" id="success-alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert bg-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('profiles.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>

        <label for="image">Profile Image:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <div class="profile-image">
            <h3>Profile Image:</h3>
            <img alt="avatar" src="{{ asset(Auth::user()->image) }}" height="100px" width="100px">
        </div>
        <div class="col-4 offset-4">
            <button class="mt-3" type="submit">Update Profile</button>

        </div>
    </form>
</div>


<div class="container">
    <h2>Update Password</h2>
    <form action="{{ route('adminprofilepass') }}" method="POST">
        @csrf
        @method('PUT') <!-- Add this line to specify the PUT method -->

        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="new_password_confirmation">Confirm New Password:</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
         <div class=" mt-2 col-4 offset-4">
             <button type="submit">Update Password</button>
         </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = "none";
            }, 2000); // 2 seconds
        }
    });
</script>

@endsection
