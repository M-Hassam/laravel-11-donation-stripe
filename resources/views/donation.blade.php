<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .offcanvas-wide {
            width: 700px !important;
            max-width: 100%;
            padding: 3rem;
        }
        .offcanvas-body {
            padding: 1rem;
        }
        .btn-outline-warning {
            color: #856404;
            border-color: #856404;
        }
        .btn-outline-warning:hover {
            background-color: #ffeeba;
            border-color: #856404;  
        }
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }
        .btn-outline-secondary:hover {
            background-color: #e2e3e5;
            border-color: #6c757d;  
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <h1>Welcome to Missionary Donation</h1>
    <button class="btn btn-outline-warning mt-4" data-bs-toggle="offcanvas" data-bs-target="#donateCanvas">
        Donate <i class="bi bi-arrow-right-circle"></i>
    </button>
</div>

<div class="offcanvas offcanvas-start offcanvas-wide" tabindex="-1" id="donateCanvas" data-bs-scroll="true">
  <div class="container-fluid pt-4">

  
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Donate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <div class="card p-3 shadow-sm">
            <h5 class="mb-3">Missionary Donation</h5>

            @if(request('success'))
                <div class="alert alert-success">Thank you for your donation!</div>
            @elseif(request('cancel'))
                <div class="alert alert-danger">Donation was canceled.</div>
            @endif

            <form action="{{ route('donation.process') }}" method="POST">
                @csrf
                <input type="text" name="name" class="form-control mb-2" placeholder="Donor's Name" required>
                <input type="email" name="email" class="form-control mb-2" placeholder="Donor's Email" required>

                <select name="mission" class="form-select mb-2">
                    <option value="Night Bright">Night Bright</option>
                </select>

                <div class="btn-group d-flex flex-wrap mb-2" role="group">
                    @foreach ([10, 25, 50, 100, 250, 500, 1000] as $amount)
                        <input type="radio" class="btn-check" name="amount" id="btn-amount-{{ $amount }}" value="{{ $amount }}" {{ $amount == 25 ? 'checked' : '' }}>
                        <label class="btn btn-outline-warning m-1" for="btn-amount-{{ $amount }}">${{ $amount }}</label>
                    @endforeach
                    <input type="radio" class="btn-check" name="amount" id="btn-other" value="other">
                    <label class="btn btn-outline-secondary m-1" for="btn-other">Other</label>
                </div>

                <textarea name="message" class="form-control mb-2" placeholder="+ Add a message (optional)"></textarea>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="anonymous" id="anonymous">
                    <label class="form-check-label" for="anonymous">
                        Stay Anonymous
                    </label>

                    <button type="submit" class="btn btn-warning float-end">Continue</button>

                </div>

            </form>
        </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>