/* eslint-disable no-unused-vars, no-undef */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

(function ($) {
    // Show all articles on initial load
    $('.article').show();

    // Add your team filter logic here
    $('.team-logo').on('click', function () {
        var teamId = $(this).data('team-id');
        console.log('Selected Team ID:', teamId);

        // Toggle visibility of articles based on the selected team
        $('.article').each(function () {
            var classes = $(this).attr('class').split(' ');
            var articleTeamId = '';

            // Find the class starting with 'team-'
            for (var i = 0; i < classes.length; i++) {
                if (classes[i].startsWith('team-')) {
                    articleTeamId = classes[i].substring(5);
                    break;
                }
            }

            var isDefaultTeam = $(this).hasClass('default-team');

            if ((articleTeamId == teamId || teamId === '') && !isDefaultTeam) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
})(jQuery);
