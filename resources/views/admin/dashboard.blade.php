@extends('layouts.app')
@section('section')
    <div class="dashboard-container">
        <div class="postss">
            <div>

                <p style="margin-top: 20px;">

                    Admin: {{ auth()->user()->name }}
                </p>
                <p style="margin-top: 30px;">

                    <a href="{{ route('create') }}" class="btn">create post</a>
                </p>
            </div>
            <h3 style="  margin-top: 30px;">Posts</h3>
            <div class="table">
                @if ($posts->count() > 0)
                    <table>
                        <thead>
                            <th>Title</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($posts as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td><a href="{{ route('editshow', $item->id) }}" class="btn">edit</a></td>
                                    <td>
                                        <form id="deletepostform" action="{{ route('deletepost', $item->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn" id="delete-post">delete</button>
                                        </form>
                                        {{-- <button id="clickcc">click</button> --}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>
                        <center>No Post Created Yet</center>
                    </p>
                @endif

            </div>
        </div>
        <div class="user-container">
            <p>
                <center>
                    <h2>All Users</h2>
                </center>
            </p>
            <div class="table">
                @if ($users->count() > 0)
                    <table>
                        <thead>
                            <th>Name</th>
                            <th>Position</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>User</td>
                                    <td>
                                        <form action="{{ route('addtoadmin', $item->id) }}" method="post">
                                            @csrf
                                            {{-- <input type="hidden" value="{{ $item->id }}" name="user_id"> --}}
                                            <button class="btn2">add as admin</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('deleteuser', $item->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn">delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>
                        <center>No User Registered Yet</center>
                    </p>
                @endif

            </div>
        </div>
    </div>
    <div class="admin-section">
        <div>

            <div class="table">
                @if ($admin->count() > 1)
                    <center>

                        <h3>Admins</h3>
                    </center>

                    <table>
                        <thead>
                            <th>Name</th>
                            <th>Position</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($admin as $item)
                                @if ($item->id == '1')
                                    ...
                                @else
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>Admin</td>
                                        <td>
                                            <form action="{{ route('removeadmin', $item->id) }}" method="post">
                                                @csrf
                                                <button class="btn2">remove as admin</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection
@section('script')
    let delPostBtn = document.getElementById("delete-post");
    delPostBtn.addEventListener("click", () => {
    if (confirm("Are You Sure You Want To Delete This Post?"))
    {
    document.getElementById("deletepostform").submit();
    }
    });
@endsection
