/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
 let $ = require('jquery')

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');



require('select2')

$('select').select2()
let $contactButton = $('#contactButton');
$contactButton.click(e => {
  e.preventDefault()
  $('#contactForm').slideDown();
  $contactButton.slideUp();
})


// Suppression des éléments
document.querySelectorAll("[data-delete]").forEach(a => {
  a.addEventListener("click", e => {
    console.warn(a.getAttribute('href'))
    e.preventDefault()
    fetch(a.getAttribute("href"), {
      method: "DELETE",

      body: JSON.stringify({'_token': a.dataset.token})

    })
    .then(response => {return response.json()})

    .then(response => {
      if (data.success) {

      } else {
        alert(data.error)
      }
    })
    .catch(e => alert(e))
  })
})



// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
