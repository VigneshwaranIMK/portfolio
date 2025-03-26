document.addEventListener("DOMContentLoaded", function () {
  const words = ["Web Developer", "Web Designer", "Frontend Developer"];
  let wordIndex = 0;
  let charIndex = 0;
  let currentWord = '';
  const typingSpeed = 100;
  const erasingSpeed = 50;
  const newWordDelay = 2000;

  function type() {
      if (charIndex < words[wordIndex].length) {
          currentWord += words[wordIndex].charAt(charIndex);
          document.querySelector('.typing-animation').textContent = currentWord;
          charIndex++;
          setTimeout(type, typingSpeed);
      } else {
          setTimeout(erase, newWordDelay);
      }
  }

  function erase() {
      if (charIndex > 0) {
          currentWord = currentWord.slice(0, -1);
          document.querySelector('.typing-animation').textContent = currentWord;
          charIndex--;
          setTimeout(erase, erasingSpeed);
      } else {
          wordIndex = (wordIndex + 1) % words.length;
          setTimeout(type, typingSpeed + 1100);
      }
  }

  type();
});


function toggleMenu() {
    document.querySelector(".navbar").classList.toggle("active");
}



// Animate progress bars
    const progressBars = document.querySelectorAll('.progress-done');

    progressBars.forEach(bar => {
        setTimeout(() => {
            bar.style.width = bar.getAttribute('data-done') + '%';
            bar.style.opacity = 1;
        }, 500);
    });

    // Animate circular skills
    const circles = document.querySelectorAll('.circle');

    circles.forEach(circle => {
        let percent = circle.getAttribute('data-percent');
        circle.style.setProperty('--percent', percent);
    });


    document.getElementById("submitBtn").addEventListener("click", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const submitBtn = document.getElementById("submitBtn");
    
        // Name Validation: Only uppercase (A-Z) and lowercase (a-z) letters
        const nameRegex = /^[A-Za-z]+$/;
        if (!nameRegex.test(name)) {
            alert("Invalid Name: Only letters (A-Z, a-z) are allowed.");
            return;
        }
    
        // Email Validation: Must have a proper format
        const emailRegex = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
        if (!emailRegex.test(email)) {
            alert("Invalid Email: Please enter a valid email address.");
            return;
        }
    
        // Extract domain from email
        const emailParts = email.split("@");
        if (emailParts.length !== 2 || emailParts[1].startsWith(".") || emailParts[1].endsWith(".")) {
            alert("Invalid Email: Domain must be properly formatted.");
            return;
        }
    
        const emailDomain = emailParts[1];
    
        // List of authorized domains (modify as needed)
        const allowedDomains = ["hotmail.com", "outlook.com", "gmail.com", "yahoo.com"];
    
        // Check if the domain is in the authorized list or ends with ".com"
        if (!allowedDomains.includes(emailDomain) && !emailDomain.endsWith(".com")) {
            alert("Unauthorized Email: Only .com, hotmail.com, and outlook.com domains are allowed.");
            return;
        }
    
        // Check if the email domain exists by verifying its MX records
        fetch(`https://dns.google/resolve?name=${emailDomain}&type=MX`)
            .then(response => response.json())
            .then(data => {
                if (!data.Answer || data.Answer.length === 0) {
                    alert("Invalid Email: The domain does not exist in the real world.");
                    return;
                }
    
                // If domain is valid, proceed with form submission
                fetch("/submit-data", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ name: name, email: email }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Success:", data);
                    submitBtn.innerText = "Message Sent";
                    submitBtn.disabled = true; // Disable button after success
                })
                .catch(error => console.error("Error:", error));
            })
            .catch(error => {
                console.error("Error checking domain:", error);
                alert("Error checking email domain.");
            });
    });
    
    
    
    
    document.addEventListener("DOMContentLoaded", function () {
        // Define your social media links
        const socialLinks = {
            github: "https://github.com/vigneshwaranimk",
            instagram: "https://www.instagram.com/keezhai_vignesh",
            linkedin: "https://www.linkedin.com/in/vigneshwaranimk/",
            resume: "/documents/Vigneshwaran_Resume.pdf"
        };
    
        // Assign links to the respective elements
        for (let platform in socialLinks) {
            let element = document.getElementById(platform);
            if (element) {
                element.href = socialLinks[platform];
            }
        }
    });
    $(document).ready(function(){
        $(".navbar a").on('click', function(event) {
          if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({ scrollTop: $(hash).offset().top }, 800);
          }
        });
      });

      //social links

    //   document.addEventListener("DOMContentLoaded", function () {
    //     document.getElementById("github").href = "https://github.com/vigneshwarananimk";
    //     document.getElementById("instagram").href = "https://www.instagram.com/keezhai_vignesh";
    //     document.getElementById("linkedin").href = "https://www.linkedin.com/in/vigneshwaranimk";
    // });



    document.getElementById("myForm").addEventListener("submit", function(event) {
        let isValid = true;

        // Name Validation (Only letters, at least 3 characters)
        let name = document.getElementById("name").value.trim();
        let nameError = document.getElementById("nameError");
        if (name.length < 3 || !/^[a-zA-Z\s]+$/.test(name)) {
            nameError.textContent = "Name must be at least 3 letters (only alphabets allowed).";
            isValid = false;
        } else {
            nameError.textContent = "";
        }

        // Email Validation (HTML5 built-in)
        let email = document.getElementById("email").value.trim();
        let emailError = document.getElementById("emailError");
        if (!email.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
            emailError.textContent = "Enter a valid email address.";
            isValid = false;
        } else {
            emailError.textContent = "";
        }

        // Subject Validation (Minimum 5 characters)
        let subject = document.getElementById("subject").value.trim();
        let subjectError = document.getElementById("subjectError");
        if (subject.length < 5) {
            subjectError.textContent = "Subject must be at least 5 characters long.";
            isValid = false;
        } else {
            subjectError.textContent = "";
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
    
    console.log("Script loaded successfully!");
