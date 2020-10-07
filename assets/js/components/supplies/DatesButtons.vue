<template>
    <div>
        <div class="w3-container">
            <h5>kampdatums</h5>
        </div>
        <div
            class="w3-bar-block"
        >
            <button
                v-for="day in days"
                :key="day.date"
                class="w3-bar-item w3-button w3-border"
                v-on:click="day.isActive = !day.isActive, processClick()"
                v-bind:class="{ 'w3-blue': day.isActive  }"
                :disabled="day.isActive && isLastOne"
            >
                {{day.date}}
            </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import {SuppliesEventBus} from '../../supplies';
    import filter from '../../modules/filter';

    export default {
        name: "dates",
        data: function() {
            return{
                days: null,
                isLastOne: false
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
            processClick() {
                this.passData();
                this.isLastOne = filter.isLastActiveInArray(this.days);
            },
            passData() {
                SuppliesEventBus.$emit('passDays', this.days);
            }
        }
    }
</script>

<style scoped>
    .w3-bar-item.w3-button.w3-border {
        margin: 0px;
    }
</style>