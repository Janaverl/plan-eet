<template>
    <div>
        <div class="w3-container">
            <h5>rayons</h5>
        </div>
        <a
            v-for="rayon in rayons"
            :key="rayon.name"
            class="w3-margin w3-button w3-border"
            v-on:click="rayon.isActive = !rayon.isActive, passData()"
            v-bind:class="{ 'w3-blue': rayon.isActive  }"
        >
            {{rayon.name}}
        </a>
    </div>
</template>

<script>
    import axios from 'axios';
    import {SuppliesEventBus} from '../../supplies';

    export default {
        name: "rayons",
        data: function() {
            return{
                rayons: null
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
            passData() {
                SuppliesEventBus.$emit('passRayons', this.rayons);
            }
        }
    }
</script>

<style scoped>
</style>