require('../css/app.scss');

        const addTicketBtn = document.querySelector("#addTicket")

        addTicketBtn.addEventListener('click', (e) => {
            e.preventDefault()

            const list = document.querySelector(addTicketBtn.dataset.template)
            let counter = list.dataset.counter | list.children.length

            let newTicket = list.dataset.prototype
            newTicket = newTicket.replace(/__name__/g, counter)
            counter++

            list.dataset.counter = counter

            const ticketElement = document.createElement(list.dataset.widgetTags)

            ticketElement.innerHTML = newTicket
            // Création du bouton de suppression d'un ticket
            const deleteElement = document.createElement('INPUT')
            deleteElement.setAttribute("type", "button")
            deleteElement.id = "suppr"
            deleteElement.className = "btn btn-danger"

            var enUrl = /en\/museum\/buy$/
            var urlComplet = document.location.href;

            if(enUrl.test(urlComplet))
            {
              deleteElement.setAttribute("value", "Delete")
            }
            else
            {
              deleteElement.setAttribute("value", "Supprimer")
            }
            
            ticketElement.appendChild(deleteElement)

            list.appendChild(ticketElement)
            // Evènement au clic du bouton
            deleteElement.addEventListener('click', (e) => {
              const current = e.target
              current.parentNode.remove()
            });
            
            // Création du message d'information quand la checkbox "Reduction" est cochée
            const newNode = document.createElement('div')
            newNode.innerHTML = "test"

            // Fonction d'affichage de l'élément crée lors du clic sur la checkbox
            ticketElement.querySelector('.form-check-input').addEventListener('click', (e) => {
                const current = e.target // = checkbox
              if(ticketElement.querySelector('.form-check-input').checked === true){
                current.parentNode.insertBefore(newNode, current);
              }
              else {
                current.parentNode.removeChild(newNode);
              }
            });
        });

  /*$(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.

    var $container = $('div#command_tickets_list');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#addTicket').click(function(e) {
      addTicket($container);

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });

    // On ajoute un premier billet automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index == 0) {
      addTicket($container);
    } else {
      // S'il existe déjà un billet, on ajoute un lien de suppression pour chacune d'entre elles
      $container.children('div').each(function() {
        addDeleteLink($(this));
      });
    }

    //Ajout d'un formulaire TicketType
    function addTicket($container) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Billet n°' + (index+1))
        .replace(/__name__/g,        index)
      ;

      // On crée un objet jquery qui contient ce template
      var $prototype = $(template);

      // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
      addDeleteLink($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      /*$('.form-check-input').click(function(){
        $("<div><strong>Test</strong></div>").append($('.form-check-input'));
      });*/

      /*ticketElement.querySelector('.form-check-input').addEventListener('click', (e)*/

      /*$('<strong>test</strong><br />').insertBefore($('.form-check-input'));*/

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      /*index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
      // Vérification de l'url pour déterminer la langue du bouton
      var enUrl = /en\/museum\/buy$/
      var urlComplet = document.location.href;
      // Création du lien sous forme de bouton
      if(enUrl.test(urlComplet))
      {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Delete</a>');
      }
      else
      {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a><br />');
      }

      // Ajout du lien
      $prototype.append($deleteLink);

      // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
      $deleteLink.click(function(e) {
        $prototype.remove();

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
    }
  });*/