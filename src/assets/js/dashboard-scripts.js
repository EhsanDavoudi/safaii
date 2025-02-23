function toggleEditing(inputId) {
    let input = document.getElementById(inputId);

    if (input.readOnly) {
        if (input.id === 'tokenInput') {
            input.type = 'text';
        }
        input.readOnly = false;
        input.focus();
    } else {
        if (input.id === 'tokenInput') {
            input.type = 'password';
        }
        input.readOnly = true;
    }
}

function toggleEditingToken(inputId, buttonId) {
    let input = document.getElementById(inputId);
    let buttonElement = document.getElementById(buttonId);

    if (input.readOnly) {
        input.type = 'text';
        input.readOnly = false;
        input.focus();
        buttonElement.style.display = 'inline';
    } else {
        input.type = 'password';
        input.readOnly = true;
        buttonElement.style.display = 'none';
    }
}

const amountInput = document.getElementById('amountInput');
const rangeInput = document.getElementById('priceRange');
const error = document.getElementById('error');
const percentageDisplay = document.getElementById('percentageDisplay');
const maxAmount = Number(balance);
//console.log(balance);

rangeInput.addEventListener('input', function() {
    const percentage = parseInt(rangeInput.value);
    const value = (percentage / 100) * maxAmount;
    amountInput.value = value.toLocaleString('fa-IR');
    percentageDisplay.textContent = percentage + '%';
    //error.style.display = 'none';
});

amountInput.addEventListener('input', function() {
    let value = parseInt(amountInput.value.replace(/\D/g, '')); // Remove non-numeric characters
    if (isNaN(value)) {
        value = 0;
    }

    // if (value > maxAmount) {
    //     error.style.display = 'block';
    //     value = maxAmount;
    // } else {
    //     error.style.display = 'none';
    // }

    const percentage = (value / maxAmount) * 100;
    rangeInput.value = percentage.toFixed(0);
    percentageDisplay.textContent = percentage.toFixed(2) + '%';
});

setTimeout(function() {
    let successAlert = document.querySelector('.alert-success');
    let errorAlert = document.querySelector('.alert-danger');
    let warningAlert = document.querySelector('.alert-warning');

    if (successAlert) {
        successAlert.style.display = 'none';
    }
    if (errorAlert) {
        errorAlert.style.display = 'none';
    }
    if (warningAlert) {
        warningAlert.style.display = 'none';
    }
},2000);// Hide after 2 seconds