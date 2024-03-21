// pre loading animation
window.addEventListener("load", () => {
  const loader = document.querySelector(".loader");
  loader.classList.add("loader-hidden");
  loader.addEventListener("transitionend", () => {
    if (document.body.contains(loader)) {
      document.body.removeChild(loader);
    }
  });
});

// year
const dataAtual = new Date();
        const anoAtual = dataAtual.getFullYear();
        document.getElementById("year").innerHTML = anoAtual;

// scroll effect
const target = document.querySelectorAll('[data-anime]');
const animationClass = 'animate';
function animeScroll(element) {
  const windowTop = window.scrollY + (window.innerHeight * 0.95);
  target.forEach(function (element) {
    if (windowTop > element.offsetTop) {
      element.classList.add(animationClass);
    }

  });
}

animeScroll(target);

function debounce(func, wait, immediate) {
  let timeoutId;

  return function (...args) {
    clearTimeout(timeoutId);

    timeoutId = setTimeout(() => {
      func.apply(this, args);
    }, delay);
  };
}

if(target.length) {
  window.addEventListener('scroll', function() {
    animeScroll();
    console.log()
  })
}

window.addEventListener('scroll', function() {
  animeScroll(target);
})

// // facts counting effect
// let countingStarted = false;
// function startCounting() {
//   let valueDisplays = document.querySelectorAll(".num");
//   let interval = 5000;
//   valueDisplays.forEach((valueDisplay) => {
//     let startValue = 0;
//     let endValue = parseInt(valueDisplay.getAttribute("data-val"));
//     let duration = Math.floor(interval / endValue);
//     let counter = setInterval(function () {
//       startValue += 1;
//       valueDisplay.textContent = startValue;
//       if (startValue >= endValue) {
//         clearInterval(counter);
//       }
//     }, duration);
//   });
// }

// window.addEventListener("scroll", () => {
//   let factsDiv = document.querySelector('.facts');
//   let factsHeight = factsDiv.offsetHeight;
//   if (window.scrollY >= factsHeight && !countingStarted) {
//     startCounting();
//     countingStarted = true;
//   }
// });


// menu mobile
let btnMobile = document.getElementById('menu-btn'); 
const html = document.getElementsByTagName('html')[0]; 

function toggleMenu(event) {
  if (event.type === 'touchstart') event.preventDefault();
  const menu = document.getElementById('menu');

  menu.classList.toggle('active');
  html.classList.toggle('active');
}

btnMobile.addEventListener('click', toggleMenu);

btnMobile.addEventListener('touchstart', toggleMenu);

//scroll up
let whats = document.querySelector('.whats'); 
let scrollup = document.querySelector('.scroll-up-btn')

window.addEventListener('scroll', function(){
  
  if(this.window.scrollY > 350){
    scrollup.classList.add('show');
    whats.style.bottom = '145px';
  }else{
    scrollup.classList.remove('show');
    whats.style.bottom = '60px';
  }

});

scrollup.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: "smooth"
    });
});

//testimonials
// let testSlide = document.querySelectorAll('.testItem');

// let dots = document.querySelectorAll('.dot');

// var counter = 0;

// Add click event to the indicators
// function switchTest(currentTest){
//   currentTest.classList.add('active');
//   var testId = currentTest.getAttribute('attr');
//   if(testId > counter){
//     testSlide[counter].style.animation = 'next1 0.5s ease-in forwards';
//     counter = testId;
//     testSlide[counter].style.animation = 'next2 0.5s ease-in forwards';
//   }
//   else if(testId == counter){return;}
//   else{
//     testSlide[counter].style.animation = 'prev1 0.5s ease-in forwards';
//     counter = testId;
//     testSlide[counter].style.animation = 'prev2 0.5s ease-in forwards';
//   }
//   indicators();
// }

// Add and remove active class from the indicators
// function indicators(){
//   for(i = 0; i < dots.length; i++){
//     dots[i].className = dots[i].className.replace(' active', '');
//   }
//   dots[counter].className += ' active';
// }

// Code for auto sliding
// function slideNext(){
//   testSlide[counter].style.animation = 'next1 0.5s ease-in forwards';
//   if(counter >= testSlide.length - 1){
//     counter = 0;
//   }
//   else{
//     counter++;
//   }
//   testSlide[counter].style.animation = 'next2 0.5s ease-in forwards';
//   indicators();
// }
// function autoSliding(){
//   deleteInterval = setInterval(timer, 3000);
//   function timer(){
//     slideNext();
//     indicators();
//   }
// }
// autoSliding();

// Stop auto sliding when mouse is over the indicators
// const container = document.querySelector('.indicators');
// container.addEventListener('mouseover', pause);
// function pause(){
//   clearInterval(deleteInterval);
// }

// Resume sliding when mouse is out of the indicators
// container.addEventListener('mouseout', autoSliding);

//contact-form
function validateEmail(email) {
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return regex.test(email);
}
function showErrorMessage(message) {
  var errorMessageContainer = document.getElementById('errorMessageContainer');
  errorMessageContainer.innerHTML = `<p>${message}</p><button type="button" class="solicite" onclick="closeErrorMessage()">Fechar</button>`;
  errorMessageContainer.style.display = 'flex';
  if (errorMessageContainer.classList.contains('hidden')) {
    errorMessageContainer.classList.remove('hidden');
  }
}
function closeErrorMessage() {
  var errorMessageContainer = document.getElementById('errorMessageContainer');
  errorMessageContainer.classList.add('hidden');
}
function submitForm() {
  var name = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var message = document.getElementById('message').value;
  var mensagem = document.querySelector('.mensagem');
  if (name.trim() === '' || email.trim() === '' || message.trim() === '') {
      showErrorMessage('Por favor, preencha todos os campos para enviar sua mensagem.');
      return;
  }
  if (!validateEmail(email) || email.indexOf('@') === -1) {
    showErrorMessage('Por favor, insira um e-mail válido no formato "seu-email@email.com".');
    return;
  }

  var formData = {
      name: name,
      email: email,
      message: message
  };

  const formDataJson = JSON.stringify(formData);

  console.log(formDataJson);

  const xhr = new XMLHttpRequest();

  xhr.open("POST", "sendEmail.php");
  xhr.setRequestHeader('Content-Type', 'application/json');

  // Lidando com a resposta da requisição AJAX
  xhr.onload = function() {
    if (xhr.status >= 200 && xhr.status < 300) {
      // Sucesso - fazer algo com a resposta
      var response = JSON.parse(xhr.responseText);
      if (response.status === 'success') {
        console.log('Mensagem enviada.');

      } else {
        // Alguma coisa deu errado - exibir mensagem de erro
        console.error('Erro ao enviar a requisição AJAX: ' + response.message);
      }
    } else {
      // Erro de requisição
      console.error('Erro ao enviar a requisição AJAX: ' + xhr.status);
    }
  };

  xhr.onerror = function() {
    // Erro de rede
    console.error('Erro de rede ao enviar a requisição AJAX');
  };

  xhr.send(formDataJson);
  
  document.getElementById('myForm').style.display = 'none';

  setTimeout(function () {
      mensagem.classList.add('show');
  }, 500);
}

      