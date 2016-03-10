$(document).ready(function() {
  console.log(sessionStorage.getItem('id'))
  if (sessionStorage.getItem('id')) {
    window.location.href = 'home.php';
  }
})
