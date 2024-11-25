// AOS initialization
$(document).ready(function(){
    AOS.init();
  });
  
  // Get the doctor wrapper
const doctorWrapper = document.getElementById('doctorWrapper');
let isDown = false;
let startX;
let scrollLeft;

// Disable text selection during drag
doctorWrapper.addEventListener('mousedown', (e) => {
  isDown = true;
  doctorWrapper.classList.add('active');
  startX = e.pageX - doctorWrapper.offsetLeft;
  scrollLeft = doctorWrapper.scrollLeft;
  
  // Disable text selection while dragging
  document.body.style.userSelect = 'none';
});

doctorWrapper.addEventListener('mouseleave', () => {
  isDown = false;
  doctorWrapper.classList.remove('active');
  
  // Re-enable text selection after drag
  document.body.style.userSelect = '';
});

doctorWrapper.addEventListener('mouseup', () => {
  isDown = false;
  doctorWrapper.classList.remove('active');
  
  // Re-enable text selection after drag
  document.body.style.userSelect = '';
});

doctorWrapper.addEventListener('mousemove', (e) => {
  if (!isDown) return;  // Stop if not holding mouse
  e.preventDefault();
  const x = e.pageX - doctorWrapper.offsetLeft;
  const walk = (x - startX) * 2; // Adjust scrolling speed
  doctorWrapper.scrollLeft = scrollLeft - walk;
});


// Function to show or hide the button based on scroll position
function toggleScrollToTopButton() {
  const button = document.getElementById('scrollTopBtn');
  if (window.scrollY > 200) {
    button.style.display = 'flex';
  } else {
    button.style.display = 'none';
  }
}

// Function to scroll to the top of the page
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

// Script for Sorting Option
document.querySelector('select').addEventListener('change', function() {
  const sortOption = this.value;
  // Add sorting functionality based on sortOption
  console.log('Selected sorting option: ', sortOption);
});

// Add your custom JavaScript or jQuery code for the shop interaction here



document.querySelectorAll('.product-item').forEach(item => {
  item.addEventListener('mouseenter', () => {
    item.classList.add('hovered');
  });
  item.addEventListener('mouseleave', () => {
    item.classList.remove('hovered');
  });
});


document.addEventListener('DOMContentLoaded', function() {
  // Range slider functionality
  var rangeSlider = document.getElementById('rangeSlider');
  var rangeSliderResult = document.getElementById('rangeSliderResult');
  
  rangeSlider.addEventListener('input', function() {
      rangeSliderResult.value = rangeSlider.value;
  });
});
