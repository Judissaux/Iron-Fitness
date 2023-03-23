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