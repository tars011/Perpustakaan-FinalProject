// Toggle container active state
const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
    updateURL('signup');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
    updateURL('signin');
});

// Function to get URL parameter
function getURLParameter(name) {
    return new URLSearchParams(window.location.search).get(name);
}

function updateURL(section) {
    const currentURL = window.location.href.split('?')[0];
    const newURL = `${currentURL}?section=${section}`;
    history.pushState({ path: newURL }, '', newURL);
}

// On document ready
document.addEventListener("DOMContentLoaded", function () {
    // Get the section parameter from URL
    const section = getURLParameter('section');

    // Toggle the container state based on the section parameter
    if (section === 'signup') {
        container.classList.add("active");
    } else {
        container.classList.remove("active");
    }
});

document.addEventListener("DOMContentLoaded", function () {
});

// Animation Button
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.submit');

    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            button.classList.add('active');
            setTimeout(() => {
                button.classList.remove('active');
            }, 150); // Duration of the click animation
        });
    });
});