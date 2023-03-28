

const ratio = .1;

const options = {
    // En mettant null on observe l'ensemble 
    root: null,
    rootMargin: '0px',
    // % d'apparition de l'objet avant fonctionnement du reveal
    threshold: ratio
}

const handleIntersect = (entries,observer)=> {
    entries.forEach(entry => {
        if(entry.intersectionRatio > ratio){
            
            entry.target.classList.remove('reveal')
            //Permet d'arrêter l'observation
            observer.unobserve(entry.target)        }
       
    });
    
}
document.documentElement.classList.add('reveal-loaded')
window.addEventListener('DOMContentLoaded' , function (){
const observer = new IntersectionObserver(handleIntersect, options)
document.querySelectorAll('.reveal').forEach(r => {
    observer.observe(r)
    })
})

const csrf_token = $("input[name='_csrfToken']").val();
$(document).on('submit', '#FreeSession', function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire
    const formData = $(this).serialize(); // Récupère les données du formulaire

    $.ajax({
        beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-Token', csrf_token)},
        url: '/traitement-formulaire-ajax', // URL de traitement du formulaire
        type: 'POST',
        data: formData,
        success: function(data) {
                // Code exécuté après la soumission réussie du formulaire
                // Fermer la fenêtre modale en masquant l'élément HTML
                window.location.href = '/';
              
        },
        error: function(jqXHR, textStatus, errorThrown) {
           
        }
     })
 })
 


 flatpickr(".js-datepicker", {
    locale: "fr",
    disable: [
      function(date) {
        // Désactiver les dimanches
        return date.getDay() === 0;
      },
      function(date) {
        // Désactiver les dates antérieures à la date actuelle
        return date < new Date();
      }
    ],    
    altInput: true,
    altFormat: "d-m-Y",
    
    
    
   
   
    
  });

   



