<h3 class="page-title text-center">User found: {{ $user->name }}</h3>
<b>Email</b>: {{ $user->email }}
<br>
<b>Registered on</b>: {{ $user->created_at }}
<br>
<b><a href="{{ route('users.index')  }}"> return to main</a></b>
