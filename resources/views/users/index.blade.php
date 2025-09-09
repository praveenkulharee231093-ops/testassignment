User list
<div>
    <a href="{{ route('users.create') }}">Create New User</a>
    <a href="{{ route('users.export-latest') }}">Export CSV</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr> 
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('users.view', $user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>