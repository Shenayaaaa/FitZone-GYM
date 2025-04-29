document.getElementById("registrationForm").addEventListener("submit", function(event) {
    var email = document.getElementById("email").value;
    var password = document.getElementById("psw").value;
    var passwordRepeat = document.getElementById("psw-repeat").value;

    // Check if all fields are filled
    if (!email || !password || !passwordRepeat) {
        alert("Please fill in all fields.");
        event.preventDefault();
        return;
    }

    // Check if passwords match
    if (password !== passwordRepeat) {
        alert("Passwords do not match.");
        event.preventDefault();
        return;
    }

    // Check if at least one membership option is selected
    var checkboxes = document.querySelectorAll('input[name="interest"]:checked');
    if (checkboxes.length === 0) {
        alert("Please select at least one membership option.");
        event.preventDefault();
        return;
    }
});
