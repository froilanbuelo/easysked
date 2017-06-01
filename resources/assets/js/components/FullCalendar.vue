<template>
    <div id="calendar"></div>
</template>

<script>
require('fullcalendar');

export default {
    props: [], //alll the props
    data() {
        return {
            //all the data
        }
    },
    mounted() {
        var self = this;
        Vue.nextTick(function() {
            $('#calendar').fullCalendar({
                defaultView: 'agendaWeek',
                editable: true,
                navLinks: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    var title = prompt('Event Title:');
                    var eventData;
                    if (title) {
                        eventData = {
                            title: title,
                            start: start,
                            end: end
                        };
                        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                    }
                    $('#calendar').fullCalendar('unselect');
                },
                events: [
                    {
                        start: '2017-05-27T10:00:00',
                        end: '2017-05-27T16:00:00',
                    }
                ],
                constraint: {
                    start: '2017-05-29T10:00:00',
                    end: '2017-05-29T22:00:00'
                }
            });
        });
    }
}
</script>

<style src="fullcalendar/dist/fullcalendar.css"></style>