<template>
    <div>
        <div class="w3-container">
            <h5>kampdatums</h5>
        </div>
        <div
            class="w3-bar-block"
            v-for="day in days"
            :key="day.date"
        >
            <a
                class="w3-bar-item w3-margin-bottom w3-button w3-border"
                v-on:click="day.isActive = !day.isActive, passData()"
                v-bind:class="{ 'w3-blue': day.isActive  }"
            >
                {{day.date}}
            </a>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import {SuppliesEventBus} from '../../supplies';

    export default {
        name: "dates",
        data: function() {
            return{
                days: null,
            }
        },
        mounted () {
            axios
                .get(`/api/camp/campdays/${window.currentCamp}`)
                .then(response => {
                    this.days = response.data.map(function(el) {
                        var obj = Object.assign({}, el);
                        obj.isActive = true;
                        return obj;
                    })
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.passData();
                })
        },
        methods: {
            passData() {
                SuppliesEventBus.$emit('passDays', this.days);
            }
        }
    }
</script>

<style scoped>
</style>