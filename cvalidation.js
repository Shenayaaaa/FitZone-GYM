// contact.js
document.getElementById('contact-form').addEventListener('submit', function(event) {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    // Simple email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        event.preventDefault(); // Prevent form submission
        return;
    }

    // Check if required fields are filled
    if (name.trim() === "" || message.trim() === "") {
        alert("Name and Message are required.");
        event.preventDefault(); // Prevent form submission
        return;
    }
});