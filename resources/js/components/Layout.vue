<template>
    <md-content class="md-elevation-1">
        <Calendar>
            <EventForm />
        </Calendar>
    </md-content>
</template>

<script>
import EventForm from './EventForm'
import Calendar from './Calendar'
    export default {
        components: {
            EventForm,
            Calendar
        }
    }
</script>

