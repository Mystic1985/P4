require('../css/app.scss');

  $(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#p4_museumbundle_orders_tickets');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
      addTicket($container);

      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un.
    if (index == 0) {
      addTicket($container);
    } else {
      // S'il existe déjà des billets, on ajoute un lien de suppression pour chacun d'entre eux
      $container.children('div').each(function() {
        addDeleteLink($(this));
        }
      );
    }

    //Ajout d'un formulaire TicketType
    function addTicket($container) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Billet')
        .replace(/__name__/g,        index)
      ;

      // On crée un objet jquery qui contient ce template
      var $prototype = $(template);

      // On ajoute au prototype un lien pour pouvoir supprimer le billet
      addDeleteLink($prototype);
      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      var enUrl = /en\/museum\/buy$/
      var urlComplet = document.location.href;
      // Création du lien sous forme de bouton
      if(enUrl.test(urlComplet))
      {
        var justificatif = $("<div>A proof will be required when presenting your ticket.</div>");
      }
      else
      {
        var justificatif = $("<div>Un justificatif vous sera demandé lors de la présentation de votre billet.</div>")
      }
      //justificatif.css('color', 'red');
      justificatif.css('color', 'red');

      $prototype.find('.form-check-input').click(function(){
        if($(this).is(":checked")){
          justificatif.insertBefore($(this));
        }
        else {
          justificatif.remove();
        }
    });

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
    }

    // La fonction qui ajoute un lien de suppression d'un billet
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
  });