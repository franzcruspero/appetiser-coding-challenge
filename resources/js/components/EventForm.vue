<template>
    <form novalidate class="md-layout" @submit.prevent="validateEvent">
        <md-card class="md-elevation-2 md-layout-item md-layout-item md-size-100 md-small-size-100">
            <md-card-header>
                <div class="md-title">
                    <md-icon>event</md-icon>
                    Event Form
                </div>
            </md-card-header>
            <md-card-content>
                <div class="md-layout md-gutter">
                    <div class="md-layout-item md-size-70 md-small-size-70">
                        <md-field :class="getValidationClass('eventName')">
                            <label for="eventName"> Event Name</label>
                            <md-input name="eventName" id="eventName" v-model="form.eventName" />
                            <span class="md-error" v-if="!$v.form.eventName.required">The Event Name is required</span>
                        </md-field>
                    </div>
                </div>
                <div class="md-layout">
                    <div class="md-layout-item md-size-35 md-small-size-70">
                        <md-datepicker :class="getValidationClass('startDate')" name="startDate" v-model="form.startDate" >
                            <label>Start date</label>
                            <span class="md-error" v-if="!$v.form.startDate.required">Start Date is required</span>
                        </md-datepicker>
                    </div>
                    <div class="md-layout-item md-size-35 md-small-size-70">
                        <md-datepicker :class="getValidationClass('endDate')" name="endDate" v-model="form.endDate">
                            <label>End date</label>
                            <span class="md-error" v-if="!$v.form.endDate.required">End date is required</span>
                            <span class="md-error" v-if="!$v.form.endDate.minValue">End date can not be before the start date.</span>
                        </md-datepicker>
                    </div>
                </div>
                <md-field :class="getValidationClass('days')" class="md-layout-item md-size-70 md-small-size-80">
                    <md-select v-model="form.days" name="days" placeholder="Select Days" multiple>
                        <md-option value="Monday"> Monday </md-option>
                        <md-option value="Tuesday"> Tuesday </md-option>
                        <md-option value="Wednesday"> Wednesday </md-option>
                        <md-option value="Thursday"> Thursday </md-option>
                        <md-option value="Friday"> Friday </md-option>
                        <md-option value="Saturday"> Saturday </md-option>
                        <md-option value="Sunday"> Sunday </md-option>
                    </md-select>
                    <span class="md-error" v-if="!$v.form.days.minValue"> Please pick at least one day. </span>
                </md-field>
                <md-card-actions>
                    <md-button type="submit" class="md-primary" v-if="isLoading">
                        <md-progress-spinner md-mode="indeterminate" :md-diameter="30" :md-stroke="3"></md-progress-spinner>
                    </md-button>
                    <md-button type="submit" class="md-raised md-primary" v-else>
                        Create Event
                    </md-button>
                </md-card-actions>
            </md-card-content>
            <md-snackbar md-position="left" :md-active.sync="showSnackbar" md-persistent>
                <span>Oops! You have selected days that are not in your selected dates.</span>
            </md-snackbar>
        </md-card>
    </form>
</template>

<script>
    import axios from 'axios'
    import moment from 'moment'
    import {validationMixin} from 'vuelidate'
    import {
        required,
        minLength,
        minValue
    } from 'vuelidate/lib/validators'

    export default {
        data() {
            let now = new Date()
            return {
                form: {
                    eventName: '',
                    startDate: now,
                    endDate: now    ,
                    days: []
                },
                isLoading: false,
                showSnackbar: false
            }
        },
        validations() {
            return {
                form: {
                    eventName: {
                        required
                    },
                    startDate: {
                        required,
                    },
                    endDate: {
                        required,
                        minValue: minValue(this.form.startDate)
                    },
                    days: {
                        required
                    }
                }
            }
        },
        methods: {
            getValidationClass (fieldName) {
                const field = this.$v.form[fieldName]
                if (field) {
                    return {
                        'md-invalid': field.$invalid && field.$dirty
                    }
                }
            },
            async validateEvent () {
                this.isLoading = true
                let dateArray = []
                let filteredDates = []

                this.$v.$touch()
                const days = this.form.days
                let startDate = moment(this.form.startDate)
                const stopDate = moment(this.form.endDate)
                while (startDate <= stopDate) {
                    dateArray.push(moment(startDate).format('dddd YYYY-MM-DD')) // formats date to include the specific day
                    startDate = moment(startDate).add(1, 'days')
                }
                const resultDates = days.map((day) => {
                    return dateArray.filter((date) => {
                        return date.includes(day)
                    })
                })
                resultDates.forEach((resultDate) => {
                    resultDate.map((date) => {
                        filteredDates.push(date)
                    })
                })
                if (filteredDates.length !== 0 && !this.$v.$invalid) {
                    await axios.post('/api/calendar', {
                        eventName: this.form.eventName,
                        startDate: moment(this.form.startDate).format('YYYY-MM-DD'),
                        endDate: moment(this.form.endDate).format('YYYY-MM-DD'),
                        filteredDates: filteredDates.toString()
                    })
                    this.$emit('handleCreateEvent', true)
                }
                else {
                    this.showSnackbar = true
                }
                this.isLoading = false
            }
        }
    }

</script>
