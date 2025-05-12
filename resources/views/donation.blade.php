<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .normal-round-button{
            background-color: #be965a !important;
            color: #fff !important;
            border-radius: 30px;
        }
        .normal-btn{
            background-color: #be965a !important;
            color: #fff !important;
        }
        .offcanvas-title{
            color: #be965a;
        }
        .offcanvas-wide {
            width: 700px !important;
            max-width: 100%;
            padding: 3rem;
            background: #f5f5f5;
        }       
        .offcanvas-body {
            padding: 1rem;
        }
        .btn{
            border: 1px solid #be965a;
        }

        .checked {
            background-color: #be965a !important;
            color: white !important;
            border-color: #be965a !important;
        }

        .btn-check:checked + .btn {
            background-color: #be965a !important;
            color: white !important;
            border-color: #be965a !important;
        }
        .btn-outline-warning {
            color: var(--color-orange);
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
        input[type="radio"].btn-check:checked + label {
            background-color: #be965a !important;
            color: white !important;
            border-color: #be965a !important;
        }
        .tip-percentage {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            margin-right: 10px;
            cursor: pointer;
            display: inline-block;
        }
        .tip-percentage.selected {
            background-color: #be965a;
            color: white;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">
    <h1>Welcome to Missionary Donation</h1>
    <button class="btn normal-round-button mt-4" data-bs-toggle="offcanvas" data-bs-target="#donateCanvas">
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
        <!-- First Step -->
        <div class="card p-3 shadow-sm" id="firstStep">
            <h5 class="mb-3">Missionary Donation</h5>

            @if(request('success'))
                <div class="alert alert-success">Thank you for your donation!</div>
            @elseif(request('cancel'))
                <div class="alert alert-danger">Donation was canceled.</div>
            @endif

            <form id="donationForm">
                @csrf
                <div class="btn-group w-100 mb-3" role="group">
                    <input type="radio" class="btn-check" name="donation_type" id="donation-one-time" value="one-time" autocomplete="off" checked>
                    <label class="btn btn-outline-warning w-50 checked" for="donation-one-time" id="label-one-time">One-Time</label>

                    <input type="radio" class="btn-check" name="donation_type" id="donation-monthly" value="monthly" autocomplete="off">
                    <label class="btn btn-outline-warning w-50" for="donation-monthly" id="label-monthly">Monthly</label>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="name" class="form-control" id="donorName" placeholder="Donor's Name" required>
                        <div class="invalid-feedback">Please provide your name.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" name="email" class="form-control" id="donorEmail" placeholder="Donor's Email" required>
                        <div class="invalid-feedback">Please provide a valid email.</div>
                    </div>
                </div>

                <select name="mission" class="form-select mb-3" id="missionSelect">
                    <option value="Night Bright">Night Bright</option>
                </select>

                <div class="row mb-3">
                    @php
                        $amounts = [10, 25, 50, 100, 250, 500, 1000];
                    @endphp

                    @foreach ($amounts as $index => $amount)
                        <div class="col-3 mb-2">
                            <input type="radio" class="btn-check" name="amount" id="btn-amount-{{ $amount }}" value="{{ $amount }}" {{ $amount == 25 ? 'checked' : '' }}>
                            <label class="btn w-100 {{ $amount == 25 ? 'checked' : '' }}" for="btn-amount-{{ $amount }}">${{ $amount }}</label>
                        </div>
                    @endforeach
                    <div class="col-3 mb-2">
                        <input type="radio" class="btn-check" name="amount" id="btn-other" value="other">
                        <label class="btn w-100" for="btn-other">Other</label>
                    </div>
                    <div class="col-12 mt-2" id="otherAmountContainer" style="display: none;">
                        <input type="number" name="other_amount" class="form-control" id="otherAmount" placeholder="Enter custom amount" min="1">
                        <div class="invalid-feedback">Please enter a valid amount.</div>
                    </div>
                </div>

                <textarea name="message" class="form-control mb-2" placeholder="+ Add a message (optional)"></textarea>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="anonymous" id="anonymous">
                    <label class="form-check-label" for="anonymous">Stay Anonymous</label>
                    <button type="button" class="btn normal-btn float-end" id="continueBtn">Continue</button>
                </div>
            </form>
        </div>

        <!-- Second Step (Hidden by default) -->
        <div class="card p-3 shadow-sm" id="secondStep" style="display: none;">
            <h5 class="mb-3">Final Details</h5>
            
            <div class="mb-4">
                <h6>Donation</h6>
                <div class="d-flex justify-content-between">
                    <span>$<span id="displayAmount">25</span> <small class="text-muted" id="displayDonationType">(One-Time)</small></span>
                    <span>Credit card processing fees</span>
                </div>
                
                <div class="mt-2">
                    <div class="d-flex justify-content-between">
                        <span><strong id="feeLabel">Visa & Others</strong></span>
                        <span>$<span id="processingFee">0.92</span></span>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h6>Payment Method</h6>
                <select class="form-select" id="paymentMethod" name="payment_method">
                    <option value="amex">AMEX Card</option>
                    <option value="visa" selected>Visa & Others</option>
                    <option value="bank">US Bank Account</option>
                    <option value="cashapp">Cash App Pay</option>
                </select>
            </div>
            
            <div class="mb-4">
                <h6>Tip</h6>
                <select class="form-select mb-2" id="tipPercentage" name="tip_percentage">
                    <option value="12" selected>12%</option>
                    <option value="15">15%</option>
                    <option value="18">18%</option>
                    <option value="20">20%</option>
                    <option value="0">No Tip</option>
                </select>
                <p class="text-muted small">Why Tip? Night Bright does not charge any platform fees and relies on your generosity to support this free service.</p>
            </div>
            
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="allow_contact" id="allow-contact">
                <label class="form-check-label" for="allow-contact">Allow Night Bright Inc to contact me</label>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-outline-secondary" id="backBtn">< Back</button>
                <div>
                    <span class="me-3">Finish (<span id="totalAmount">$28.92</span>)</span>
                    <button type="submit" class="btn normal-btn" id="donateBtn">Donate</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form elements
        const donationForm = document.getElementById('donationForm');
        const continueBtn = document.getElementById('continueBtn');
        const backBtn = document.getElementById('backBtn');
        const donateBtn = document.getElementById('donateBtn');
        const firstStep = document.getElementById('firstStep');
        const secondStep = document.getElementById('secondStep');
        
        // Input fields
        const donorName = document.getElementById('donorName');
        const donorEmail = document.getElementById('donorEmail');
        const missionSelect = document.getElementById('missionSelect');
        const otherAmountContainer = document.getElementById('otherAmountContainer');
        const otherAmount = document.getElementById('otherAmount');
        const paymentMethod = document.getElementById('paymentMethod');
        
        // Display elements
        const displayAmount = document.getElementById('displayAmount');
        const displayDonationType = document.getElementById('displayDonationType');
        const processingFee = document.getElementById('processingFee');
        const feeLabel = document.getElementById('feeLabel');
        const totalAmount = document.getElementById('totalAmount');
        const tipPercentage = document.getElementById('tipPercentage');

        // Show/hide other amount field
        document.querySelectorAll('input[name="amount"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Remove 'checked' class from all labels
                document.querySelectorAll('label.btn').forEach(function(label) {
                    label.classList.remove('checked');
                });

                // Add 'checked' class to selected label
                const selectedLabel = document.querySelector('label[for="' + this.id + '"]');
                if (selectedLabel) {
                    selectedLabel.classList.add('checked');
                }
                
                // Show/hide other amount field
                if (this.id === 'btn-other') {
                    otherAmountContainer.style.display = 'block';
                    otherAmount.setAttribute('required', 'required');
                } else {
                    otherAmountContainer.style.display = 'none';
                    otherAmount.removeAttribute('required');
                    displayAmount.textContent = this.value;
                    updateProcessingFee();
                    updateTotalAmount();
                }
            });
        });

        // Donation type change
        document.querySelectorAll('input[name="donation_type"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                // Remove 'checked' from both labels
                document.querySelectorAll('label[for^="donation-"]').forEach(function(label) {
                    label.classList.remove('checked');
                });

                // Add 'checked' to selected label
                const selectedLabel = document.querySelector('label[for="' + this.id + '"]');
                if (selectedLabel) {
                    selectedLabel.classList.add('checked');
                }
                
                // Update display in second step
                if (this.id === 'donation-one-time') {
                    displayDonationType.textContent = '(One-Time)';
                } else {
                    displayDonationType.textContent = '(Monthly)';
                }
            });
        });

        // Continue button click handler with validation
        continueBtn.addEventListener('click', function() {
            // Validate form
            let isValid = true;
            
            // Validate name
            if (!donorName.value.trim()) {
                donorName.classList.add('is-invalid');
                isValid = false;
            } else {
                donorName.classList.remove('is-invalid');
            }
            
            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(donorEmail.value)) {
                donorEmail.classList.add('is-invalid');
                isValid = false;
            } else {
                donorEmail.classList.remove('is-invalid');
            }
            
            // Validate other amount if selected
            if (document.getElementById('btn-other').checked) {
                if (!otherAmount.value || parseFloat(otherAmount.value) <= 0) {
                    otherAmount.classList.add('is-invalid');
                    isValid = false;
                } else {
                    otherAmount.classList.remove('is-invalid');
                    displayAmount.textContent = parseFloat(otherAmount.value).toFixed(2);
                }
            }
            
            if (isValid) {
                firstStep.style.display = 'none';
                secondStep.style.display = 'block';
                
                // Update all values in second step
                updateProcessingFee();
                updateTotalAmount();
            }
        });

        // Back button click handler
        backBtn.addEventListener('click', function() {
            firstStep.style.display = 'block';
            secondStep.style.display = 'none';
        });

        // Payment method change handler
        paymentMethod.addEventListener('change', function() {
            updateProcessingFee();
            updateTotalAmount();
            
            // Update fee label
            const method = this.value;
            if (method === 'amex') {
                feeLabel.textContent = 'AMEX Card';
            } else if (method === 'visa') {
                feeLabel.textContent = 'Visa & Others';
            } else if (method === 'bank') {
                feeLabel.textContent = 'US Bank Account';
            } else if (method === 'cashapp') {
                feeLabel.textContent = 'Cash App Pay';
            }
        });

        // Tip percentage selection
        document.querySelectorAll('.tip-percentage').forEach(tip => {
            tip.addEventListener('click', function() {
                document.querySelectorAll('.tip-percentage').forEach(t => {
                    t.classList.remove('selected');
                });
                this.classList.add('selected');
                tipPercentage.value = this.dataset.percent;
                updateTotalAmount();
            });
        });

        // Calculate processing fee based on amount and payment method
        function updateProcessingFee() {
            const amount = parseFloat(displayAmount.textContent);
            const method = paymentMethod.value;
            
            let fee = 0;
            if (method === 'amex') {
                fee = amount * 0.035 + 0.30; // 3.5% + $0.30 for AMEX
            } else if (method === 'visa') {
                fee = amount * 0.029 + 0.30; // 2.9% + $0.30 for Visa/MC
            } else if (method === 'bank') {
                fee = 0.25; // Flat fee for bank transfer
            } else if (method === 'cashapp') {
                fee = 0; // No fee for Cash App
            }
            
            processingFee.textContent = fee.toFixed(2);
        }

        // Calculate total amount including tip
        function updateTotalAmount() {
            const amount = parseFloat(displayAmount.textContent);
            const fee = parseFloat(processingFee.textContent);
            const tipPercent = parseFloat(tipPercentage.value);
            
            const tipAmount = amount * (tipPercent / 100);
            const total = amount + fee + tipAmount;
            
            totalAmount.textContent = '$' + total.toFixed(2);
        }

        // Form submission on Donate button
        donateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Create a form dynamically with all the data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('donation.process') }}";
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('input[name="_token"]').value;
            form.appendChild(csrfToken);
            
            // Add all fields from first step
            const firstStepFields = donationForm.querySelectorAll('input, select, textarea');
            firstStepFields.forEach(field => {
                if (field.type !== 'radio' && field.type !== 'checkbox') {
                    const clone = field.cloneNode(true);
                    form.appendChild(clone);
                } else if (field.checked) {
                    const clone = field.cloneNode(true);
                    form.appendChild(clone);
                }
            });
            
            // Add fields from second step
            const paymentMethodClone = paymentMethod.cloneNode(true);
            form.appendChild(paymentMethodClone);
            
            const tipPercentageClone = tipPercentage.cloneNode(true);
            form.appendChild(tipPercentageClone);
            
            const allowContact = document.getElementById('allow-contact');
            if (allowContact.checked) {
                const allowContactClone = allowContact.cloneNode(true);
                form.appendChild(allowContactClone);
            }
            
            // Add hidden field for total amount
            const totalAmountField = document.createElement('input');
            totalAmountField.type = 'hidden';
            totalAmountField.name = 'total_amount';
            totalAmountField.value = totalAmount.textContent.replace('$', '');
            form.appendChild(totalAmountField);
            
            // Add donation type (one-time/monthly)
            const donationType = document.querySelector('input[name="donation_type"]:checked');
            const donationTypeClone = donationType.cloneNode(true);
            form.appendChild(donationTypeClone);
            
            // Submit the form
            document.body.appendChild(form);
            form.submit();
        });

        // Initialize values
        updateProcessingFee();
        updateTotalAmount();
    });
</script>

</body>
</html>