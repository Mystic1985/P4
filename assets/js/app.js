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

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index == 0) {
      addTicket($container);
    } else {
      // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
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

        $('#p4_museumbundle_orders_customer_name').focus();
        $(function() {
          var lefocus;  
          $('input, textarea').focus( function() { 
            lefocus = '#' + $(this).attr('id');        
            $(lefocus).css('background-color', 'grey');
          }); 
          $('input, textarea').blur( function() { 
            leFocus = '#' + $(this).attr('id');        
            $(leFocus).css('background-color', '#fff');
          }); 
        });

        $(function() {
              var test =  $('<strong>Un justificatif vous sera demandé lors de votre arrivée</strong><br>').insertBefore($("#p4_museumbundle_orders_tickets_0_reduction"));
              test.hide();
            $("#p4_museumbundle_orders_tickets_0_reduction").click(function() {
            if($("#p4_museumbundle_orders_tickets_0_reduction").is(':checked')){
              test.show();
          }
          else{
            test.hide();
          }

          });
        });


      // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
      addDeleteLink($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {

      var enUrl = /en\/museum\/buy$/
      var urlComplet = document.location.href;
      if(enUrl.test(urlComplet))
      {
      // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger">Delete</a>');
      }
      else
      {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');
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