<template>
    <div>
        <div class="w3-container">
            <h5>rayons</h5>
        </div>
        <div
            class="w3-bar"
        >
            <button
                v-for="rayon in rayons"
                :key="rayon.name"
                class="w3-bar-item w3-button w3-border"
                v-on:click="rayon.isActive = !rayon.isActive, processClick()"
                v-bind:class="{ 'w3-blue': rayon.isActive  }"
                :disabled="rayon.isActive && isLastOne"
            >
                {{rayon.name}}
            </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import {SuppliesEventBus} from '../../supplies';
    import filter from '../../modules/filter';

    export default {
        name: "rayons",
        data: function() {
            return{
                rayons: null,
                isLastOne: false
            }
        },
        mounted () {
            axios
                .get(`/api/camp/rayons/${window.currentCamp}`)
                .then(response => {
                    this.rayons = response.data.map(function(el) {
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
                this.isLastOne = filter.isLastActiveInArray(this.rayons);
            },
            passData() {
                SuppliesEventBus.$emit('passRayons', this.rayons);
            }
        }
    }
</script>

<style scoped>
    .w3-bar-item.w3-button.w3-border {
        margin: 0px;
    }
</style>