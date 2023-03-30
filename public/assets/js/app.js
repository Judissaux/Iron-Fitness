// Partie pour apparition progressive des élements page accueil et page coaching
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


// Partie pour la gestion du formulaire MODAL (Séance gratuite)
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
          window.location.href = '/'},
        error: function(jqXHR) {
          removeErrors();
          // Récupérer les erreurs renvoyées par Symfony
          const errors = JSON.parse(jqXHR.responseText);
          
          // Afficher les erreurs dans le modal
          for(const key in errors){
            let element = document.querySelector(`#free_session_${key}`);
            element.classList.add('is-invalid')
    
            let div = document.createElement('div');
            div.classList.add('invalid-feedback','d-block')

            // Permet d'afficher plusieurs erreurs les une aprés les autres
            if(errors[key].length>1){
                for(let error of errors[key]){
                  div.innerHTML += error + '<br>';
                }
              
            }else {
            div.innerText = errors[key];
            }    
            element.after(div);

            //Permet d'afficher correctement le message d'erreur aprés le calendrier
            if(key === "datePresence"){
              const datePresence = document.querySelector('.input');
              datePresence.insertAdjacentElement("afterend",div);
            }
        }
      }
    });
});        
   
 // Fonction qui permet de ne pas cumuler les erreurs à chaque fois que l'on clique    
const removeErrors = function () {
  const invalidFeedbackElements = document.querySelectorAll(".invalid-feedback");
  const isInvalidElements = document.querySelectorAll(".is-invalid");

  invalidFeedbackElements.forEach(invalidFeedback => invalidFeedback.remove());
  isInvalidElements.forEach(isInvalid => isInvalid.classList.remove('is-invalid'))
  
};   
 

// Mise en place du calendrier pour la séance gratuite
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



 

   



