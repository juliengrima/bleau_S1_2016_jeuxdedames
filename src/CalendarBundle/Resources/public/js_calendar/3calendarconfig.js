$(document).ready(function() {

    var current_date_time = new Date();

    $('#calendar').fullCalendar({
        header: { // Contenu du header
            left: 'month, agendaWeek',
            center: 'title',
            right: 'today prev, next'
        },
        lang: 'fr',
        defaultView: 'month', // vue par default
        views: { // format d'affichage de la date en fonction des vue
            month: {
                titleFormat: 'MMMM YYYY'
            },
            agenda:{
                titleFormat: 'D MMM YYYY'
            }
        },
        firstDay: 1, // jour ou l'agenda commentce 1 = lundi, 2 = mardi , etc...
        weekNumbers: true, // affichage du numéro de la semaine en cour
        businessHours: { // heure de travail
            start: '09:00',
            end: '18:00',
            dow: [1, 2, 3, 4, 5]
        },
        handleWindowResize: true, // redimenssionne auto du calendrier en fonction de la width du navigateur
        weekends: true, // affichage des weekends
        allDaySlot: false, // recapitulatif de la journée en haut du calendar
        slotLabelFormat: 'HH:mm', // format de l'heure sur les slots
        timeFormat: 'HH:mm',
        minTime: "08:00:00", // heure de début du calendar
        maxTime: '20:00:00', // heure de fin du calendar
        scrollTime: '09:00:00', // heure sur laquelle le calendar pointe par default
        slotEventOverlap: false, // Les évènements ne se chevauchent pas
        height: 'auto',
        forceEventDuration: true, // on oblige le user à mettre une heure de fin à l'evenement

        events: Routing.generate('events'),

        dayClick: function(date) {
            if (date._d >= current_date_time){
                window.location = Routing.generate('events') + date.format() + '/new';
            }
        },

        eventRender: function(event, element, calEvent) {
            var editEvent = Routing.generate('events') + event.id + '/edit';
            element.each(function() {
                element.append(
                    '</br>' +
                    '<strong>' +
                    event.titre +
                    '</strong>'
                );
            })
        },

        eventClick:  function(calEvent){
            var day = moment(calEvent.start._d).format("dddd Do MMMM YYYY");
            var ponctuation = ' de ';
            var startTime = moment(calEvent.start._i).format('HH:mm à ');
            var endTime = moment(calEvent.end._i).format("HH:mm");
            var Time = 'Le ' + day + ponctuation + startTime + endTime;
            var editEvent = Routing.generate('events') + calEvent.id + '/edit';
            var deleteEvent = Routing.generate('events') + calEvent.id + '/delete';

            $('#modalTime').html(Time);
            $('#modalTitle').html( calEvent.titre );
            $('#modalBody').html( calEvent.contenu );
            $('#fullCalModal').modal();

            $('#delete_event').show();
            $('#delete_event').attr('href', deleteEvent);
            $('#edit_event').show();
            $('#edit_event').attr('href', editEvent);

        }
    });
});