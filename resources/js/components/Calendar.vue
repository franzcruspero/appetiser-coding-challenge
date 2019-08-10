<template>
    <md-card class="md-elevation-6" >
        <EventForm v-on:handleCreateEvent="fireFetchEvent($event)"/>
        <md-card-content class="md-size-70 md-small-size-50">
            <div class='events-app'>
                <FullCalendar
                    class='events-app-calendar'
                    ref="fullCalendar"
                    defaultView="dayGridMonth"
                    themeSystem="bootstrap"
                    eventColor= "#448AFF"
                    eventTextColor="white"
                    allDay
                    :header="{
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    }"
                    :plugins="calendarPlugins"
                    :weekends="calendarWeekends"
                    :events="calendarEvents"
                />
            </div>
        </md-card-content>
    </md-card>
</template>

<script>
    import axios from 'axios'
    import moment from 'moment'
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import bootstrapPlugin from '@fullcalendar/bootstrap'

    import EventForm from './EventForm'

    export default {
        components: {
            EventForm,
            FullCalendar
        },
        data: function() {
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    bootstrapPlugin,
                    interactionPlugin
                ],
                calendarWeekends: true,
                calendarEvents: [],
                themeSystem: 'bootstrap',
                showSnackbar: false
            }
        },
        created() {
            console.log(this.$bvToast)
            this.fireFetchEvent()
        },
        methods: {
            toggleWeekends() {
                this.calendarWeekends = !this.calendarWeekends
            },
            async fireFetchEvent(value) {
                if (value) {
                    // success toaster
                    this.$bvToast.toast(`Your event has been saved.`, {
                        title: 'Success!',
                        autoHideDelay: 5000,
                        variant: 'success',
                        solid: true
                    })

                    this.calendarEvents = [] //reset calendarEvents array to null so that the calendar is cleared for every event created.

                    const eventData = await axios.get('api/calendar')
                    const finalDays = eventData.data.data.filteredDates.split(',')
                    const {data:{data:{eventName}}} = eventData
                    finalDays.forEach((data) => {
                        const formattedDate = moment(data).format('YYYY-MM-DD')
                        this.calendarEvents.push({
                            title: eventName,
                            start: `${formattedDate}`,
                            allDay: true
                        })
                    })
                }
                else {
                    return null
                }
            }
        }
    }
</script>

<style lang='scss'>
    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
    @import '~@fullcalendar/timegrid/main.css';
    @import '~@fullcalendar/bootstrap/main.css';

    .events-app {
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
    }
    .events-app-calendar {
        margin: 0 auto;
        max-width: 1000px;
    }
</style>
