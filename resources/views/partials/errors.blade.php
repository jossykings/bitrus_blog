@if (count($errors) == 0)
    @foreach ($errors->all() as $err)
        <div class="alert-container">

            <div class="error">
                <p>

                    {{ $err }}
                </p>
            </div>
        </div>
    @endforeach
@endif
@if (session('success'))
    <div class="alert-container">

        <div class="success">
            <p>

                {{ session('success') }}
            </p>
        </div>
    </div>
@endif
@if (session('error'))
    <div class="alert-container">

        <div class="error">
            <p>

                {{ session('error') }}
            </p>
        </div>
    </div>
@endif
