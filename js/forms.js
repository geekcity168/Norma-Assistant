

document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();


    console.log("Form submitted");
    var fullname = document.getElementById("fullname");
    var email = document.getElementById("email");
    var country = document.getElementById("country");
    var password = document.getElementById("password");

    var status = document.getElementById("status");

    if(fullname.value == "" || email.value == "" || password.value == "") {
        console.log("Empty");
        status.innerHTML = "Please fill in all the details";
        status.style.color = "#ffca4e";


        
    }

    else {
        status.innerHTML = "Please wait...";
        status.style.color = "#ffca4e";

        if(country.value == "Kenya" || country.value == "Tanzania" || country.value == "Uganda") {
            status.innerHTML = "Creating account. Please wait...";
            status.style.color = "#4eff65";

            setTimeout(() => {
                status.innerHTML = "Success! Redirecting to main page...";
                status.style.color = "#4eff65";

                sendFormData();

                setTimeout(() => {
                    window.location = "index.html";
                }, 3000);

            }, 3600);
        }

        else {
            status.innerHTML = "Feature currently not available in your country";
            status.style.color = "#ffca4e";
        }
    }
});