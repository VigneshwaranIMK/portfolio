document.addEventListener("DOMContentLoaded", function () {
  const words = ["Web Developer", "Web Designer", "Frontend Developer"];
  let wordIndex = 0;
  let charIndex = 0;
  let currentWord = "";
  const typingSpeed = 100;
  const erasingSpeed = 50;
  const newWordDelay = 2000;

  function type() {
    if (charIndex < words[wordIndex].length) {
      currentWord += words[wordIndex].charAt(charIndex);
      document.querySelector(".typing-animation").textContent = currentWord;
      charIndex++;
      setTimeout(type, typingSpeed);
    } else {
      setTimeout(erase, newWordDelay);
    }
  }

  function erase() {
    if (charIndex > 0) {
      currentWord = currentWord.slice(0, -1);
      document.querySelector(".typing-animation").textContent = currentWord;
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
const progressBars = document.querySelectorAll(".progress-done");

progressBars.forEach((bar) => {
  setTimeout(() => {
    bar.style.width = bar.getAttribute("data-done") + "%";
    bar.style.opacity = 1;
  }, 500);
});

// Animate circular skills
const circles = document.querySelectorAll(".circle");

circles.forEach((circle) => {
  let percent = circle.getAttribute("data-percent");
  circle.style.setProperty("--percent", percent);
});

document.addEventListener("DOMContentLoaded", function () {
  // Define your social media links
  const socialLinks = {
    github: "https://github.com/vigneshwaranimk",
    instagram: "https://www.instagram.com/keezhai_vignesh",
    linkedin: "https://www.linkedin.com/in/vigneshwaranimk/",
    resume: "/documents/Vigneshwaran_Resume.pdf",
  };

  // Assign links to the respective elements
  for (let platform in socialLinks) {
    let element = document.getElementById(platform);
    if (element) {
      element.href = socialLinks[platform];
    }
  }
});

$(document).ready(function () {
  $(".navbar a").on("click", function (event) {
    const hash = this.hash;

    if (hash !== "") {
      const $target = $(hash);

      if ($target.length > 0) {
        event.preventDefault();
        $("html, body").animate(
          {
            scrollTop: $target.offset().top,
          },
          800
        );
      } else {
        console.warn("No target found for:", hash);
      }
    }
  });
});


//Particles Script



    
console.log("Script loaded successfully!");
