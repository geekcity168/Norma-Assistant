function checkPercentageChange() {
    var percentChange = document.getElementById("percentChange").textContent;
    var spanElement = document.getElementById("percentChange");

    if (percentChange.includes("+")) {
        spanElement.classList.add("positive");
    } else if (percentChange.includes("-")) {
        spanElement.classList.add("negative");
    } else {
        spanElement.classList.add("neutral");
    }
}

document.addEventListener('DOMContentLoaded', function(){

    var selectedBank = document.getElementById("bankSelect");
    var accountnumber = document.getElementById("accountnumber");
    var expiry = document.getElementById("expiry");
    var cvc = document.getElementById("cvc");

    var bankSubmit = document.getElementById("bankSubmit");
    var loadingDiv = document.querySelector(".loading-circle");
    var loadingStatus = document.getElementById("loadStatus");

    var bankName = document.getElementById("bankName");
    var accountNumber = document.getElementById("accountName");

    var statusBar = document.getElementById("statusBar");

    bankSubmit.addEventListener("click", function(event) {
        event.preventDefault();

        if (!accountnumber.value == "" || !expiry.value == "" || cvc.value == "") {
            loadingDiv.style.display = "inline-block";
            loadingStatus.style.display = "inline-block";
            setTimeout(checkBankDetails, 5000);
        }

        else {
            alert("Please enter the Bank card details");
        }
    });

    var bankPopupOverlay = document.getElementById("bankPopupOverlay");
    var bankPopup = document.getElementById("bankPopup");

    bankPopupOverlay.addEventListener("click", function() {
        if (!accountnumber.value == "") {
            var response = confirm("Do you want to exit without updating Bank details?");
            if (response = true) {
                bankPopupOverlay.style.display = "none";
                bankPopup.style.display = "none";
            } 
            else {
                bankPopupOverlay.style.display = "block";
                bankPopup.style.display = "block";
                return false;
            }
        }

        else {
            bankPopupOverlay.style.display = "none";
            bankPopup.style.display = "none";
        }
    });

    document.getElementById("openBankButton").addEventListener("click", function() {
        bankPopupOverlay.style.display = "block";
        bankPopup.style.display = "block";
    });

    
    
});

function formatAccountNumber(input) {
    var selectedBank = document.getElementById("bankSelect");
    if (!selectedBank || selectedBank.value === "") {
        alert("Please select Bank first");
        input.value = "";
        return;
    }

    else {
        var value = input.value.replace(/\D/g, '');
        value = value.replace(/(.{4})/g, '$1-');
        if (value.length > 24) {
            value = value.slice(0, 24);
        }
        input.value = value;
    }
}

function formatExpiration(input) {
    var accountnumber = document.getElementById("accountnumber");

    if (!accountnumber || accountnumber.value === "") {
        alert("Please enter the Account number");
        input.value = "";
        return;

    }
    else {
        var value = input.value.replace(/\D/g, '');


        if (value === "") {
            return; 
        }

        if (value.length > 4) {
            value = value.slice(0, 4); 
        }

        var month = parseInt(value.slice(0, 2), 10);
        var date = parseInt(value.slice(2, 4), 10);


        if (month > 12 || date > 31) {
            alert("Invalid Expiration Date");
            input.value = "";
            return;
        }
        value = value.replace(/(\d{2})(\d{0,2})/, '$1/$2');

        input.value = value;

    }
    
}


function formatCVC(input) {
    var value = input.value.replace(/\D/g, '');
    value = value.substring(0, 3);

    input.value = value;
}


document.getElementById("addMobileOverlay").addEventListener("click", function() {
    console.log("Button clicked");

    var addMobileOverlay = document.getElementById("addMobileOverlay");
    var mobilePhone = document.getElementById("mobile-phone");

    if (mobilePhone.value !== "") {

        var confirmResponse = confirm("Do you want to close without saving changes?");

        if (confirmResponse = true) {
            addMobileOverlay.style.display = "none";
            mobilePopup.style.display = "none";
            return;
        }

        else {
            addMobileOverlay.style.display = "block";
            mobilePopup.style.display = "block";
        }

    } else {
        addMobileOverlay.style.display = "none";
        mobilePopup.style.display = "none";
    }
});

function closeMobileWindow() {
    var addMobileOverlay = document.getElementById("addMobileOverlay");
    var mobilePhone = document.getElementById("mobile-phone");

    addMobileOverlay.style.display = "none";
    mobilePopup.style.display = "none";

}






